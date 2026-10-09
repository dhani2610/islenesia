<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

foreach (App\Models\Faq::all() as $f) {
    echo "ID: {$f->id} | Cat: {$f->category} | Q: {$f->question}\n";
    echo "A: {$f->answer}\n\n";
}
