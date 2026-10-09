<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use App\Models\Faq;
use App\Models\Setting;

foreach (Product::all() as $p) {
    $s = $p->specifications ?? [];
    if (isset($s['Port of Loading'])) {
        unset($s['Port of Loading']);
    }
    // Also remove any mention of Manunggaland in product description
    $p->description = str_replace('Manunggaland', 'Islenesia', $p->description);
    $p->specifications = $s;
    $p->save();
}

foreach (Faq::all() as $f) {
    $f->question = str_replace('Pelabuhan muat apa saja yang digunakan dan bagaimana', 'Bagaimana prosedur dan', $f->question);
    $f->answer = str_replace('Pelabuhan muat (Port of Loading) utama kami berpusat di Pelabuhan Tanjung Priok (Jakarta) dan Pelabuhan Tanjung Perak (Surabaya). ', '', $f->answer);
    $f->save();
}

// Ensure address setting is clean
Setting::updateOrCreate(
    ['key' => 'address'],
    ['value' => 'Gedung Graha Agro Nusantara Lt. 4, Jakarta, Indonesia', 'group' => 'general']
);

\Illuminate\Support\Facades\Cache::forget('all_settings');

echo "Database cleaned successfully!\n";
