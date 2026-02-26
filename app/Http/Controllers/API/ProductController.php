<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /*** Menampilkan daftar produk dengan pagination. */
    public function index()
    {
        $products = Product::latest()->paginate(10);

        // Gunakan ProductCollection, pastikan ProductResource handle image URL
        return response()->json(
            new ProductCollection($products), 
            Response::HTTP_OK
        );
    }

    /*** Menyimpan produk baru ke database. */
    public function store(ProductRequest $request)
    {
        $data = $request->validated();

        // Jika ada file image, simpan di storage/app/public/images
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $data['image'] = $path; // simpan path relatif
        }

        $product = Product::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Product created successfully',
            'data' => new ProductResource($product),
        ], Response::HTTP_CREATED);
    }

    /*** Menampilkan detail satu produk berdasarkan model binding. */
    public function show(Product $product)
    {
        return response()->json([
            'status' => true,
            'message' => 'Product retrieved successfully',
            'data' => new ProductResource($product)
        ], Response::HTTP_OK);
    }

    /*** Mengupdate produk berdasarkan model binding. */
    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();

        // Jika ada image baru, simpan dan replace
        if ($request->hasFile('image')) {
            // Hapus image lama kalau ada
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $path = $request->file('image')->store('images', 'public');
            $data['image'] = $path;
        }

        $product->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Product updated successfully',
            'data' => new ProductResource($product),
        ], Response::HTTP_OK);
    }

    /*** Menghapus produk berdasarkan model binding. */
    public function destroy(Product $product)
    {
        // Hapus file image jika ada
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return response()->json([
            'status' => true,
            'message' => 'Product deleted successfully',
        ], Response::HTTP_OK);
    }
}