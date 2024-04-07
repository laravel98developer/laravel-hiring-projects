<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    private $model;

    public function __construct(Product $product)
    {
        $this->model = $product;
    }

    public function getAll($showDataOptions)
    {
        $products = $this->model->query();
        if (isset($showDataOptions['title'])) {
            $products->where('title', 'like', '%' . $showDataOptions['title'] . '%');
        }
        $sort_column = $showDataOptions['sort_column'] ?? 'created_at';
        $products->orderBy($sort_column, isset($showDataOptions['is_sort_dir_desc']) && $showDataOptions['is_sort_dir_desc']=='true' ? 'desc' : 'asc');

        return $products->paginate($showDataOptions['per_page'] ?? 10);
    }

    public function create($productData)
    {
        return $this->model->create($productData);
    }

    public function getById($productId)
    {
        return $this->model->findOrFail($productId);
    }

    public function update($productId, $productData)
    {
        $product = $this->getById($productId);
        return $product->update($productData);
    }

    public function delete($productId)
    {
        $product = $this->getById($productId);
        return $product->delete();
    }


}
