<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Berapa Minimum Order Quantity (MOQ) untuk pemesanan komoditas ekspor?',
                'answer' => 'MOQ kami sangat fleksibel. Untuk uji sampel komersial awal, kami melayani LCL (100 kg hingga 1 metrik ton). Untuk kontrak reguler pembeli industri, kami melayani pengapalan FCL kontainer 1x20ft (15-18 MT) maupun 1x40ft kontainer sesuai jenis komoditas (Vanili Gourmet, Bubuk Kratom Organik, Kopi Spesialti, dan Cengkeh Lalpari).',
                'category' => 'Ekspor & Pemesanan',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'question' => 'Pelabuhan muat apa saja yang digunakan dan bagaimana estimasi pengiriman internasional?',
                'answer' => 'Pelabuhan muat (Port of Loading) utama kami berpusat di Pelabuhan Tanjung Priok (Jakarta) dan Pelabuhan Tanjung Perak (Surabaya). Pengapalan langsung tersedia ke pelabuhan utama Eropa (Rotterdam, Hamburg, Le Havre) dan China (Shanghai, Guangzhou, Qingdao) dengan jadwal kapal reguler mingguan.',
                'category' => 'Logistik & Pelabuhan',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'question' => 'Bagaimana cara petani lokal atau kelompok tani mengajukan hasil panen ke meja agregator?',
                'answer' => 'Petani atau ketua kelompok tani (Gapoktan) dapat langsung menghubungi meja agregator kami melalui formulir kontak atau tombol WhatsApp "Saya Petani". Tim Quality Control kami akan melakukan pengambilan sampel uji kadar air dan kemurnian, memberikan pendampingan standar mutu ekspor, dan membeli hasil panen dengan pembayaran langsung serta harga pasar yang adil tanpa potongan perantara.',
                'category' => 'Kemitraan Petani',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'question' => 'Sertifikasi dan dokumen legalitas apa saja yang disertakan dalam setiap kontainer ekspor?',
                'answer' => 'Setiap kontainer disertai dokumen ekspor berstandar global lengkap: Sertifikat Phytosanitary resmi dari Badan Karantina Pertanian Indonesia, Certificate of Origin (COO), Bill of Lading (B/L), Commercial Invoice, Packing List, serta Certificate of Analysis (COA) uji laboratorium independen mencakup kadar air, residu pestisida, dan kemurnian mikrobiologi.',
                'category' => 'Legalitas & Mutu',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'question' => 'Metode pembayaran internasional apa yang didukung untuk Buyer luar negeri?',
                'answer' => 'Untuk kenyamanan transaksi perdagangan global, kami menerima sistem Telegraphic Transfer (T/T dengan deposit dan pelunasan saat dokumen ekspor diterbitkan) serta Irrevocable Letter of Credit (L/C at sight) terbitan bank internasional terkemuka guna menjamin keamanan kedua belah pihak.',
                'category' => 'Pembayaran & Kontrak',
                'sort_order' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $f) {
            Faq::updateOrCreate(['question' => $f['question']], $f);
        }
    }
}
