<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    // Tạo slug không trùng
    private function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $original = $slug;
        $count = 1;

        while (Product::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $count;
            $count++;
        }

        return $slug;
    }

    public function model(array $row)
    {
        if (empty($row['name']) || empty($row['image'])) {
            return null;
        }

        // Thư mục ảnh
        $tmpDir = storage_path('app/tmp-images/');
        $destDir = public_path('uploads/products/');

        // Xử lý ảnh chính
        $imageName = trim($row['image']);
        $imagePath = 'uploads/products/' . $imageName;

        // Tạo slug duy nhất
        $slug = $this->generateUniqueSlug($row['name']);

        // Tạo sản phẩm
        $product = Product::create([
            'name'        => $row['name'],
            'slug'        => $slug,
            'price'       => $row['price'],
            'description' => $row['description'],
            'brand_id'    => $row['brand_id'],
            'category_id' => $row['category_id'],
            'image'       => $imagePath, // Lưu full path
            'status'      => strtolower($row['status']) === 'active' || $row['status'] == 1 ? 1 : 0,
        ]);

        // Copy ảnh chính
        if (File::exists($tmpDir . $imageName)) {
            File::ensureDirectoryExists($destDir);
            File::copy($tmpDir . $imageName, public_path($imagePath));
        }

        // Xử lý ảnh phụ
        if (!empty($row['images'])) {
            $images = explode(',', $row['images']);
            foreach ($images as $img) {
                $img = trim($img);
                $imgPath = 'uploads/products/' . $img;

                $product->images()->create([
                    'image_path' => $imgPath,
                ]);

                if (File::exists($tmpDir . $img)) {
                    File::copy($tmpDir . $img, public_path($imgPath));
                }
            }
        }

        return $product;
    }
}
