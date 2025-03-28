<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    public function all()
    {
        return Category::whereNull('parent_id')->with('children')->get();
    }

    public function find($id)
    {
        return Category::with('children')->find($id);
    }

    public function create($data)
    {
        return Category::create($data);
    }
}
