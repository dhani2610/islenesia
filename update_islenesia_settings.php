<?php

use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// 1. Ensure Admin User exists for both admin@islenesia.com and admin@manunggaland.com
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
        'password' => Hash::make('Manunggal2026!'),
    ]
);

// 2. Update Settings to Islenesia
$updates = [
    'site_name' => 'Islenesia',
    'site_tagline' => 'Global Agro Commodity Aggregator & Direct Exporter',
    'site_description' => 'PT Islenesia Agro Nusantara adalah eksportir dan agregator komoditas agrikultur premium Indonesia yang menghubungkan hasil bumi petani nusantara langsung ke pasar global (China, Eropa, Timur Tengah, dan Amerika) dengan jaminan mutu internasional dan legalitas penuh.',
    'company_name' => 'PT Islenesia Agro Nusantara',
    'email' => 'info@islenesia.com',
    'meta_title' => 'Islenesia | Premium Indonesian Agricultural Exporter to China & Europe',
    'meta_description' => 'Direct exporter of Indonesian Vanilla Beans, Organic Kratom, Specialty Coffee, and Cloves. Verified supply chain, lab-tested quality, and international shipping.',
    'meta_keywords' => 'islenesia, indonesian exporter, vanilla beans export, kratom supplier wholesale, coffee green beans indonesia, clove exporter, agricultural aggregator indonesia',
    'social_instagram' => 'https://instagram.com/islenesia.export',
    'social_facebook' => 'https://facebook.com/islenesia.id',
    'social_tiktok' => 'https://tiktok.com/@islenesia.export',
    'social_youtube' => 'https://youtube.com/@islenesia',
    'social_linkedin' => 'https://linkedin.com/company/islenesia',
    
    // About Story
    'about_story' => 'Islenesia didirikan dengan tekad kuat untuk mengangkat komoditas pertanian terbaik Indonesia ke panggung internasional. Beroperasi sebagai agregator terpercaya, kami bekerja sama langsung dengan lebih dari 1.400 petani mitra di berbagai sentra perkebunan nusantara—mulai dari Aceh, Jawa, Maluku, hingga Papua. Dengan memangkas rantai perantara yang tidak efisien, kami memastikan petani memperoleh harga yang adil serta pembeli internasional (Eropa, China, Asia Timur, dan Amerika) mendapatkan kepastian pasokan, transparansi mutu laboratorium, dan harga yang sangat kompetitif.',
    'about_vision' => 'Menjadi gerbang utama dan agregator komoditas pertanian terkemuka dari Indonesia yang diakui secara global atas integritas, kualitas mutu tanpa kompromi, dan keberlanjutan rantai pasok dari petani ke industri dunia.',
    
    // Catalog Section in Homepage
    'home_catalog_badge' => 'KATALOG KOMODITAS UNGGULAN',
    'home_catalog_title' => 'Hasil Bumi Terbaik dari Perkebunan Nusantara',
    'home_catalog_subtitle' => 'Setiap produk melalui proses kurasi ketat, pengeringan higienis, dan pengujian laboratorium independen sebelum pengapalan internasional.',
    
    // Address (remove specific port if desired, keep clean professional HQ)
    'address' => 'Gedung Graha Agro Nusantara Lt. 4, Jakarta, Indonesia',
];

foreach ($updates as $k => $v) {
    Setting::updateOrCreate(['key' => $k], ['value' => $v, 'group' => 'general']);
}

// Clear Settings Cache
Cache::forget('all_settings');

echo "SUCCESS: Settings updated to Islenesia and cache cleared!\n";
