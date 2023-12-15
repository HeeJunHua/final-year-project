<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class InventoryController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        
        /** @var \App\Models\User $user **/
        $user = Auth::user();
        // Get the product catalog for dropdown
        // Check if the user has an associated inventory
        if ($user->inventory) {
            // Retrieve the user's inventory and associated products
            $products = $user->inventory->products;
        } else {
            // If no inventory is found, create one for the user
            $inventory = Inventory::create(['user_id' => $user->id]);

            // Retrieve the products associated with the newly created inventory
            $products = $inventory->products;
        }

        return view('inventory_page', compact('user', 'products'));
    }

    public function create()
    {
        return view('inventory_creation_page');
    }

    public function store(Request $request)
    {
        // Validation rules
        $rules = [
            'product_name' => 'required|string|max:255',
            'product_category' => 'required|string|in:vegetables,fruits,grains,proteins,dairy,snacks,beverages,canned_goods,dry_goods,frozen_foods,baked_goods,sweets',
                        'quantity' => 'required|integer|min:1',
            'description' => 'required|string|max:500',
            'expiry_date' => 'required|date',
        ];
    
        // Custom error messages
        $messages = [
            'product_name.required' => 'The product name is required.',
            'product_category.required' => 'Please select a valid category.',
                        'quantity.required' => 'The quantity is required.',
            'quantity.integer' => 'The quantity must be a whole number.',
            'quantity.min' => 'The quantity must be at least :min.',
            'description.required' => 'The description is required.',
            'expiry_date.required' => 'The expiry date is required.',
            'expiry_date.date' => 'Invalid expiry date format.',
        ];
    
        // Validate the request data
        $request->validate($rules, $messages);
    
        // Check the expiry date and set product status
        $expiryDate = Carbon::parse($request->input('expiry_date'));
        $today = now();
    
        $productStatus = $expiryDate->isPast() ? 'expired' : ($expiryDate->isSameDay($today) ? 'expiring_today' : 'good');
    
        
        /** @var \App\Models\User $user **/
        $user = Auth::user();
        // If the validation passes, create the product and associate it with the user's inventory
        $product = Product::create([
            'product_name' => $request->input('product_name'),
'inventory_id' => $user->inventory->id,
            'product_category' => $request->input('product_category'),
                        'product_quantity' => $request->input('quantity'),
            'product_description' => $request->input('description'),
            'product_expiry_date' => $request->input('expiry_date'),
            'product_status' => $productStatus,
        ]);

        // Associate the product with the user's inventory
        $user->inventory->products()->save($product);
    
        // Redirect with success message
        return redirect()->route('inventory.index')->with('success', 'Product created successfully.');
    }
    

    public function edit($id)
    {
        // Find the product by its ID
        $product = Product::findOrFail($id);

        return view('inventory_edit_page', compact('product'));
    }

    public function update(Request $request, $id)
    {
        // Validation rules
        $rules = [
            'product_name' => 'required|string|max:255',
            'product_category' => 'required|string|in:vegetables,fruits,grains,proteins,dairy,snacks,beverages,canned_goods,dry_goods,frozen_foods,baked_goods,sweets',
            'quantity' => 'required|integer|min:1',
            'description' => 'required|string|max:500',
            'expiry_date' => 'required|date',
        ];

        // Custom error messages
        $messages = [
            'product_name.required' => 'The product name is required.',
            'product_category.required' => 'Please select a valid category.',
            'quantity.required' => 'The quantity is required.',
            'quantity.integer' => 'The quantity must be a whole number.',
            'quantity.min' => 'The quantity must be at least :min.',
            'description.required' => 'The description is required.',
            'expiry_date.required' => 'The expiry date is required.',
            'expiry_date.date' => 'Invalid expiry date format.',
        ];

        // Validate the request data
        $request->validate($rules, $messages);

        // Find the product by its ID
        $product = Product::findOrFail($id);

        // Update the product attributes
        $product->update([
            'product_name' => $request->input('product_name'),
            'product_category' => $request->input('product_category'),
            'product_quantity' => $request->input('quantity'),
            'product_description' => $request->input('description'),
            'product_expiry_date' => $request->input('expiry_date'),
        ]);

        // Add any additional logic needed after the update

        // Redirect with success message
        return redirect()->route('inventory.index')->with('success', 'Product updated successfully.');
    }



    public function destroy(Product $product)
    {
        try {
            $product->delete();
        } catch (QueryException $exception) {
            return redirect()->back()->with('error', 'Delete fail. There is data link with this record.');
        }

        return redirect()->route('inventory.index')->with('success', 'Inventory item deleted successfully.');
    }
}
