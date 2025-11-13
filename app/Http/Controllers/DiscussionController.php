<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Discussion;
use App\Models\DiscussionReply;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    // Halaman utama diskusi
    public function index(Request $request)
    {
        $query = Discussion::with(['user']);

        // Search by keyword
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('related_keywords', 'like', "%{$search}%");
            });
        }

        // Filter by letter
        if ($request->has('letter') && !empty($request->letter)) {
            $letter = $request->letter;
            $query->where('title', 'like', "{$letter}%");
        }

        $discussions = $query->latest('last_reply_at')
            ->latest('created_at')
            ->paginate(20);

        return view('discussions.index', compact('discussions'));
    }

    // Diskusi terkait artikel tertentu (berdasarkan keywords)
    public function articleDiscussions($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        
        // Cari diskusi berdasarkan keywords artikel
        $keywords = explode(',', $article->keywords);
        $discussions = Discussion::with(['user'])
            ->where(function($query) use ($keywords, $article) {
                foreach ($keywords as $keyword) {
                    $keyword = trim($keyword);
                    if (!empty($keyword)) {
                        $query->orWhere('title', 'like', "%{$keyword}%")
                              ->orWhere('content', 'like', "%{$keyword}%")
                              ->orWhere('related_keywords', 'like', "%{$keyword}%");
                    }
                }
                // Juga cari berdasarkan judul artikel
                $query->orWhere('title', 'like', "%{$article->title}%");
            })
            ->latest('last_reply_at')
            ->latest('created_at')
            ->paginate(20);

        return view('discussions.article', compact('article', 'discussions'));
    }

    // Detail diskusi
    public function show($id)
    {
        $discussion = Discussion::with(['user', 'replies.user', 'replies.replies.user'])
            ->findOrFail($id);

        return view('discussions.show', compact('discussion'));
    }

    // Form buat diskusi baru
    public function create(Request $request)
    {
        return view('discussions.create');
    }

    // Simpan diskusi baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'related_keywords' => 'nullable|string',
        ]);

        $discussion = Discussion::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'content' => $request->content,
            'related_keywords' => $request->related_keywords,
            'last_reply_at' => now(),
        ]);

        return redirect()->route('discussions.show', $discussion->id)
            ->with('success', 'Pertanyaan berhasil dibuat!');
    }

    // Balas diskusi
    public function reply(Request $request, $id)
    {
        $request->validate([
            'content' => 'required',
            'parent_id' => 'nullable|exists:discussion_replies,id',
        ]);

        $discussion = Discussion::findOrFail($id);

        $reply = DiscussionReply::create([
            'discussion_id' => $discussion->id,
            'user_id' => auth()->id(),
            'parent_id' => $request->parent_id,
            'content' => $request->content,
        ]);

        // Update counter dan last reply
        $discussion->increment('replies_count');
        $discussion->update(['last_reply_at' => now()]);

        return back()->with('success', 'Balasan berhasil ditambahkan!');
    }

    // Hapus diskusi (hanya pemilik)
    public function destroy($id)
    {
        $discussion = Discussion::findOrFail($id);

        if ($discussion->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $discussion->delete();

        return redirect()->route('discussions.index')
            ->with('success', 'Diskusi berhasil dihapus!');
    }

    // Hapus balasan (hanya pemilik)
    public function destroyReply($id)
    {
        $reply = DiscussionReply::findOrFail($id);

        if ($reply->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $discussion = $reply->discussion;
        $reply->delete();

        // Update counter
        $discussion->decrement('replies_count');

        return back()->with('success', 'Balasan berhasil dihapus!');
    }
}
