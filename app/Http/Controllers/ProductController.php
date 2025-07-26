<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  
    public function index()
    {
        $products = Product::paginate(10);
        return view('index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
//   use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

public function store(Request $request)
{
    $validated = $request->validate([
        'name' => ['required', 'max:255'],
        'image' => ['required', 'image', 'max:2048'],
        'price' => ['required', 'numeric'],
        'description' => 'required',
    ]);

    try {
        // Verify file exists and is valid
        if (!$request->hasFile('image') || !$request->file('image')->isValid()) {
            throw new \Exception('Invalid file upload');
        }

        // Initialize Cloudinary configuration
        $cloudinary = new \Cloudinary\Cloudinary([
            'cloud' => [
                'cloud_name' => config('cloudinary.cloud_name'),
                'api_key' => config('cloudinary.api_key'),
                'api_secret' => config('cloudinary.api_secret'),
            ],
            'url' => [
                'secure' => true
            ]
        ]);

        // Upload file
        $uploadResult = $cloudinary->uploadApi()->upload(
            $request->file('image')->getRealPath(),
            [
                'folder' => 'products',
                'resource_type' => 'auto'
            ]
        );

        // Verify upload was successful
        if (!isset($uploadResult['secure_url'])) {
            throw new \Exception('Cloudinary upload failed');
        }

        Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'image_url' => $uploadResult['secure_url'],
            'image_public_id' => $uploadResult['public_id'],
        ]);

        return redirect()->route('products.index')
               ->with('success', 'Product created successfully');

    } catch (\Exception $e) {
        return back()->withInput()
               ->with('error', 'Error: ' . $e->getMessage());
    }}
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
   public function edit(Product $product)
    {
        return view('edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validateRequest = $request->validate([
            'name' => ['sometimes','required', 'max:255'],
            'image' => ['sometimes','required', 'image', 'max:2048'],
            'price' => ['sometimes','required', 'numeric'],
            'description' => ['sometimes','required'],
        ]);

        if($request->hasFile('image')){
            // Delete old image from Cloudinary
            Cloudinary::destroy($product->image_public_id);
            
            // Upload new image
            $uploadedFile = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'products'
            ]);

            $product->update([
                'image_url' => $uploadedFile->getSecurePath(),
                'image_public_id' => $uploadedFile->getPublicId(),
            ]);
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price
        ]);

        return redirect()->route('products.index')->with('message', 'Updated successfully');
    }
    //  * Remove the specified resource from storage.
    //  */
    public function destroy(Product $product)
    {
        Cloudinary::destroy($product->image_public_id);
        $product->delete();

        return redirect()->route('products.index')->with('message', 'Deleted Successfully');

    }
}