<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Setting;
use App\Models\Product;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Administrator Accounts
        User::updateOrCreate(
            ['email' => 'admin@islenesia.com'],
            [
                'name' => 'Islenesia Admin',
                'password' => Hash::make('Islenesia2026!'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@manunggaland.com'],
            [
                'name' => 'Islenesia Admin',
                'password' => Hash::make('Islenesia2026!'),
            ]
        );

        // 2. Settings
        $settings = [
            'site_name' => 'Islenesia',
            'site_tagline' => 'Global Agro Commodity Aggregator & Direct Exporter',
            'site_description' => 'PT Islenesia Agro Nusantara (Islenesia) adalah eksportir dan agregator komoditas agrikultur premium Indonesia yang menghubungkan hasil bumi petani nusantara langsung ke pasar global (China, Eropa, Timur Tengah, dan Amerika) dengan jaminan mutu internasional dan legalitas penuh.',
            'company_name' => 'PT Islenesia Agro Nusantara',
            'company_established' => '2019',
            'exported_countries_count' => '28+',
            'metric_tons_exported' => '5,400+',
            'partner_farmers_count' => '1,450+',
            'buyer_satisfaction' => '99.4%',
            'email' => 'info@islenesia.com',
            'phone' => '+62 851-6131-3914',
            'whatsapp_number' => '6285161313914',
            'address' => 'Gedung Graha Agro Nusantara Lt. 4, Jakarta, Indonesia',
            'maps_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126920.28310373059!2d106.75653457193393!3d-6.229386706915104!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e49fe3ea05%3A0x25088e21fb90b08c!2sJakarta!5e0!3m2!1sen!2sid!4v1710000000000!5m2!1sen!2sid" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            
            // Social Media Dynamic Fields
            'social_instagram' => 'https://instagram.com/islenesia.export',
            'social_facebook' => 'https://facebook.com/islenesia.id',
            'social_tiktok' => 'https://tiktok.com/@islenesia.export',
            'social_youtube' => 'https://youtube.com/@islenesia',
            'social_linkedin' => 'https://linkedin.com/company/islenesia',
            
            // SEO Settings
            'meta_title' => 'Islenesia | Premium Indonesian Agricultural Exporter to China & Europe',
            'meta_description' => 'Direct exporter of Indonesian Vanilla Beans, Organic Kratom, Specialty Coffee, and Cloves. Verified supply chain, lab-tested quality, and international shipping.',
            'meta_keywords' => 'islenesia, indonesian exporter, vanilla beans export, kratom supplier wholesale, coffee green beans indonesia, clove exporter, agricultural aggregator indonesia, spices export to china europe',
            
            // About Us CMS Content
            'about_story' => 'Manunggaland didirikan dengan tekad kuat untuk mengangkat komoditas pertanian terbaik Indonesia ke panggung internasional. Beroperasi sebagai agregator terpercaya, kami bekerja sama langsung dengan lebih dari 1.400 petani mitra di berbagai sentra perkebunan nusantara—mulai dari Aceh, Jawa, Maluku, hingga Papua. Dengan memangkas rantai perantara yang tidak efisien, kami memastikan petani memperoleh harga yang adil serta pembeli internasional (Eropa, China, Asia Timur, dan Amerika) mendapatkan kepastian pasokan, transparansi mutu laboratorium, dan harga yang sangat kompetitif.',
            'about_vision' => 'Menjadi gerbang utama dan agregator komoditas pertanian terkemuka dari Indonesia yang diakui secara global atas integritas, kualitas mutu tanpa kompromi, dan keberlanjutan rantai pasok dari petani ke industri dunia.',
            'about_mission' => "1. Menjamin standar kualitas ekspor tertinggi dengan pengawasan mutu laboratorium bersertifikasi (Phytosanitary, Lab Purity, Moisture Control).\n2. Membangun ekosistem kemitraan petani yang adil, berkelanjutan, dan didukung transfer teknologi pasca-panen.\n3. Memberikan kepastian logistik, kepatuhan regulasi kepabeanan, dan keamanan transaksi bagi pembeli di Eropa, China, dan seluruh dunia.\n4. Menjadi jembatan terpercaya antara kekayaan alam nusantara dengan kebutuhan manufaktur makanan, farmasi, dan rempah global.",
        ];

        foreach ($settings as $key => $val) {
            Setting::updateOrCreate(['key' => $key], ['value' => $val, 'group' => 'general']);
        }

        // 3. 4 Initial Products
        $products = [
            [
                'name' => 'Indonesian Gourmet Vanilla Beans (Planifolia & Tahitensis)',
                'slug' => 'indonesian-gourmet-vanilla-beans',
                'category' => 'Vanili',
                'short_description' => 'Biji vanili premium grade A dari petani nusantara dengan aroma intens, kadar vanillin tinggi (>2.2%), dan kelembapan terkontrol untuk industri gourmet dan ekstraksi Eropa & China.',
                'description' => '<p><strong>Islenesia Vanilla Beans</strong> dipanen secara selektif pada tingkat kematangan optimal dan melalui proses pengeringan bertahap (curing) tradisional yang telah teruji menghasilkan kilau minyak alami, tekstur lentur, dan profil aroma vanillin murni yang kaya.</p>
                <h4>Keunggulan Produk:</h4>
                <ul>
                    <li><strong>Aroma Eksklusif:</strong> Wangi manis floral dan aroma woody khas tropis nusantara yang sangat kuat.</li>
                    <li><strong>Kadar Vanillin Tinggi:</strong> Teruji laboratorium dengan kandungan vanillin alami berkisar 2.0% - 2.4%.</li>
                    <li><strong>Fleksibilitas Penggunaan:</strong> Ideal untuk industri gourmet bakery, gelato, ekstraksi ekstrak vanili alami, dan kosmetik mewah di Eropa dan Asia.</li>
                    <li><strong>Kemasan Kedap Udara:</strong> Dikemas vakum per 1 kg atau custom bulk packaging food-grade untuk menjaga kelembapan selama pengiriman kontainer laut/udara.</li>
                </ul>',
                'specifications' => [
                    'Variety' => 'Planifolia & Tahitensis',
                    'Grade' => 'Gourmet / Grade A (Prime Extraction)',
                    'Length' => '15 - 20+ cm',
                    'Moisture Content' => '25% - 30%',
                    'Vanillin Content' => '2.0% - 2.4%',
                    'Packaging' => 'Vacuum sealed food-grade pack in master carton box',
                    'Origin' => 'Papua, Bali & North Sulawesi, Indonesia',
                    'MOQ' => '10 kg (Air Freight) / 500 kg (Sea Freight)',
                ],
                'image' => 'vanilla.jpg',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Premium Organic Kratom Powder (Mitragyna Speciosa)',
                'slug' => 'premium-organic-kratom-powder',
                'category' => 'Kratom',
                'short_description' => 'Bubuk kratom murni kualitas ekspor dari pohon dewasa pedalaman Kalimantan Barat. Diproses dengan teknologi nano-grind ultra halus, steril, dan bebas kontaminan mikroba.',
                'description' => '<p><strong>Islenesia Kratom Powder</strong> diproduksi langsung dari daun kratom (Mitragyna Speciosa) pilihan yang dipanen oleh komunitas petani lokal di pedalaman Kapuas Hulu, Kalimantan Barat. Menggunakan fasilitas pengeringan indoor higienis untuk menjaga kandungan alkaloid murni.</p>
                <h4>Keunggulan Produk:</h4>
                <ul>
                    <li><strong>Ultra-Fine Nano Grind:</strong> Bubuk kehalusan mesh 100-120 yang sangat mudah larut dan bertekstur lembut.</li>
                    <li><strong>Varian Lengkap:</strong> Tersedia dalam strain Green Maeng Da, Red Borneo, White Sumatra, dan Yellow Vein.</li>
                    <li><strong>Lab Certified:</strong> Diuji secara ketat untuk kandungan Mitragynine aktif serta bebas logam berat, Salmonella, dan E. Coli.</li>
                    <li><strong>Kapasitas Pasokan Skala Besar:</strong> Siap memenuhi pesanan bulk supply industri herbal hingga puluhan ton per bulan.</li>
                </ul>',
                'specifications' => [
                    'Botanical Name' => 'Mitragyna Speciosa',
                    'Available Strains' => 'Green Maeng Da, Red Borneo, White Sumatra',
                    'Form' => 'Ultra-fine Nano Powder (100 - 120 mesh)',
                    'Mitragynine Content' => '1.4% - 1.8% (Lab Tested)',
                    'Moisture Content' => '< 7.5%',
                    'Packaging' => 'Food Grade Multiwall Kraft Bag with PE Liner (25 kg)',
                    'Origin' => 'West Kalimantan, Indonesia',
                    'MOQ' => '100 kg / 1 Metric Ton (Container)',
                ],
                'image' => 'kratom.jpg',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Indonesian Specialty Coffee Beans (Arabica & Robusta)',
                'slug' => 'indonesian-specialty-coffee-beans',
                'category' => 'Kopi',
                'short_description' => 'Biji kopi pilihan Specialty Grade dari dataran tinggi Gayo Aceh, Toraja, Mandheling, dan Java Preanger serta Fine Robusta Lampung untuk roastery dan industri minuman dunia.',
                'description' => '<p>Indonesia terkenal dengan keanekaragaman cita rasa kopi terbaik di dunia. <strong>Islenesia</strong> menyuplai green beans kopi berkualitas tinggi yang dipetik tangan pada kematangan merah sempurna dan diproses dengan standar Specialty Coffee Association (SCA).</p>
                <h4>Keunggulan Produk:</h4>
                <ul>
                    <li><strong>Cupping Score Tinggi:</strong> Biji Arabica kami memiliki cupping score 84+ hingga 88 dengan kompleksitas rasa fruity, floral, dan brown sugar.</li>
                    <li><strong>Proses Pasca Panen Beragam:</strong> Tersedia Fully Washed, Wet Hulled (Giling Basah), Natural, Anaerobic Fermentation, dan Honey Process.</li>
                    <li><strong>Defect Rendah:</strong> Melalui proses double sortasi manual dan optic sorter untuk memastikan zero-defect sesuai standar ekspor Grade 1.</li>
                    <li><strong>Traceability Terjamin:</strong> Informasi single-origin yang transparan dari ketinggian kebun 1.200 - 1.650 mdpl.</li>
                </ul>',
                'specifications' => [
                    'Types' => 'Specialty Arabica & Fine Robusta',
                    'Origins' => 'Aceh Gayo, Sumatra Mandheling, Toraja, Lampung',
                    'Grade' => 'Grade 1 Specialty (Max defect 3%)',
                    'Altitude' => '1,200 - 1,650 MASL (Arabica), 600 - 800 MASL (Robusta)',
                    'Moisture' => '11% - 12.5%',
                    'Screen Size' => 'Size 16 - 18 (Large Bean)',
                    'Packaging' => 'GrainPro Hermetic Bag + 60 kg Jute Bag',
                    'MOQ' => '1,000 kg (LCL) / 1 FCL 20ft (19.2 MT)',
                ],
                'image' => 'coffee.jpg',
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Zanzibar & Lalpari Premium Whole Cloves (Cengkeh)',
                'slug' => 'zanzibar-lalpari-premium-whole-cloves',
                'category' => 'Cengkeh',
                'short_description' => 'Cengkeh kering utuh pilihan kualitas Lalpari & Zanzibar dari kepulauan Maluku & Sulawesi. Berkepala utuh, aroma menyengat, kaya minyak atsiri Eugenol murni.',
                'description' => '<p>Kepulauan Maluku adalah negeri rempah asli di mana cengkeh terbaik dunia tumbuh. <strong>Islenesia Cloves</strong> dipetik pada fase kuncup bunga optimal sebelum mekar, kemudian dijemur di bawah sinar matahari alami hingga mencapai tingkat kekeringan ideal tanpa bahan kimia tambahan.</p>
                <h4>Keunggulan Produk:</h4>
                <ul>
                    <li><strong>Kadar Eugenol Tinggi:</strong> Sangat diminati oleh industri farmasi, minyak atsiri, dan bumbu kuliner global di Eropa dan Asia.</li>
                    <li><strong>Karakteristik Fisik Unggul:</strong> Warna cokelat kemerahan cerah (Lalpari), batang tebal, kepala bunga utuh (headless < 2%), dan bebas dari tangkai asing.</li>
                    <li><strong>Kadar Air Stabil:</strong> Dikeringkan hingga kadar air di bawah 11% untuk mencegah pembentukan jamur selama perjalanan laut antarbenua.</li>
                </ul>',
                'specifications' => [
                    'Variety' => 'Zanzibar & Lalpari (Syzygium Aromaticum)',
                    'Grade' => 'Grade A / Lalpari Whole Clove',
                    'Headless Cloves' => '< 2%',
                    'Foreign Matters / Stems' => '< 0.5%',
                    'Moisture Content' => '10% - 12%',
                    'Foreign Matters / Stems' => '< 0.5%',
                    'Eugenol Content' => '16% - 19% (High Essential Oil)',
                    'Origin' => 'Maluku & Central Sulawesi, Indonesia',
                    'MOQ' => '1 Metric Ton / 20ft FCL (10 MT)',
                ],
                'image' => 'cloves.jpg',
                'is_featured' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($products as $prod) {
            Product::updateOrCreate(['slug' => $prod['slug']], $prod);
        }

        // 4. Testimonials (Europe, China, and Domestic Buyers)
        $testimonials = [
            [
                'client_name' => 'Marcus Vance',
                'client_company' => 'EuroFlavor Extracts GmbH',
                'client_country' => 'Germany',
                'rating' => 5,
                'content' => 'We have imported gourmet vanilla beans from Manunggaland for 2 consecutive years. The moisture control and vanillin consistency exceeded European laboratory criteria. Truly a reliable partner for Indonesian natural ingredients.',
                'avatar' => null,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'client_name' => 'Zhang Wei (张伟)',
                'client_company' => 'Shanghai Eastern Botanicals Ltd.',
                'client_country' => 'China',
                'rating' => 5,
                'content' => 'Dealing with Manunggaland has been exceptionally smooth. Their export team handles phytosanitary certificates and sea freight documentation flawlessly. The cloves and herbal botanicals met all import standards at Shanghai port.',
                'avatar' => null,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'client_name' => 'Élodie Laurent',
                'client_country' => 'France',
                'client_company' => 'Terroirs & Cafés de France',
                'rating' => 5,
                'content' => 'Their Gayo Aceh and Mandheling green coffee beans received outstanding cupping scores from our artisan roasters in Paris. Transparent direct-from-source traceability makes their supply chain very trustworthy.',
                'avatar' => null,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'client_name' => 'Bambang Hartono',
                'client_company' => 'PT Nusantara Herbal Abadi',
                'client_country' => 'Indonesia',
                'rating' => 5,
                'content' => 'Sebagai pembeli domestik untuk bahan baku manufaktur, Manunggaland sangat membantu stabilitas stok komoditas kami dengan standar mutu ekspor yang konsisten dan harga yang sangat bersaing.',
                'avatar' => null,
                'is_active' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($testimonials as $testi) {
            Testimonial::updateOrCreate(
                ['client_name' => $testi['client_name'], 'client_company' => $testi['client_company']],
                $testi
            );
        }

        // 5. Initial Blog Posts
        $posts = [
            [
                'title' => 'Panduan Ekspor Vanili Indonesia ke Pasar Eropa: Regulasi, Mutu, dan Peluang 2026',
                'slug' => 'panduan-ekspor-vanili-indonesia-ke-pasar-eropa-2026',
                'category' => 'Export Insights',
                'excerpt' => 'Pelajari persyaratan ketat pasar Uni Eropa mengenai residu pestisida, sertifikasi Phytosanitary, dan standar kadar vanillin alami untuk menembus pasar premium.',
                'content' => '<p>Vanili Indonesia (khususnya varietas Planifolia dan Tahitensis) memegang peranan strategis dalam rantai pasok industri gourmet dan flavor global. Pasar Eropa, terutama Jerman, Prancis, dan Belanda, memiliki permintaan yang terus bertumbuh terhadap vanili alami berkualitas tinggi dengan sertifikasi yang terverifikasi.</p>
                <h3>Standar Mutu yang Diminta Buyer Eropa:</h3>
                <p>Pembeli di Uni Eropa mewajibkan kontrol ketat terhadap beberapa parameter utama:</p>
                <ul>
                    <li><strong>Kadar Vanillin Alami:</strong> Minimal 2.0% yang dibuktikan dengan hasil uji HPLC laboratorium terakreditasi.</li>
                    <li><strong>Kelembapan (Moisture Content):</strong> Untuk Grade Gourmet, kadar air dijaga antara 28% - 32% agar polong tetap lentur tanpa resiko timbul jamur selama perjalanan laut.</li>
                    <li><strong>Bebas Pestisida dan Logam Berat:</strong> Memenuhi standar European Union Maximum Residue Limits (EU MRL).</li>
                </ul>
                <p>Manunggaland menerapkan sistem kurasi bertahap bersama petani mitra untuk memastikan setiap batch vanili yang diekspor telah lolos uji laboratorium dan dilengkapi Phytosanitary Certificate resmi dari Karantina Pertanian Indonesia.</p>',
                'meta_title' => 'Panduan Lengkap Ekspor Vanili Indonesia ke Pasar Eropa | Manunggaland',
                'meta_description' => 'Strategi dan standar ekspor biji vanili Indonesia ke pasar Eropa: kadar vanillin, sertifikasi karantina, dan proses kurasi Manunggaland.',
                'meta_keywords' => 'ekspor vanili eropa, vanilla bean export indonesia, standar vanili mutu gourmet, karantina pertanian vanili',
                'views_count' => 342,
                'likes_count' => 28,
                'is_published' => true,
                'published_at' => now()->subDays(5),
                'image' => 'blog-vanilla.jpg',
            ],
            [
                'title' => 'Menembus Pasar China: Peluang Ekspor Rempah & Produk Pertanian Indonesia',
                'slug' => 'menembus-pasar-china-peluang-ekspor-rempah-indonesia',
                'category' => 'Global Trade',
                'excerpt' => 'Bagaimana produsen dan agregator Indonesia memenuhi standar GACC (General Administration of Customs of China) untuk mengekspor rempah dan hasil perkebunan secara legal dan berkelanjutan.',
                'content' => '<p>China merupakan salah satu importir terbesar komoditas pertanian dan rempah tropis nusantara, terutama untuk rempah aromatik seperti cengkeh, kayu manis, dan biji pala, serta komoditas minuman seperti kopi.</p>
                <h3>Memahami Ketentuan Regulasi GACC:</h3>
                <p>Sejak penerapan regulasi ketat Decree 248 dan 249 oleh otoritas pabean China (GACC), setiap fasilitas pemrosesan dan eksportir wajib terdaftar secara resmi serta memenuhi protokol biosekuriti yang ketat.</p>
                <p>Dengan kemitraan langsung bersama agregator Manunggaland, seluruh rantai pasok terverifikasi dengan baik dari kebun hingga pelabuhan pengapalan, memberikan ketenangan penuh bagi mitra dagang di Shanghai, Guangzhou, dan Tianjin.</p>',
                'meta_title' => 'Peluang dan Regulasi Ekspor Rempah Indonesia ke China | Manunggaland',
                'meta_description' => 'Panduan ekspor komoditas dan rempah nusantara ke pasar China melalui kepatuhan regulasi GACC dan logistik maritim terpadu.',
                'meta_keywords' => 'ekspor ke china, rempah indonesia china, cengkeh ekspor tiongkok, gacc registration indonesia',
                'views_count' => 485,
                'likes_count' => 39,
                'is_published' => true,
                'published_at' => now()->subDays(12),
                'image' => 'blog-trade.jpg',
            ],
            [
                'title' => 'Mengapa Standar Lab QC Menjadi Kunci Sukses Ekspor Biji Kopi Spesialti',
                'slug' => 'standar-lab-qc-kunci-sukses-ekspor-kopi-spesialti',
                'category' => 'Quality Control',
                'excerpt' => 'Eksplorasi mendalam mengenai protokol grading SCA, moisture meter digital, dan pengemasan GrainPro dalam menjaga cita rasa kopi nusantara tetap prima saat tiba di luar negeri.',
                'content' => '<p>Perjalanan biji kopi hijau (green beans) dari pegunungan Indonesia menuju roastery di Eropa atau Asia Timur membutuhkan waktu antara 20 hingga 40 hari di atas kontainer kapal laut. Tanpa perlindungan dan uji mutu yang tepat, risiko kerusakan akibat kelembapan tinggi dan perubahan suhu sangatlah nyata.</p>
                <p>Manunggaland menggunakan kemasan <strong>GrainPro Hermetic Liners</strong> berlapis ganda di dalam karung goni (jute bags), serta memverifikasi kadar air tidak melebihi 12% menggunakan moisture analyzer calibrated. Hal ini menjamin karakteristik organoleptik khas Aceh Gayo dan Toraja tetap terjaga prima.</p>',
                'meta_title' => 'Protokol Quality Control Ekspor Kopi Spesialti Indonesia | Manunggaland',
                'meta_description' => 'Pentingnya QC laboratorium dan kemasan GrainPro dalam ekspor green beans kopi Indonesia ke pasar internasional.',
                'meta_keywords' => 'kopi spesialti ekspor, green beans qc, grainpro export, gayo coffee export, specialty coffee indonesia',
                'views_count' => 278,
                'likes_count' => 19,
                'is_published' => true,
                'published_at' => now()->subDays(20),
                'image' => 'blog-coffee.jpg',
            ],
        ];

        foreach ($posts as $postData) {
            $post = Post::updateOrCreate(['slug' => $postData['slug']], $postData);
            
            // Add initial comments
            Comment::updateOrCreate(
                ['post_id' => $post->id, 'author_email' => 'buyer.berlin@example.com'],
                [
                    'author_name' => 'Klaus Schmidt',
                    'comment' => 'Very insightful article regarding moisture standards. We are looking for forward contracts for Q3 vanilla shipment.',
                    'is_approved' => true,
                    'ip_address' => '127.0.0.1',
                ]
            );
            Comment::updateOrCreate(
                ['post_id' => $post->id, 'author_email' => 'rudy.petani@example.com'],
                [
                    'author_name' => 'Rudy Kurniawan',
                    'comment' => 'Terima kasih atas edukasinya. Sangat membantu petani memahami standar yang diinginkan buyer luar negeri.',
                    'is_approved' => true,
                    'ip_address' => '127.0.0.1',
                ]
            );
        }
    }
}
