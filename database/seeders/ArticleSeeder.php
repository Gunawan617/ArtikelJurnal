<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Buat user admin jika belum ada
        $admin = User::firstOrCreate(
            ['email' => 'admin@scholar.com'],
            [
                'name' => 'Admin Scholar',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
            ]
        );

        // Buat user dosen jika belum ada
        $dosen = User::firstOrCreate(
            ['email' => 'ahmad.santoso@university.ac.id'],
            [
                'name' => 'Dr. Ahmad Santoso, M.Kom',
                'password' => bcrypt('dosen123'),
                'role' => 'dosen',
            ]
        );

        $articles = [
            // Featured Article
            [
                'title' => 'Penerapan Machine Learning dalam Prediksi Penyakit Diabetes',
                'content' => '<p>Machine learning telah menjadi salah satu teknologi yang paling menjanjikan dalam bidang kesehatan. Penelitian ini membahas penerapan algoritma machine learning untuk memprediksi risiko penyakit diabetes pada pasien.</p><p>Metode yang digunakan meliputi Random Forest, Support Vector Machine, dan Neural Networks. Hasil penelitian menunjukkan akurasi prediksi mencapai 92% dengan menggunakan dataset dari 1000 pasien.</p><p>Temuan ini dapat membantu tenaga medis dalam melakukan deteksi dini dan pencegahan diabetes mellitus tipe 2.</p>',
                'category' => 'Teknologi',
                'category_color' => 'blue',
                'keywords' => 'machine learning, diabetes, prediksi, kesehatan',
                'is_featured' => true,
            ],
            // Teknologi
            [
                'title' => 'Implementasi Deep Learning untuk Deteksi Kanker Paru-paru',
                'content' => '<p>Penelitian ini menggunakan Convolutional Neural Network (CNN) untuk mendeteksi kanker paru-paru dari citra CT scan. Model dilatih dengan 10.000 gambar medis dan mencapai akurasi 94%.</p><p>Sistem ini dapat membantu radiolog dalam diagnosis dini kanker paru-paru.</p>',
                'category' => 'Teknologi',
                'category_color' => 'blue',
                'keywords' => 'deep learning, CNN, kanker, deteksi',
            ],
            [
                'title' => 'Sistem Rekomendasi Obat Berbasis Artificial Intelligence',
                'content' => '<p>Pengembangan sistem rekomendasi obat menggunakan AI yang dapat memberikan saran pengobatan berdasarkan gejala dan riwayat medis pasien. Sistem ini menggunakan Natural Language Processing untuk memahami keluhan pasien.</p>',
                'category' => 'Teknologi',
                'category_color' => 'blue',
                'keywords' => 'AI, rekomendasi, obat, NLP',
            ],
            // Kesehatan
            [
                'title' => 'Pengembangan Aplikasi Mobile untuk Monitoring Kesehatan Lansia',
                'content' => '<p>Aplikasi mobile dikembangkan untuk membantu monitoring kesehatan lansia secara real-time. Fitur meliputi pengingat minum obat, tracking tekanan darah, dan konsultasi online.</p><p>Uji coba pada 50 lansia menunjukkan peningkatan kepatuhan minum obat sebesar 85%.</p>',
                'category' => 'Kesehatan',
                'category_color' => 'red',
                'keywords' => 'aplikasi mobile, kesehatan lansia, monitoring',
            ],
            [
                'title' => 'Studi Efektivitas Telemedicine dalam Pelayanan Kesehatan Primer',
                'content' => '<p>Penelitian mengevaluasi efektivitas layanan telemedicine untuk konsultasi kesehatan primer. Data dikumpulkan dari 200 pasien yang menggunakan layanan telemedicine selama 6 bulan.</p><p>Hasil menunjukkan tingkat kepuasan pasien mencapai 88%.</p>',
                'category' => 'Kesehatan',
                'category_color' => 'red',
                'keywords' => 'telemedicine, kesehatan, konsultasi online',
            ],
            [
                'title' => 'Analisis Faktor Risiko Penyakit Jantung pada Usia Produktif',
                'content' => '<p>Studi kohort terhadap 500 pekerja usia 30-50 tahun untuk mengidentifikasi faktor risiko penyakit jantung. Faktor yang diteliti meliputi pola makan, aktivitas fisik, dan tingkat stress.</p>',
                'category' => 'Kesehatan',
                'category_color' => 'red',
                'keywords' => 'jantung, faktor risiko, kesehatan',
            ],
            // Lingkungan
            [
                'title' => 'Analisis Kualitas Air Sungai Menggunakan Metode Spektrofotometri',
                'content' => '<p>Penelitian ini menganalisis kualitas air sungai di wilayah perkotaan menggunakan metode spektrofotometri. Parameter yang diukur meliputi pH, BOD, COD, dan kandungan logam berat.</p><p>Hasil menunjukkan bahwa 60% sampel air tidak memenuhi standar baku mutu air bersih.</p>',
                'category' => 'Lingkungan',
                'category_color' => 'green',
                'keywords' => 'kualitas air, spektrofotometri, lingkungan',
            ],
            [
                'title' => 'Dampak Polusi Udara terhadap Kesehatan Masyarakat Perkotaan',
                'content' => '<p>Studi epidemiologi tentang dampak polusi udara PM2.5 terhadap kesehatan respirasi masyarakat di Jakarta. Data dikumpulkan dari 1000 responden dan dianalisis menggunakan regresi logistik.</p>',
                'category' => 'Lingkungan',
                'category_color' => 'green',
                'keywords' => 'polusi udara, kesehatan, PM2.5',
            ],
            // Pendidikan
            [
                'title' => 'Efektivitas Pembelajaran Daring pada Masa Pandemi COVID-19',
                'content' => '<p>Studi ini mengevaluasi efektivitas pembelajaran daring yang diterapkan selama pandemi COVID-19. Data dikumpulkan dari 500 mahasiswa melalui survei dan wawancara.</p><p>Hasil menunjukkan bahwa 70% mahasiswa mengalami kesulitan dalam memahami materi secara online.</p>',
                'category' => 'Pendidikan',
                'category_color' => 'orange',
                'keywords' => 'pembelajaran daring, COVID-19, pendidikan',
            ],
            [
                'title' => 'Penerapan Gamifikasi dalam Pembelajaran Matematika',
                'content' => '<p>Penelitian eksperimen tentang penerapan gamifikasi untuk meningkatkan motivasi belajar matematika siswa SMP. Hasil menunjukkan peningkatan nilai rata-rata sebesar 15%.</p>',
                'category' => 'Pendidikan',
                'category_color' => 'orange',
                'keywords' => 'gamifikasi, matematika, pembelajaran',
            ],
            // Keamanan
            [
                'title' => 'Studi Komparatif Algoritma Enkripsi untuk Keamanan Data',
                'content' => '<p>Penelitian membandingkan performa algoritma enkripsi AES, RSA, dan Blowfish dalam mengamankan data sensitif. Pengujian dilakukan dengan berbagai ukuran file.</p><p>AES menunjukkan performa terbaik dengan kecepatan enkripsi 2.5x lebih cepat dari RSA.</p>',
                'category' => 'Keamanan',
                'category_color' => 'purple',
                'keywords' => 'enkripsi, keamanan data, algoritma',
            ],
            [
                'title' => 'Analisis Kerentanan Keamanan pada Aplikasi Mobile Banking',
                'content' => '<p>Penelitian mengidentifikasi kerentanan keamanan pada 10 aplikasi mobile banking populer di Indonesia. Ditemukan 5 jenis kerentanan kritis yang perlu segera diperbaiki.</p>',
                'category' => 'Keamanan',
                'category_color' => 'purple',
                'keywords' => 'keamanan, mobile banking, kerentanan',
            ],
            // Sosial
            [
                'title' => 'Pengaruh Media Sosial terhadap Perilaku Konsumtif Generasi Z',
                'content' => '<p>Studi ini menganalisis pengaruh media sosial terhadap perilaku konsumtif generasi Z. Data dikumpulkan dari 300 responden berusia 18-25 tahun.</p><p>Hasil menunjukkan korelasi positif antara intensitas penggunaan media sosial dengan tingkat konsumtivitas.</p>',
                'category' => 'Sosial',
                'category_color' => 'yellow',
                'keywords' => 'media sosial, generasi Z, perilaku konsumtif',
            ],
            [
                'title' => 'Dampak Pandemi terhadap Kesehatan Mental Mahasiswa',
                'content' => '<p>Penelitian kualitatif tentang dampak pandemi COVID-19 terhadap kesehatan mental mahasiswa. Wawancara mendalam dilakukan terhadap 50 mahasiswa dari berbagai universitas.</p>',
                'category' => 'Sosial',
                'category_color' => 'yellow',
                'keywords' => 'pandemi, kesehatan mental, mahasiswa',
            ],
        ];

        foreach ($articles as $index => $articleData) {
            $slug = Str::slug($articleData['title']);
            
            Article::create([
                'user_id' => $dosen->id,
                'title' => $articleData['title'],
                'slug' => $slug,
                'content' => $articleData['content'],
                'abstract' => Str::limit(strip_tags($articleData['content']), 150),
                'author' => $dosen->name,
                'author_title' => 'Doktor Ilmu Komputer',
                'author_institution' => 'Universitas Indonesia',
                'category' => $articleData['category'],
                'category_color' => $articleData['category_color'],
                'keywords' => $articleData['keywords'],
                'is_published' => true,
                'is_featured' => $articleData['is_featured'] ?? false,
                'published_at' => now()->subDays($index),
            ]);
        }
    }
}
