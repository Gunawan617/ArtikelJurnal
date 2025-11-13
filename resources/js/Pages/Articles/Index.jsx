import { Head, Link } from '@inertiajs/react';
import Layout from '@/Layouts/Layout';
import { useEffect, useState } from 'react';
import axios from 'axios';

export default function Index() {
    const [articles, setArticles] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        axios.get('/api/articles')
            .then(res => {
                setArticles(res.data.data);
                setLoading(false);
            });
    }, []);

    if (loading) {
        return <Layout><div className="text-center py-20">Loading...</div></Layout>;
    }

    return (
        <Layout>
            <Head title="Artikel Ilmiah" />
            
            <div className="max-w-6xl mx-auto px-4 py-8">
                <h1 className="text-3xl font-bold text-gray-900 mb-8">Artikel Ilmiah</h1>
                
                <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {articles.map(article => (
                        <Link 
                            key={article.id} 
                            href={`/artikel/${article.slug}`}
                            className="bg-white rounded-lg shadow-sm hover:shadow-md transition overflow-hidden"
                        >
                            {article.image_path && (
                                <img 
                                    src={`/storage/${article.image_path}`}
                                    alt={article.title}
                                    className="w-full h-48 object-cover"
                                />
                            )}
                            <div className="p-5">
                                <h2 className="text-xl font-semibold text-gray-900 mb-2 line-clamp-2">
                                    {article.title}
                                </h2>
                                <p className="text-sm text-gray-600 mb-3">{article.author}</p>
                                <p className="text-gray-700 line-clamp-3">{article.abstract}</p>
                                <div className="mt-4 text-sm text-blue-600 font-medium">
                                    Baca selengkapnya →
                                </div>
                            </div>
                        </Link>
                    ))}
                </div>
            </div>
        </Layout>
    );
}
