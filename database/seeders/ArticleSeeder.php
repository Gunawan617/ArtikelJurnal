<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus semua artikel dan gambar lama
        $articles = Article::all();
        foreach ($articles as $article) {
            if ($article->image_path) {
                Storage::disk('public')->delete($article->image_path);
            }
        }
        
        // Disable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Article::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

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
            [
                'title' => 'Cara Mencegah Diabetes Sejak Dini dengan Pola Hidup Sehat',
                'abstract' => 'Diabetes mellitus tipe 2 dapat dicegah dengan menerapkan pola hidup sehat sejak usia muda. Penelitian menunjukkan bahwa perubahan gaya hidup dapat menurunkan risiko diabetes hingga 58% pada individu dengan prediabetes.',
                'content' => '<p>Diabetes mellitus tipe 2 merupakan salah satu penyakit kronis yang paling banyak diderita masyarakat Indonesia. Menurut data Kementerian Kesehatan, prevalensi diabetes di Indonesia mencapai 10,9% pada tahun 2023, meningkat signifikan dari tahun-tahun sebelumnya.</p><p>Kabar baiknya, diabetes tipe 2 sebenarnya dapat dicegah dengan menerapkan pola hidup sehat sejak dini. Studi yang dilakukan oleh Diabetes Prevention Program menunjukkan bahwa perubahan gaya hidup dapat menurunkan risiko diabetes hingga 58% pada individu dengan prediabetes.</p><p>Langkah pertama yang paling penting adalah menjaga berat badan ideal. Kelebihan berat badan, terutama lemak di area perut, meningkatkan resistensi insulin yang menjadi pemicu utama diabetes tipe 2. Menurunkan berat badan sebesar 5-7% saja sudah dapat memberikan dampak signifikan dalam mencegah diabetes.</p><p>Aktivitas fisik rutin juga sangat penting. Olahraga minimal 150 menit per minggu, seperti jalan cepat, bersepeda, atau berenang, dapat meningkatkan sensitivitas insulin dan membantu mengontrol kadar gula darah. Tidak perlu olahraga berat, yang penting konsisten dan rutin.</p><p>Pola makan juga perlu diperhatikan. Kurangi konsumsi makanan tinggi gula dan karbohidrat sederhana, perbanyak sayur dan buah, serta pilih karbohidrat kompleks seperti nasi merah atau gandum utuh. Hindari minuman manis dan makanan olahan yang tinggi gula tersembunyi.</p>',
                'category' => 'Kesehatan',
                'keywords' => 'diabetes, pencegahan, pola hidup sehat, gula darah',
                'image_url' => 'https://picsum.photos/seed/diabetes-prevention/800/600',
                'is_featured' => true,
            ],
            [
                'title' => 'Gejala Awal Kanker Paru-paru yang Sering Diabaikan',
                'abstract' => 'Kanker paru-paru sering kali tidak menunjukkan gejala pada stadium awal. Mengenali tanda-tanda awal dapat meningkatkan peluang kesembuhan hingga 80% jika terdeteksi dan ditangani sejak dini.',
                'content' => '<p>Kanker paru-paru merupakan salah satu jenis kanker yang paling mematikan di dunia, termasuk di Indonesia. Setiap tahun, ribuan orang meninggal akibat penyakit ini, sebagian besar karena terlambat terdeteksi. Masalahnya, gejala awal kanker paru-paru sering kali sangat samar dan mudah diabaikan.</p><p>Batuk yang tidak kunjung sembuh selama lebih dari 3 minggu adalah salah satu gejala yang paling umum. Banyak orang menganggapnya hanya batuk biasa atau efek merokok, padahal ini bisa menjadi tanda awal kanker paru-paru. Apalagi jika batuk disertai darah atau dahak berwarna kemerahan, segera periksakan ke dokter.</p><p>Sesak napas yang semakin memburuk juga perlu diwaspadai. Jika Anda merasa lebih mudah lelah saat beraktivitas ringan atau napas terasa berat tanpa sebab yang jelas, ini bisa menjadi indikasi adanya masalah pada paru-paru. Tumor yang tumbuh dapat menyumbat saluran napas atau menekan paru-paru.</p><p>Nyeri dada yang persisten, terutama saat batuk atau bernapas dalam, juga merupakan gejala yang tidak boleh diabaikan. Nyeri ini bisa terasa tumpul atau tajam, dan kadang menjalar ke bahu atau punggung. Banyak orang mengira ini hanya nyeri otot biasa, padahal bisa jadi tanda kanker paru-paru.</p><p>Penurunan berat badan tanpa sebab yang jelas dan kehilangan nafsu makan juga sering dialami penderita kanker paru-paru stadium awal. Jika Anda kehilangan lebih dari 5 kg dalam sebulan tanpa diet atau perubahan pola makan, sebaiknya segera konsultasi ke dokter.</p>',
                'category' => 'Kesehatan',
                'keywords' => 'kanker paru-paru, gejala, deteksi dini, batuk',
                'image_url' => 'https://picsum.photos/seed/lung-cancer/800/600',
            ],
            [
                'title' => 'Manfaat Olahraga Rutin untuk Kesehatan Jantung',
                'abstract' => 'Olahraga rutin minimal 30 menit sehari dapat menurunkan risiko penyakit jantung hingga 35%. Aktivitas fisik membantu mengontrol tekanan darah, kolesterol, dan berat badan yang merupakan faktor risiko utama penyakit jantung.',
                'content' => '<p>Penyakit jantung masih menjadi penyebab kematian nomor satu di Indonesia. Namun, kabar baiknya adalah sebagian besar penyakit jantung dapat dicegah dengan gaya hidup sehat, terutama olahraga rutin. Penelitian menunjukkan bahwa olahraga minimal 30 menit sehari dapat menurunkan risiko penyakit jantung hingga 35%.</p><p>Olahraga bekerja dengan cara memperkuat otot jantung, sehingga jantung dapat memompa darah lebih efisien ke seluruh tubuh. Saat berolahraga, jantung berdetak lebih cepat dan kuat, melatih otot jantung menjadi lebih kuat dari waktu ke waktu. Ini seperti melatih otot lainnya - semakin sering dilatih, semakin kuat.</p><p>Salah satu manfaat terbesar olahraga adalah kemampuannya menurunkan tekanan darah. Tekanan darah tinggi adalah faktor risiko utama penyakit jantung dan stroke. Olahraga aerobik seperti jalan cepat, jogging, bersepeda, atau berenang dapat menurunkan tekanan darah sistolik hingga 5-10 mmHg pada penderita hipertensi.</p><p>Olahraga juga membantu meningkatkan kadar kolesterol baik (HDL) dan menurunkan kolesterol jahat (LDL) serta trigliserida. Kolesterol HDL berfungsi membersihkan kolesterol jahat dari pembuluh darah, mengurangi risiko penumpukan plak yang dapat menyebabkan serangan jantung.</p><p>Tidak perlu olahraga berat untuk mendapatkan manfaatnya. Jalan cepat 30 menit sehari, 5 kali seminggu, sudah cukup untuk menjaga kesehatan jantung. Bisa juga dibagi menjadi sesi 10 menit sebanyak 3 kali sehari jika tidak punya waktu luang yang panjang.</p>',
                'category' => 'Kesehatan',
                'keywords' => 'olahraga, jantung, kardiovaskular, pencegahan',
                'image_url' => 'https://picsum.photos/seed/heart-exercise/800/600',
            ],
            [
                'title' => 'Tips Menjaga Kesehatan Mental di Era Digital',
                'abstract' => 'Penggunaan media sosial dan teknologi digital yang berlebihan dapat berdampak negatif pada kesehatan mental. Penelitian menunjukkan 60% pengguna media sosial mengalami gejala kecemasan dan depresi ringan.',
                'content' => '<p>Di era digital ini, hampir semua orang terhubung dengan smartphone dan media sosial setiap hari. Meskipun teknologi membawa banyak kemudahan, penggunaan yang berlebihan ternyata dapat berdampak negatif pada kesehatan mental kita. Penelitian terbaru menunjukkan bahwa 60% pengguna aktif media sosial mengalami gejala kecemasan dan depresi ringan.</p><p>Salah satu masalah terbesar adalah FOMO (Fear of Missing Out) atau rasa takut ketinggalan. Melihat kehidupan orang lain yang tampak sempurna di media sosial membuat kita merasa tidak cukup baik. Padahal, apa yang ditampilkan di media sosial hanyalah highlight reel, bukan kehidupan nyata yang utuh dengan segala masalahnya.</p><p>Perbandingan sosial yang terus-menerus ini dapat menurunkan harga diri dan memicu kecemasan. Kita mulai membandingkan pencapaian, penampilan, bahkan kebahagiaan kita dengan orang lain. Ini adalah jebakan mental yang sangat berbahaya dan dapat memicu depresi.</p><p>Untuk menjaga kesehatan mental di era digital, mulailah dengan membatasi waktu screen time. Tetapkan batas maksimal 2 jam per hari untuk media sosial. Gunakan fitur screen time di smartphone untuk memantau dan membatasi penggunaan aplikasi tertentu.</p><p>Lakukan digital detox secara berkala. Luangkan waktu 1-2 hari dalam sebulan untuk benar-benar lepas dari smartphone dan media sosial. Gunakan waktu ini untuk aktivitas yang lebih bermakna seperti bertemu teman secara langsung, membaca buku, atau menikmati alam.</p>',
                'category' => 'Kesehatan',
                'keywords' => 'kesehatan mental, media sosial, kecemasan, digital detox',
                'image_url' => 'https://picsum.photos/seed/mental-health-digital/800/600',
            ],
            [
                'title' => 'Pentingnya Tidur Berkualitas untuk Kesehatan Tubuh',
                'abstract' => 'Tidur yang cukup dan berkualitas sangat penting untuk kesehatan fisik dan mental. Kurang tidur dapat meningkatkan risiko obesitas, diabetes, penyakit jantung, dan gangguan mental hingga 50%.',
                'content' => '<p>Tidur sering dianggap sebagai aktivitas yang bisa dikorbankan demi pekerjaan atau hiburan. Padahal, tidur yang cukup dan berkualitas adalah salah satu pilar utama kesehatan, sama pentingnya dengan nutrisi dan olahraga. Penelitian menunjukkan bahwa kurang tidur dapat meningkatkan risiko berbagai penyakit kronis hingga 50%.</p><p>Saat tidur, tubuh melakukan berbagai proses perbaikan dan regenerasi sel. Sistem kekebalan tubuh diperkuat, hormon pertumbuhan dilepaskan untuk memperbaiki jaringan, dan otak membersihkan racun yang menumpuk selama seharian. Tanpa tidur yang cukup, proses-proses vital ini terganggu.</p><p>Kurang tidur juga berdampak serius pada metabolisme tubuh. Orang yang tidur kurang dari 6 jam per malam memiliki risiko 30% lebih tinggi untuk mengalami obesitas. Kurang tidur mengganggu hormon leptin dan ghrelin yang mengatur rasa lapar dan kenyang, membuat kita cenderung makan berlebihan.</p><p>Kesehatan mental juga sangat dipengaruhi oleh kualitas tidur. Kurang tidur meningkatkan risiko depresi dan kecemasan hingga 40%. Tidur yang cukup membantu otak memproses emosi dan mengkonsolidasikan memori, penting untuk kesehatan mental yang baik.</p><p>Untuk mendapatkan tidur berkualitas, ciptakan rutinitas tidur yang konsisten. Tidur dan bangun di waktu yang sama setiap hari, bahkan di akhir pekan. Hindari kafein 6 jam sebelum tidur dan matikan semua layar elektronik 1 jam sebelum tidur karena cahaya biru dapat mengganggu produksi melatonin.</p>',
                'category' => 'Kesehatan',
                'keywords' => 'tidur, insomnia, kesehatan, kualitas tidur',
                'image_url' => 'https://picsum.photos/seed/sleep-quality/800/600',
            ],
            [
                'title' => 'Makanan Sehat untuk Menurunkan Kolesterol Tinggi',
                'abstract' => 'Kolesterol tinggi dapat diturunkan dengan mengonsumsi makanan yang tepat. Penelitian menunjukkan bahwa diet sehat dapat menurunkan kolesterol LDL hingga 20-30% tanpa obat.',
                'content' => '<p>Kolesterol tinggi adalah salah satu faktor risiko utama penyakit jantung dan stroke. Banyak orang langsung berpikir harus minum obat seumur hidup, padahal kolesterol sebenarnya bisa dikontrol dengan pola makan yang tepat. Penelitian menunjukkan bahwa diet sehat dapat menurunkan kolesterol LDL (kolesterol jahat) hingga 20-30%.</p><p>Oatmeal adalah salah satu makanan terbaik untuk menurunkan kolesterol. Oat mengandung serat larut beta-glucan yang dapat mengikat kolesterol di usus dan membuangnya sebelum diserap tubuh. Konsumsi 3 gram serat larut per hari (setara 1,5 mangkuk oatmeal) dapat menurunkan kolesterol LDL hingga 5-10%.</p><p>Kacang-kacangan seperti almond, walnut, dan kacang tanah juga sangat efektif. Kacang mengandung lemak tak jenuh tunggal dan ganda yang dapat menurunkan kolesterol jahat sambil meningkatkan kolesterol baik (HDL). Konsumsi segenggam kacang (sekitar 40 gram) setiap hari dapat menurunkan kolesterol LDL hingga 5%.</p><p>Ikan berlemak seperti salmon, makarel, dan sarden kaya akan omega-3 yang dapat menurunkan trigliserida dan meningkatkan kolesterol HDL. Konsumsi ikan berlemak 2-3 kali seminggu sangat dianjurkan untuk kesehatan jantung.</p><p>Buah dan sayur juga penting. Apel, anggur, stroberi, dan jeruk mengandung pektin, sejenis serat larut yang dapat menurunkan kolesterol. Sayuran hijau seperti bayam dan kangkung mengandung lutein dan serat yang membantu menurunkan kolesterol.</p><p>Hindari makanan tinggi lemak jenuh dan lemak trans seperti gorengan, makanan cepat saji, dan makanan olahan. Ganti dengan minyak zaitun atau minyak kanola untuk memasak. Batasi konsumsi daging merah dan pilih daging tanpa lemak atau ayam tanpa kulit.</p>',
                'category' => 'Kesehatan',
                'keywords' => 'kolesterol, makanan sehat, diet, jantung',
                'image_url' => 'https://picsum.photos/seed/cholesterol-food/800/600',
            ],
            [
                'title' => 'Cara Mengatasi Stress dan Kecemasan Secara Alami',
                'abstract' => 'Stress dan kecemasan dapat diatasi dengan metode alami tanpa obat. Teknik relaksasi, olahraga, dan mindfulness terbukti efektif menurunkan tingkat stress hingga 40%.',
                'content' => '<p>Stress dan kecemasan adalah masalah kesehatan mental yang paling umum di era modern. Tekanan pekerjaan, masalah keuangan, dan tuntutan sosial membuat banyak orang mengalami stress kronis. Kabar baiknya, stress dan kecemasan dapat diatasi dengan metode alami tanpa harus bergantung pada obat.</p><p>Teknik pernapasan dalam adalah cara paling sederhana dan efektif untuk meredakan stress. Saat stress, tubuh masuk ke mode "fight or flight" dengan napas yang cepat dan dangkal. Pernapasan dalam mengaktifkan sistem saraf parasimpatis yang menenangkan tubuh. Coba teknik 4-7-8: tarik napas 4 hitungan, tahan 7 hitungan, buang napas 8 hitungan. Lakukan 5-10 kali.</p><p>Olahraga adalah antidepresan alami yang sangat ampuh. Saat berolahraga, tubuh melepaskan endorfin yang membuat kita merasa lebih bahagia dan rileks. Tidak perlu olahraga berat, jalan kaki 30 menit sehari sudah cukup untuk menurunkan tingkat stress hingga 40%.</p><p>Mindfulness dan meditasi juga sangat efektif. Meditasi 10-15 menit sehari dapat menurunkan hormon stress kortisol dan meningkatkan kemampuan otak mengelola emosi. Aplikasi seperti Headspace atau Calm dapat membantu pemula belajar meditasi.</p><p>Tidur yang cukup sangat penting untuk mengelola stress. Kurang tidur membuat kita lebih mudah stress dan cemas. Usahakan tidur 7-8 jam setiap malam dengan kualitas yang baik.</p><p>Batasi konsumsi kafein dan alkohol. Kafein dapat memperburuk kecemasan, sementara alkohol hanya memberikan efek tenang sementara dan justru memperburuk kecemasan dalam jangka panjang.</p>',
                'category' => 'Kesehatan',
                'keywords' => 'stress, kecemasan, relaksasi, mindfulness',
                'image_url' => 'https://picsum.photos/seed/stress-relief/800/600',
            ],
            [
                'title' => 'Bahaya Merokok dan Cara Efektif Berhenti Merokok',
                'abstract' => 'Merokok adalah penyebab utama kematian yang dapat dicegah di dunia. Berhenti merokok dapat menurunkan risiko penyakit jantung hingga 50% dalam setahun pertama.',
                'content' => '<p>Merokok adalah salah satu kebiasaan paling berbahaya bagi kesehatan. Setiap tahun, lebih dari 8 juta orang meninggal akibat rokok di seluruh dunia. Di Indonesia, prevalensi perokok mencapai 34%, salah satu yang tertinggi di dunia. Namun, tidak pernah terlambat untuk berhenti merokok.</p><p>Rokok mengandung lebih dari 7000 bahan kimia, 70 di antaranya bersifat karsinogenik (penyebab kanker). Nikotin membuat rokok sangat adiktif, sementara tar merusak paru-paru, dan karbon monoksida mengurangi kemampuan darah membawa oksigen.</p><p>Dampak merokok sangat luas. Risiko kanker paru-paru meningkat 15-30 kali lipat pada perokok. Penyakit jantung dan stroke juga meningkat 2-4 kali lipat. Perokok juga lebih rentan terhadap diabetes, penyakit paru obstruktif kronis (PPOK), dan berbagai jenis kanker lainnya.</p><p>Kabar baiknya, tubuh mulai pulih segera setelah berhenti merokok. Dalam 20 menit, tekanan darah dan detak jantung kembali normal. Dalam 12 jam, kadar karbon monoksida dalam darah turun ke level normal. Dalam 2-12 minggu, sirkulasi darah membaik dan fungsi paru-paru meningkat. Dalam setahun, risiko penyakit jantung turun 50%.</p><p>Untuk berhenti merokok, tentukan tanggal berhenti dan komitmen penuh. Buang semua rokok, asbak, dan korek api. Hindari situasi yang memicu keinginan merokok seperti minum kopi atau berkumpul dengan perokok.</p><p>Gunakan terapi pengganti nikotin seperti permen karet nikotin atau patch jika perlu. Ini dapat mengurangi gejala withdrawal dan meningkatkan peluang sukses hingga 50-70%. Konsultasi dengan dokter untuk mendapatkan dukungan medis.</p>',
                'category' => 'Kesehatan',
                'keywords' => 'merokok, berhenti merokok, kanker, paru-paru',
                'image_url' => 'https://picsum.photos/seed/quit-smoking/800/600',
            ],
            [
                'title' => 'Manfaat Vitamin D untuk Kesehatan Tulang dan Imunitas',
                'abstract' => 'Vitamin D sangat penting untuk kesehatan tulang dan sistem kekebalan tubuh. Defisiensi vitamin D dialami oleh 50% populasi dunia dan meningkatkan risiko berbagai penyakit.',
                'content' => '<p>Vitamin D sering disebut "vitamin sinar matahari" karena tubuh dapat memproduksinya saat kulit terpapar sinar matahari. Namun, gaya hidup modern yang banyak di dalam ruangan membuat defisiensi vitamin D menjadi masalah global. Diperkirakan 50% populasi dunia mengalami kekurangan vitamin D.</p><p>Vitamin D sangat penting untuk kesehatan tulang karena membantu penyerapan kalsium di usus. Tanpa vitamin D yang cukup, tubuh tidak dapat menyerap kalsium dengan baik, meskipun asupan kalsium tinggi. Ini dapat menyebabkan osteoporosis pada orang dewasa dan rakhitis pada anak-anak.</p><p>Selain untuk tulang, vitamin D juga berperan penting dalam sistem kekebalan tubuh. Vitamin D membantu sel-sel imun melawan infeksi virus dan bakteri. Penelitian menunjukkan bahwa orang dengan kadar vitamin D yang cukup memiliki risiko 40% lebih rendah terkena infeksi saluran pernapasan.</p><p>Defisiensi vitamin D juga dikaitkan dengan peningkatan risiko penyakit jantung, diabetes tipe 2, beberapa jenis kanker, dan depresi. Orang dengan kadar vitamin D rendah memiliki risiko 2 kali lipat lebih tinggi mengalami depresi.</p><p>Sumber terbaik vitamin D adalah sinar matahari. Berjemur 10-15 menit di pagi hari (sebelum jam 10) atau sore hari (setelah jam 3) sudah cukup untuk memenuhi kebutuhan harian. Pastikan kulit tangan dan kaki terpapar langsung tanpa tabir surya.</p><p>Makanan yang kaya vitamin D meliputi ikan berlemak (salmon, sarden, makarel), kuning telur, hati sapi, dan produk yang difortifikasi seperti susu dan sereal. Jika perlu, konsumsi suplemen vitamin D 1000-2000 IU per hari setelah konsultasi dengan dokter.</p>',
                'category' => 'Kesehatan',
                'keywords' => 'vitamin D, tulang, imunitas, osteoporosis',
                'image_url' => 'https://picsum.photos/seed/vitamin-d/800/600',
            ],
            [
                'title' => 'Pentingnya Menjaga Kesehatan Ginjal Sejak Dini',
                'abstract' => 'Penyakit ginjal kronis sering tidak menunjukkan gejala hingga stadium lanjut. Deteksi dini dan pencegahan dapat menyelamatkan fungsi ginjal dan mencegah gagal ginjal.',
                'content' => '<p>Ginjal adalah organ vital yang berfungsi menyaring limbah dan racun dari darah, mengatur keseimbangan cairan dan elektrolit, serta memproduksi hormon penting. Sayangnya, penyakit ginjal kronis sering tidak menunjukkan gejala hingga kerusakan sudah parah. Diperkirakan 1 dari 10 orang dewasa mengalami penyakit ginjal kronis.</p><p>Masalahnya, ginjal memiliki kemampuan kompensasi yang luar biasa. Bahkan ketika fungsi ginjal sudah turun 50%, gejala mungkin belum muncul. Gejala baru terasa ketika fungsi ginjal tinggal 25% atau kurang, seperti kelelahan, bengkak di kaki, sesak napas, dan mual.</p><p>Faktor risiko utama penyakit ginjal adalah diabetes dan hipertensi. Gula darah tinggi dapat merusak pembuluh darah kecil di ginjal, sementara tekanan darah tinggi membuat ginjal bekerja terlalu keras. Obesitas, merokok, dan riwayat keluarga juga meningkatkan risiko.</p><p>Untuk menjaga kesehatan ginjal, kontrol gula darah dan tekanan darah dengan baik. Jika Anda memiliki diabetes atau hipertensi, lakukan pemeriksaan fungsi ginjal secara rutin minimal setahun sekali. Tes sederhana seperti kreatinin serum dan urinalisis dapat mendeteksi masalah ginjal sejak dini.</p><p>Minum air putih yang cukup, sekitar 8 gelas per hari, membantu ginjal membuang racun dengan lebih efisien. Namun, jangan berlebihan karena terlalu banyak air juga dapat membebani ginjal.</p><p>Batasi konsumsi garam dan makanan olahan yang tinggi sodium. Sodium berlebih dapat meningkatkan tekanan darah dan membebani ginjal. Hindari juga penggunaan obat pereda nyeri (NSAID) jangka panjang tanpa pengawasan dokter karena dapat merusak ginjal.</p>',
                'category' => 'Kesehatan',
                'keywords' => 'ginjal, gagal ginjal, diabetes, hipertensi',
                'image_url' => 'https://picsum.photos/seed/kidney-health/800/600',
            ],
            [
                'title' => 'Cara Meningkatkan Daya Tahan Tubuh Secara Alami',
                'abstract' => 'Sistem kekebalan tubuh yang kuat adalah kunci untuk melawan penyakit. Pola hidup sehat dapat meningkatkan daya tahan tubuh hingga 70% tanpa suplemen mahal.',
                'content' => '<p>Sistem kekebalan tubuh adalah pertahanan alami kita melawan virus, bakteri, dan penyakit. Di tengah pandemi dan berbagai penyakit menular, memiliki daya tahan tubuh yang kuat menjadi sangat penting. Kabar baiknya, kita dapat meningkatkan imunitas secara alami tanpa harus bergantung pada suplemen mahal.</p><p>Nutrisi adalah fondasi sistem kekebalan yang kuat. Konsumsi makanan kaya vitamin C seperti jeruk, kiwi, paprika, dan brokoli. Vitamin C meningkatkan produksi sel darah putih yang melawan infeksi. Vitamin E dari kacang-kacangan dan biji-bijian juga penting sebagai antioksidan kuat.</p><p>Protein sangat penting untuk produksi antibodi dan sel imun. Pastikan asupan protein cukup dari daging tanpa lemak, ikan, telur, kacang-kacangan, dan produk susu. Zinc dari daging merah, kerang, dan kacang-kacangan juga penting untuk fungsi sel imun.</p><p>Tidur yang cukup sangat krusial untuk imunitas. Saat tidur, tubuh memproduksi sitokin, protein yang melawan infeksi dan peradangan. Kurang tidur dapat menurunkan produksi sitokin dan sel imun hingga 70%. Usahakan tidur 7-8 jam setiap malam.</p><p>Olahraga teratur meningkatkan sirkulasi darah, membantu sel imun bergerak lebih efisien ke seluruh tubuh. Olahraga intensitas sedang 30 menit sehari, 5 kali seminggu, dapat meningkatkan fungsi imun hingga 50%. Namun, hindari olahraga berlebihan karena justru dapat menurunkan imunitas.</p><p>Kelola stress dengan baik. Stress kronis meningkatkan hormon kortisol yang menekan sistem kekebalan tubuh. Praktikkan teknik relaksasi seperti meditasi, yoga, atau hobi yang menyenangkan untuk mengurangi stress.</p>',
                'category' => 'Kesehatan',
                'keywords' => 'imunitas, daya tahan tubuh, vitamin, kesehatan',
                'image_url' => 'https://picsum.photos/seed/immunity-boost/800/600',
            ],
        ];

        // Pastikan folder storage/app/public/articles ada
        if (!Storage::disk('public')->exists('articles')) {
            Storage::disk('public')->makeDirectory('articles');
        }

        // Variasi reviewer
        $reviewers = [
            ['name' => 'Prof. Dr. Budi Santoso, M.Sc', 'title' => 'Profesor Ilmu Kesehatan Masyarakat'],
            ['name' => 'Dr. Siti Nurhaliza, Sp.PD', 'title' => 'Dokter Spesialis Penyakit Dalam'],
            ['name' => 'Prof. Dr. Ir. Agus Wijaya, M.Kes', 'title' => 'Profesor Gizi dan Kesehatan'],
            ['name' => 'Dr. Maya Kusuma, Sp.JP', 'title' => 'Dokter Spesialis Jantung'],
        ];

        foreach ($articles as $index => $articleData) {
            $slug = Str::slug($articleData['title']);
            $reviewer = $reviewers[$index % count($reviewers)];
            
            // Download gambar dari URL
            $imagePath = null;
            if (isset($articleData['image_url'])) {
                try {
                    $imageContent = file_get_contents($articleData['image_url']);
                    if ($imageContent !== false) {
                        $imageName = 'articles/' . $slug . '.jpg';
                        Storage::disk('public')->put($imageName, $imageContent);
                        $imagePath = $imageName;
                    }
                } catch (\Exception $e) {
                    $this->command->warn("Gagal download gambar untuk: {$articleData['title']}");
                }
            }
            
            Article::create([
                'user_id' => $dosen->id,
                'title' => $articleData['title'],
                'slug' => $slug,
                'content' => $articleData['content'],
                'abstract' => $articleData['abstract'],
                'author' => $dosen->name,
                'author_title' => 'Doktor Ilmu Kesehatan',
                'author_institution' => 'Universitas Indonesia',
                'reviewer_name' => $reviewer['name'],
                'reviewer_title' => $reviewer['title'],
                'category' => $articleData['category'],
                'category_color' => 'red',
                'keywords' => $articleData['keywords'],
                'image_path' => $imagePath,
                'is_published' => true,
                'is_featured' => $articleData['is_featured'] ?? false,
                'published_at' => now()->subDays($index),
            ]);
            
            $this->command->info("✓ Artikel dibuat: {$articleData['title']}");
        }
        
        $this->command->info("\n🎉 Seeder selesai! Total " . count($articles) . " artikel kesehatan dibuat.");
    }
}
