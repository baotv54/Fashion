<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Danh mục chính
        $menShoes = Category::create(['name' => 'Giày Nam', 'slug' => 'giay-nam', 'parent_id' => null]);
        $womenShoes = Category::create(['name' => 'Giày Nữ', 'slug' => 'giay-nu', 'parent_id' => null]);
        $sportsShoes = Category::create(['name' => 'Giày Thể Thao', 'slug' => 'giay-the-thao', 'parent_id' => null]);

        // Danh mục con của "Giày Nam"
        Category::create(['name' => 'Sneaker Nam', 'slug' => 'sneaker-nam', 'parent_id' => $menShoes->id]);
        Category::create(['name' => 'Giày Tây Nam', 'slug' => 'giay-tay-nam', 'parent_id' => $menShoes->id]);

        // Danh mục con của "Giày Nữ"
        Category::create(['name' => 'Sneaker Nữ', 'slug' => 'sneaker-nu', 'parent_id' => $womenShoes->id]);
        Category::create(['name' => 'Giày Cao Gót', 'slug' => 'giay-cao-got', 'parent_id' => $womenShoes->id]);

        // Danh mục con của "Giày Thể Thao"
        Category::create(['name' => 'Chạy Bộ', 'slug' => 'chay-bo', 'parent_id' => $sportsShoes->id]);
        Category::create(['name' => 'Bóng Rổ', 'slug' => 'bong-ro', 'parent_id' => $sportsShoes->id]);
    }
}
