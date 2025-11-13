import { Head } from '@inertiajs/react';
import Layout from '@/Layouts/Layout';

export default function About() {
    return (
        <Layout>
            <Head title="Tentang Kami" />
            
            <div className="max-w-4xl mx-auto px-4 py-16">
                <h1 className="text-4xl font-bold text-gray-900 mb-6">Tentang ScholarHub</h1>
                
                <div className="prose prose-lg max-w-none">
                    <p className="text-gray-700 leading-relaxed mb-4">
                        ScholarHub adalah platform publikasi artikel ilmiah yang dirancang khusus 
                        untuk memudahkan dosen dan peneliti dalam mempublikasikan karya ilmiah mereka 
                        agar dapat terindeks di Google Scholar.
                    </p>
                    
                    <h2 className="text-2xl font-semibold text-gray-900 mt-8 mb-4">Fitur Utama</h2>
                    <ul className="space-y-2 text-gray-700">
                        <li>✅ Publikasi artikel dengan metadata lengkap untuk Google Scholar</li>
                        <li>✅ Upload PDF artikel dengan referensi ilmiah</li>
                        <li>✅ Sistem komentar dan diskusi interaktif</li>
                        <li>✅ Panel admin yang mudah digunakan (Filament)</li>
                        <li>✅ Tampilan responsif dan modern</li>
                        <li>✅ SEO-optimized untuk mesin pencari</li>
                    </ul>
                    
                    <h2 className="text-2xl font-semibold text-gray-900 mt-8 mb-4">Untuk Dosen & Peneliti</h2>
                    <p className="text-gray-700 leading-relaxed">
                        Anda dapat login ke panel admin untuk mengelola artikel, menambahkan referensi, 
                        dan memoderasi komentar. Setiap artikel yang dipublikasikan akan otomatis 
                        memiliki metadata yang sesuai dengan standar Google Scholar.
                    </p>
                    
                    <h2 className="text-2xl font-semibold text-gray-900 mt-8 mb-4">Kontak</h2>
                    <p className="text-gray-700">
                        Email: admin@scholarhub.com<br />
                        Website: https://scholarhub.com
                    </p>
                </div>
            </div>
        </Layout>
    );
}
