import { Head, Link } from '@inertiajs/react';
import Layout from '@/Layouts/Layout';

export default function Home() {
    return (
        <Layout>
            <Head title="Beranda" />
            
            <div className="bg-gradient-to-br from-blue-50 to-blue-100 py-20">
                <div className="max-w-6xl mx-auto px-4 text-center">
                    <h1 className="text-5xl font-bold text-gray-900 mb-6">
                        Portal Artikel Ilmiah
                    </h1>
                    <p className="text-xl text-gray-700 mb-8 max-w-2xl mx-auto">
                        Platform publikasi artikel ilmiah yang terindeks Google Scholar. 
                        Baca, diskusi, dan bagikan pengetahuan ilmiah.
                    </p>
                    <Link 
                        href="/artikel"
                        className="inline-block px-8 py-3 bg-blue-600 text-white rounded-lg text-lg font-semibold hover:bg-blue-700 transition"
                    >
                        Jelajahi Artikel
                    </Link>
                </div>
            </div>

            <div className="max-w-6xl mx-auto px-4 py-16">
                <div className="grid md:grid-cols-3 gap-8">
                    <div className="text-center">
                        <div className="text-4xl mb-4">📚</div>
                        <h3 className="text-xl font-semibold mb-2">Artikel Berkualitas</h3>
                        <p className="text-gray-600">Artikel ilmiah yang telah direview dan terverifikasi</p>
                    </div>
                    <div className="text-center">
                        <div className="text-4xl mb-4">🔍</div>
                        <h3 className="text-xl font-semibold mb-2">Terindeks Scholar</h3>
                        <p className="text-gray-600">Semua artikel dapat ditemukan di Google Scholar</p>
                    </div>
                    <div className="text-center">
                        <div className="text-4xl mb-4">💬</div>
                        <h3 className="text-xl font-semibold mb-2">Diskusi Interaktif</h3>
                        <p className="text-gray-600">Berdiskusi langsung dengan penulis dan pembaca lain</p>
                    </div>
                </div>
            </div>
        </Layout>
    );
}
