<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Http\Requests\StoreProductRequest; // WAJIB: Import file Request yang baru dibuat
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class ProductController extends Controller
{
    public function index()
    {
        // Gunakan paginate agar tampilan rapi dan tidak berat
        $products = Product::with('user')->paginate(10);
        return view('product.index', compact('products'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('product.create', compact('users'));
    }

    /**
     * Store menggunakan StoreProductRequest (Validasi Terpisah)
     */
    public function store(StoreProductRequest $request)
    {
        // Data otomatis tervalidasi sebelum masuk ke sini
        $validated = $request->validated();

        try {
            Product::create([
                'title'   => $validated['name'],
                'stock'   => $validated['quantity'],
                'price'   => $validated['price'],
                'user_id' => $validated['user_id'],
            ]);

            return redirect()
                ->route('product.index')
                ->with('success', 'Product created successfully.');

        } catch (QueryException $e) {
            Log::error('Product store database error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Database error while creating product.');
        } catch (\Throwable $e) {
            Log::error('Product store unexpected error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Unexpected error occurred.');
        }
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('product.view', compact('product'));
    }

    public function edit(Product $product)
    {
        // Memastikan hanya pemilik/admin yang bisa edit (via Policy)
        Gate::authorize('update', $product); 
        
        $users = User::orderBy('name')->get();
        return view('product.edit', compact('product', 'users'));
    }

    /**
     * Update dengan Validasi Langsung di Controller
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Tambahkan validasi min:0 agar harga/stok tidak minus
        $validated = $request->validate([ 
            'name'     => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'price'    => 'required|numeric|min:0',
            'user_id'  => 'required|exists:users,id',
        ], [
            'name.required' => 'Nama produk tidak boleh kosong!',
            'price.numeric' => 'Harga harus berupa angka.',
        ]);

        $product->update([
            'title'   => $validated['name'],
            'stock'   => $validated['quantity'],
            'price'   => $validated['price'],
            'user_id' => $validated['user_id'],
        ]);

        return redirect()->route('product.index')->with('success', 'Product updated successfully.');
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        
        Gate::authorize('delete', $product); 
        
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product berhasil dihapus');
    }
}