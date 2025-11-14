<?php

namespace App\Http\Controllers;

use App\Models\UserReport;
use App\Models\Discussion;
use App\Models\DiscussionReply;
use Illuminate\Http\Request;

class UserReportController extends Controller
{
    // Report discussion atau reply
    public function store(Request $request)
    {
        $request->validate([
            'reportable_type' => 'required|in:discussion,reply',
            'reportable_id' => 'required|integer',
            'reason' => 'required|string|max:1000',
        ]);

        // Cek apakah user di-ban
        if (auth()->user()->is_banned) {
            return back()->with('error', 'Akun Anda telah di-banned.');
        }

        // Ambil reportable item dan reported user
        if ($request->reportable_type === 'discussion') {
            $reportable = Discussion::findOrFail($request->reportable_id);
            $reportedUserId = $reportable->user_id;
        } else {
            $reportable = DiscussionReply::findOrFail($request->reportable_id);
            $reportedUserId = $reportable->user_id;
        }

        // Cek apakah sudah pernah report
        $existingReport = UserReport::where('reporter_id', auth()->id())
            ->where('reportable_type', $request->reportable_type === 'discussion' ? Discussion::class : DiscussionReply::class)
            ->where('reportable_id', $request->reportable_id)
            ->where('status', 'pending')
            ->first();

        if ($existingReport) {
            return back()->with('error', 'Anda sudah melaporkan konten ini sebelumnya.');
        }

        UserReport::create([
            'reporter_id' => auth()->id(),
            'reported_user_id' => $reportedUserId,
            'reportable_type' => $request->reportable_type === 'discussion' ? Discussion::class : DiscussionReply::class,
            'reportable_id' => $request->reportable_id,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Laporan berhasil dikirim. Admin akan meninjau laporan Anda.');
    }
}
