<?php
namespace App\Services;

use App\Repositories\BrandRepository;
use Illuminate\Support\Str;
use App\Models\Brand;


class BrandService
{
    protected $brandRepo;

    public function __construct(BrandRepository $brandRepo)
    {
        $this->brandRepo = $brandRepo;
    }

    public function getAllBrands()
    {
        return $this->brandRepo->getAll();
    }

    public function createBrand($data)
    {
        $data['slug'] = Str::slug($data['name']);
        return $this->brandRepo->create($data);
    }

    public function updateBrand($id, $data)
    {
        $data['slug'] = Str::slug($data['name']);
        return $this->brandRepo->update($id, $data);
    }

    public function deleteBrand($id)
    {
        return $this->brandRepo->delete($id);
    }
    public function findById($id)
    {
        return Brand::find($id);
    }
    
}
