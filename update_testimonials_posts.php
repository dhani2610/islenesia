<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Testimonial;
use App\Models\Post;

foreach (Testimonial::all() as $t) {
    $t->content = str_replace('Manunggaland', 'Islenesia', $t->content);
    $t->save();
}

foreach (Post::all() as $p) {
    $p->title = str_replace('Manunggaland', 'Islenesia', $p->title);
    $p->content = str_replace('Manunggaland', 'Islenesia', $p->content);
    $p->excerpt = str_replace('Manunggaland', 'Islenesia', $p->excerpt);
    $p->save();
}

echo "Testimonials and Posts updated to Islenesia!\n";
