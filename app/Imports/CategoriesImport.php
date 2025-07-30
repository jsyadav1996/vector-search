<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CategoriesImport implements ToCollection
{

    public function collection(Collection $rows)
    {
        // Only import if the tables are empty
        if (Category::exists() || SubCategory::exists()) {
            echo "Empty the Category and SubCategory tables before import! \n";
            return;
        }
        echo "Import started...\n";
        echo "In progress, please wait ...\n";

        // Get unique sub categories and group them by category
        $unique = $rows->unique('1');
        $unique->values()->all();
        $unique = $unique->slice(1);
        $grouped = $unique->groupBy('0');

        foreach ($grouped as $categoryName => $subCategories) {
            $category = Category::create(['name' => $categoryName]); 
            if ($category) {
                foreach ($subCategories as $subCategoryItem) {
                    // Generate embedding for the sub category
                    $embedding = generateEmbedding($subCategoryItem[1]);
                    SubCategory::create([
                        'category_id' => (int) $category->id,
                        'name' => $subCategoryItem[1],
                        'embeddings' => json_encode($embedding) // store as JSON
                    ]); 
                }
            }
        }
        echo "Import completed...\n";
        return;
    }
}
