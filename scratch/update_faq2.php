<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Faq;

$f = Faq::find(2);
if ($f) {
    $f->category = 'Logistik & Ekspor';
    $f->save();
    echo "FAQ 2 category updated to Logistik & Ekspor\n";
}
