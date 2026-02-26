<?php

namespace App\Http\Controllers;

use App\Models\Product; // Model Product, merepresentasikan tabel products
use Illuminate\Http\Request; // Untuk menangani HTTP request umum
use App\Http\Requests\ProductRequest; // Form Request untuk validasi input Product
use App\Http\Resources\ProductResource; // API Resource untuk satu product
use App\Http\Resources\ProductCollection; // API Resource Collection untuk banyak product
use Illuminate\Support\Facades\Storage; // Untuk handling file image jika diperlukan
use Illuminate\Http\Response; // Untuk HTTP response code

class ProductController extends Controller
{
    /*** Menampilkan daftar produk dengan pagination.*/
    public function index()
    {
        // Ambil semua produk terbaru, 10 per halaman
        $products = Product::latest()->paginate(10);

        // Kembalikan response JSON dengan ProductCollection
        return response()->json(
            new ProductCollection($products), 
            Response::HTTP_OK // HTTP 200 OK
        );
    }

    /*** Menyimpan produk baru ke database.*/
    public function store(ProductRequest $request)
    {
        // Ambil data yang sudah tervalidasi dari ProductRequest
        $product = Product::create($request->validated());

        // Kembalikan response JSON dengan ProductResource
        return response()->json([
            'status' => true,
            'message' => 'Product created successfully',
            'data' => new ProductResource($product),
        ], Response::HTTP_CREATED); // HTTP 201 Created
    }

    /*** Menampilkan detail satu produk berdasarkan model binding.*/
    public function show(Product $product)
    {
        return response()->json([
            'status' => true,
            'message' => 'Product retrieved successfully',
            'data' => new ProductResource($product)
        ], Response::HTTP_OK); // HTTP 200 OK
    }

    /*** Mengupdate produk berdasarkan model binding.*/
    public function update(ProductRequest $request, Product $product)
    {
        // Update produk dengan data validasi
        $product->update($request->validated());

        // Kembalikan response JSON
        return response()->json([
            'status' => true,
            'message' => 'Product updated successfully',
            'data' => new ProductResource($product),
        ], Response::HTTP_OK); // HTTP 200 OK
    }

    /*** Menghapus produk berdasarkan model binding.*/
    public function destroy(Product $product)
    {
        // Hapus record produk dari database
        $product->delete();

        // Kembalikan response JSON sukses
        return response()->json([
            'status' => true,
            'message' => 'Product deleted successfully',
        ], Response::HTTP_OK); // HTTP 200 OK
    }
}