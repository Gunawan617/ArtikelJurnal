import { Head } from '@inertiajs/react';
import Layout from '@/Layouts/Layout';
import { useEffect, useState } from 'react';
import axios from 'axios';

export default function Show({ article }) {
    const [comments, setComments] = useState([]);
    const [newComment, setNewComment] = useState('');

    useEffect(() => {
        fetchComments();
    }, []);

    const fetchComments = async () => {
        const res = await axios.get(`/api/articles/${article.slug}/comments`);
        setComments(res.data);
    };

    const handleSubmitComment = async (e) => {
        e.preventDefault();
        try {
            await axios.post(`/api/articles/${article.slug}/comment`, {
                content: newComment
            });
            setNewComment('');
            fetchComments();
            alert('Komentar berhasil dikirim dan menunggu persetujuan admin');
        } catch (error) {
            alert('Silakan login terlebih dahulu');
        }
    };

    const citationMeta = {
        citation_title: article.title,
        citation_author: article.author,
        citation_publication_date: article.published_at,
        citation_pdf_url: article.pdf_path ? `/storage/${article.pdf_path}` : '',
        citation_abstract_html_url: window.location.href,
    };

    const jsonLd = {
        "@context": "https://schema.org",
        "@type": "ScholarlyArticle",
        "headline": article.title,
        "author": { "name": article.author },
        "datePublished": article.published_at,
        "abstract": article.abstract,
        "keywords": article.keywords,
        "citation": article.references?.map(ref => ({
            "@type": "CreativeWork",
            "name": ref.title,
            "author": { "name": ref.author },
            "datePublished": ref.year,
            "url": ref.doi ? `https://doi.org/${ref.doi}` : ref.url
        })) || []
    };

    return (
        <Layout>
            <Head title={article.title}>
                <meta name="description" content={article.abstract.substring(0, 160)} />
                <meta name="citation_title" content={citationMeta.citation_title} />
                <meta name="citation_author" content={citationMeta.citation_author} />
                <meta name="citation_publication_date" content={citationMeta.citation_publication_date} />
                <meta name="citation_pdf_url" content={citationMeta.citation_pdf_url} />
                <meta name="citation_abstract_html_url" content={citationMeta.citation_abstract_html_url} />
                <script type="application/ld+json">
                    {JSON.stringify(jsonLd)}
                </script>
            </Head>

            <div className="max-w-4xl mx-auto px-4 py-8">
                {/* Header Artikel */}
                <article className="bg-white rounded-lg shadow-sm p-8 mb-6">
                    <h1 className="text-3xl font-bold text-gray-900 mb-4">{article.title}</h1>
                    
                    <div className="flex items-center text-sm text-gray-600 mb-6">
                        <span className="font-medium">{article.author}</span>
                        <span className="mx-2">•</span>
                        <span>{new Date(article.published_at).toLocaleDateString('id-ID')}</span>
                    </div>

                    {article.image_path && (
                        <img 
                            src={`/storage/${article.image_path}`} 
                            alt={article.title}
                            className="w-full h-64 object-cover rounded-lg mb-6"
                        />
                    )}

                    <div className="prose max-w-none">
                        <h2 className="text-xl font-semibold text-gray-900 mb-3">Abstrak</h2>
                        <p className="text-gray-700 leading-relaxed mb-4">{article.abstract}</p>
                        
                        <div className="bg-blue-50 p-4 rounded-lg mb-6">
                            <p className="text-sm text-gray-700">
                                <strong>Kata Kunci:</strong> {article.keywords}
                            </p>
                        </div>
                    </div>

                    {article.pdf_path && (
                        <a 
                            href={`/storage/${article.pdf_path}`}
                            target="_blank"
                            className="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                        >
                            📄 Download PDF
                        </a>
                    )}
                </article>

                {/* Daftar Referensi */}
                {article.references && article.references.length > 0 && (
                    <section className="bg-white rounded-lg shadow-sm p-8 mb-6">
                        <h2 className="text-2xl font-bold text-gray-900 mb-4">Daftar Referensi</h2>
                        <ol className="list-decimal list-inside space-y-3">
                            {article.references.map((ref, index) => (
                                <li key={index} className="text-gray-700">
                                    {ref.author} ({ref.year}). <em>{ref.title}</em>.
                                    {ref.journal && <span> {ref.journal}.</span>}
                                    {ref.doi && (
                                        <span> DOI: <a href={`https://doi.org/${ref.doi}`} className="text-blue-600 hover:underline" target="_blank">{ref.doi}</a></span>
                                    )}
                                    {ref.url && !ref.doi && (
                                        <span> <a href={ref.url} className="text-blue-600 hover:underline" target="_blank">Link</a></span>
                                    )}
                                </li>
                            ))}
                        </ol>
                    </section>
                )}

                {/* Komentar */}
                <section className="bg-white rounded-lg shadow-sm p-8">
                    <h2 className="text-2xl font-bold text-gray-900 mb-6">Diskusi</h2>
                    
                    <form onSubmit={handleSubmitComment} className="mb-8">
                        <textarea
                            value={newComment}
                            onChange={(e) => setNewComment(e.target.value)}
                            placeholder="Tulis komentar Anda..."
                            className="w-full p-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            rows="4"
                            required
                        />
                        <button 
                            type="submit"
                            className="mt-3 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                        >
                            Kirim Komentar
                        </button>
                    </form>

                    <div className="space-y-6">
                        {comments.map(comment => (
                            <div key={comment.id} className="border-l-4 border-blue-200 pl-4">
                                <div className="flex items-center mb-2">
                                    <span className="font-semibold text-gray-900">{comment.user.name}</span>
                                    <span className="mx-2 text-gray-400">•</span>
                                    <span className="text-sm text-gray-500">
                                        {new Date(comment.created_at).toLocaleDateString('id-ID')}
                                    </span>
                                </div>
                                <p className="text-gray-700 mb-3">{comment.content}</p>
                                
                                {comment.replies && comment.replies.length > 0 && (
                                    <div className="ml-6 mt-4 space-y-4">
                                        {comment.replies.map(reply => (
                                            <div key={reply.id} className="border-l-2 border-gray-200 pl-4">
                                                <div className="flex items-center mb-2">
                                                    <span className="font-semibold text-gray-900">{reply.user.name}</span>
                                                    <span className="mx-2 text-gray-400">•</span>
                                                    <span className="text-sm text-gray-500">
                                                        {new Date(reply.created_at).toLocaleDateString('id-ID')}
                                                    </span>
                                                </div>
                                                <p className="text-gray-700">{reply.content}</p>
                                            </div>
                                        ))}
                                    </div>
                                )}
                            </div>
                        ))}
                    </div>
                </section>
            </div>
        </Layout>
    );
}
