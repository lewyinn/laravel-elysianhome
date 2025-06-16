<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('be.product.index', [
            'title' => 'Product',
            'product' => Product::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('be.product.create', [
            'title' => 'Product',
            'categories' => Category::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // Upload image
        $imageName = time() . '_' . $request->image->getClientOriginalName();
        $request->image->move(public_path('storage/product'), $imageName);

        // Simpan ke database
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imageName,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('product.index')->with('success', 'Product berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('be.product.edit', [
            'title' => 'Product',
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'name' => 'required|max:100',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product = Product::findOrFail($id);

        // Cek apakah user upload gambar baru
        if ($request->hasFile('image')) {
            $newImage = $request->file('image');
            $newImageName = time() . '_' . $newImage->getClientOriginalName();

            // Cek apakah nama file berbeda dengan gambar lama
            if ($newImageName !== $product->image) {
                // Hapus gambar lama
                $oldImagePath = public_path('storage/product/' . $product->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }

                // Pindahkan gambar baru
                $newImage->move(public_path('storage/product'), $newImageName);

                // Update nama gambar di database
                $product->image = $newImageName;
            }
        }

        // Update data lain
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('product.index')->with('success', 'Product berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $product = Product::findOrFail($id);

        // Optional: Hapus gambar dari folder jika perlu
        $imagePath = public_path('storage/product/' . $product->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product berhasil dihapus.');
    }
}
