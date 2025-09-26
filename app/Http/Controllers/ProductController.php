<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private $productRepo;

    public function __construct(ProductRepository $productRepository)
    {
        $this->ProductRepo = $productRepository;
    }
    public function index(Request $request)
    {
        $product = Product::all();
        if ($request->ajax()) {
            return DataTables::of(Product::get())
                ->editColumn('image', function ($product) {
                    $userImage = $product->Image_url;
                    $images = '';
                    if (is_array($userImage)) {
                        foreach ($userImage as $img) {
                            $images .= '<img src="' . $img . '" alt="user image" width="80" height="80" class="img-thumbnail"/><br>';
                        }
                    }
                    return $images;
                })
                ->rawColumns(['image'])
                ->make(true);
        }
        return view('product.index', compact('product'));
    }


    public function create()
    {
        return view ('product.create');
    }


    public function store(CreateProductRequest $request)
    {
        $input = $request->all();
        $this->ProductRepo->store($input);
    }

    public function show(string $id)
    {
        $product = Product::find($id);
        return view('product.show', compact('product' ));
    }


    public function edit(string $id)
    {
        $product = Product::find($id);
        return view('product.edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, string $id)
    {
        $product = Product::find($id);
        $input = $request->all();
        $description = strip_tags($input['description']);
        if($description == '') {
            return response()->json(['error' => 'Enter description'], 422);
        }
        $deleteImg = $product->getMedia('product');
        if($request->hasFile('image')){
            foreach ($input['image'] as $file) {
                $product->addMedia($file)->toMediaCollection('product');
            }
            if($deleteImg){
                foreach ($deleteImg as $images){
                    $images->delete();
                }
            }
        }

        $this->ProductRepo->update($input, $product);
    }

    public function destroy(string $id)
    {
        $product = Product::find($id);
        $product->delete();
        $deleteImg = $product->getMedia('product');
        $product->productVarients()->delete();
        if($deleteImg)
        {
            foreach ($deleteImg as $img) {
                $img->delete();
            }
        }
        return response()->json(['success' => 'Product delete successfully.']);
    }

        public  function  variantDelete(Request $request)
        {
            $id = $request->id;
            $variant = ProductVariant::find($id);
            $variant->delete();
        }

        public function proCart()
        {
            $products = Product::all();
            $carts = Cart::with(['product' , 'variant'])->where('user_id' , auth()->id())->get();
            return view('product_cart.index', compact('products' , 'carts'));
        }
}
