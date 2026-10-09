<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

$updates = [
    1 => 'Vanili',
    2 => 'Kratom',
    3 => 'Kopi',
    4 => 'Cengkeh',
];

foreach ($updates as $id => $category) {
    $p = Product::find($id);
    if ($p) {
        $p->category = $category;
        $p->save();
        echo "Updated Product {$p->id}: {$p->name} -> Category: {$category}\n";
    }
}

// Check other products if any
$allProducts = Product::all();
foreach ($allProducts as $p) {
    if ($p->id > 4) {
        // Map category if it resembles one of the four
        $lower = strtolower($p->name . ' ' . $p->category);
        if (str_contains($lower, 'vanil')) {
            $p->category = 'Vanili';
        } elseif (str_contains($lower, 'kratom')) {
            $p->category = 'Kratom';
        } elseif (str_contains($lower, 'kopi') || str_contains($lower, 'coffee')) {
            $p->category = 'Kopi';
        } elseif (str_contains($lower, 'cengkeh') || str_contains($lower, 'clove')) {
            $p->category = 'Cengkeh';
        }
        $p->save();
        echo "Product {$p->id}: {$p->name} -> Category: {$p->category}\n";
    }
}

Cache::flush();
echo "Categories updated and cache cleared successfully!\n";
