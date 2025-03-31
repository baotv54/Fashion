<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    // public function getAll($perPage = 2)
    // {
    //     // Trả về Query Builder và phân trang
    //     return Product::with('images')->paginate($perPage);
    // }
    public function getAllWithSearch($search = null, $perPage = 5)
    {
        $query = Product::with('category', 'brand', 'images'); 
    
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }
    
        // Phân trang kết quả
        return $query->paginate($perPage);
    }

    public function findById($id)
    {
        return Product::with('images')->find($id);
    }


    public function create($data)
    {
        $product = Product::create($data);

        if (!empty($data['images'])) {
            $this->addImage($product->id, $data['images']);
        }

        return $product;
    }

    public function update($id, $data)
    {
        $product = Product::findOrFail($id);

        // Cập nhật các thông tin khác của sản phẩm
        $product->update($data);

        // Lấy danh sách ID hình ảnh cần giữ lại
        $keepImageIds = isset($data['keep_images']) ? $data['keep_images'] : [];

        // Xóa các hình ảnh không nằm trong danh sách này
        ProductImage::where('product_id', $id)
            ->whereNotIn('id', $keepImageIds)
            ->each(function ($image) {
                if (file_exists(public_path($image->image_path))) {
                    unlink(public_path($image->image_path));
                }
                $image->delete();
            });

        // Thêm hình ảnh mới (nếu có)
        if (!empty($data['images'])) {
            foreach ($data['images'] as $imageFile) {
                $fileName = time() . '_' . $imageFile->getClientOriginalName();
                $destinationPath = public_path('uploads/products');
                $imageFile->move($destinationPath, $fileName);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'uploads/products/' . $fileName
                ]);
            }
        }

        return $product;
    }



    public function delete($id)
    {
        $this->deleteImage($id);
        return Product::destroy($id);
    }

    public function addImage($productId, $images)
    {
        foreach ($images as $imageFile) {
            // Tạo tên file độc nhất với thời gian và tên gốc của file
            $fileName = time() . '_' . $imageFile->getClientOriginalName();

            // Đường dẫn lưu file trong thư mục public/uploads/products
            $destinationPath = public_path('uploads/products');

            // Di chuyển file đến thư mục public/uploads/products
            $imageFile->move($destinationPath, $fileName);

            // Lưu đường dẫn file vào database
            ProductImage::create([
                'product_id' => $productId,
                'image_path' => 'uploads/products/' . $fileName
            ]);
        }
    }




    public function deleteImage($id)
    {
        $image = ProductImage::find($id);

        if (!$image) {
            return response()->json(['success' => false, 'message' => 'Hình ảnh không tồn tại.'], 404);
        }

        // Xóa file vật lý trong thư mục public/uploads/products
        if (file_exists(public_path($image->image_path))) {
            unlink(public_path($image->image_path));
        }

        // Xóa bản ghi trong database
        $image->delete();

        return response()->json(['success' => true, 'message' => 'Hình ảnh đã được xóa.']);
    }
    public function search($query)
    {
        return Product::where('name', 'LIKE', "%$query%")->with('images')->get();
    }
}
