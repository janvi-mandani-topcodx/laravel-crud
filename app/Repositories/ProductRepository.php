<?php

namespace App\Repositories;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class ProductRepository extends BaseRepository
{
    public function model()
    {
        return Product::class;
    }

    public function store($data)
    {
        $media = Arr::only($data, 'image');
        $product = Arr::only($data, ['title', 'description']);
        $productVariant = Arr::only($data, ['variantTitle', 'price', 'sku']);

        if (isset($product['status'])) {
            $product['status'] = 1;
        } else {
            $product['status'] = 0;
        }

        $product = Product::create($product);
        if ($media) {
            foreach ($media['image'] as $file) {
                $product->addMedia($file)->toMediaCollection('product');
            }
        }
        $this->productVariant($productVariant, $product);

        return response()->json(['success' => 'product created successfully.']);
    }

    public function productVariant($productVariant, $product)
    {
        $variants = [];
        foreach ($productVariant['variantTitle'] as $key => $value) {
            $variant = [
                'title' => $productVariant['variantTitle'][$key],
                'price' => $productVariant['price'][$key],
                'sku' => $productVariant['sku'][$key],
            ];
            if (isset($productVariant['editId'][$key])) {
                $variant['editId'] = $productVariant['editId'][$key];
            }
            $variants[] = $variant;
        }
        foreach ($variants as $variant) {
            $variantData = Arr::except($variant, 'editId');


            if(isset($variant['editId']) && $variant['editId'] != 'undefined') {
                $productDetails = ProductVariant::where('id', $variant['editId'])->first();
                $productDetails->update($variantData);
            }
            elseif (!isset($variantData['editId']) || $variant['editId'] == 'undefined') {
                $product->productVarients()->create($variantData);
            }
        }
    }

    public function update($data, $products)
    {
        $product = Arr::only($data, ['title', 'description', 'status']);
        $productVariant = Arr::only($data, ['variantTitle', 'price', 'sku' , 'editId']);
        $this->productVariant($productVariant, $products);

        if (isset($product['status'])) {
            $product['status'] = 1;
        } else {
            $product['status'] = 0;
        }
        $products->update($product);
        return response()->json(['success' => 'User updated successfully.']);
    }
}

