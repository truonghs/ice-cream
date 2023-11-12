<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Models\Product;


class ProductController extends Controller
{

    protected $table = 'products';
    public function index(Request $request)
    {
        $user = $request->user();
        return ProductResource::collection(
            Product::where('seller_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get()
            // ->paginate()
        );
    }
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        if (isset($data['image'])) {
            $relativePath = $this->saveImage($data['image']);
            $data['image'] = $relativePath;
        }
        $product = Product::create($data);
        return new ProductResource($product);
    }
    public function show(Product $product, Request $request)
    {
        $user = $request->user();
        if ($user->id !== $product->seller_id) {
            return abort(403, 'Unauthorized action');
        }
        return new ProductResource($product);
    }
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();
        if (isset($data['image'])) {
            $relativePath = $this->saveImage($data['image']);
            $data['image'] = $relativePath;
            if ($product->image) {
                $absolutePath = public_path($product->image);
                File::delete($absolutePath);
            }
        }
        $product->update($data);
        return new ProductResource($product);
    }
    public function destroy(Product $product, Request $request)
    {

        $user = $request->user();
        if ($user->id !== $product->seller_id) {
            return abort(403, 'Unauthorized action');
        }
        $product->delete();
        if($product->image) {
            $absolutePath = public_path($product->image);
            File::delete($absolutePath);    
        }
        return response('delete successfully',204);
    }
    private function saveImage($image)
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $image, $type)) {
            $image = substr($image, strpos($image, ',') + 1);
            $type = strtolower($type[1]);

            if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                throw new \Exception('invalid image type');
            }

            $image = str_replace(' ', '+', $image);
            $image = base64_decode($image);
            if ($image === false) {
                throw new \Exception('base64_decode failed');
            }
        } else {
            throw new \Exception('did not match data URI with image data');
        }
        $dir = 'images/';
        $file = Str::random() . '.' . $type;
        $absolutePath = public_path($dir);
        $relativePath = $dir . $file;
        if (!File::exists($absolutePath)) {
            File::makeDirectory($absolutePath, 0755, true);
        }

        file_put_contents($relativePath, $image);
        return $relativePath;
    }
}