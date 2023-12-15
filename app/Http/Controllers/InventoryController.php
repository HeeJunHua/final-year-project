<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\FoodItems;

class InventoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = auth()->user();

        // Get the product catalog for dropdown
        // Check if the user has an associated inventory
        if ($user->inventory) {
            // Retrieve the user's inventory and associated products
            $query = $user->inventory->products();
        } else {
            // If no inventory is found, create one for the user
            $inventory = Inventory::create(['user_id' => $user->id]);

            // Retrieve the products associated with the newly created inventory
            $query = $inventory->products();
        }

        // Handle search
        if ($request->has('search')) {
            $query->where('product_name', 'like', '%' . $request->input('search') . '%');
        }

        // Handle filter
        if ($request->has('filterBy')) {
            switch ($request->input('filterBy')) {
                case 'expired':
                    $query->whereDate('product_expiry_date', '<', now());
                    break;
                case 'expiring_today':
                    $query->whereDate('product_expiry_date', '=', now());
                    break;
                case 'good':
                    $query->whereDate('product_expiry_date', '>', now());
                    break;
                // Add more cases for other filter options
            }
        }

        if ($request->has('sortBy')) {
            switch ($request->input('sortBy')) {
                case 'product_name':
                    $query->orderBy('product_name');
                    break;
                case 'product_expiry_date':
                    $query->orderBy('product_expiry_date');
                    break;
                case 'product_status':
                    $query->orderBy('product_status');
                    break;
                case 'product_category':
                    $query->orderBy('product_category');
                    break;
                case 'product_quantity':
                    $query->orderBy('product_quantity');
                    break;
                case 'product_description':
                    $query->orderBy('product_description');
                    break;
                // Add more cases for other filter options
            }
        }
        

        $products = $query->get();

        return view('inventory/inventory_page', compact('user', 'products'));
    }
    
    public function create()
    {
        return view('inventory/inventory_creation_page');
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

        $expiryDate = Carbon::createFromFormat('Y-m-d', $request->input('expiry_date'));
        $today = Carbon::today();
        
        // Calculate 7 days from today
        $sevenDaysLater = $today->copy()->addDays(8);
        
        // Check if the expiry date is within the next 7 days
        $isWithinSevenDays = $expiryDate->isBetween($today, $sevenDaysLater);
        
        // Determine the status based on the calculated condition
        $productStatus = $expiryDate->isPast() ? 'expired' : ($isWithinSevenDays ? 'near_expiring' : 'good');
        

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

        return view('inventory/inventory_edit_page', compact('product'));
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


        $expiryDate = Carbon::createFromFormat('Y-m-d', $request->input('expiry_date'));
        $today = Carbon::today();
        
        // Calculate 7 days from today
        $sevenDaysLater = $today->copy()->addDays(8);
        
        // Check if the expiry date is within the next 7 days
        $isWithinSevenDays = $expiryDate->isBetween($today, $sevenDaysLater);
        
        // Determine the status based on the calculated condition
        $productStatus = $expiryDate->isPast() ? 'expired' : ($isWithinSevenDays ? 'near_expiring' : 'good');
        

        // Update the product attributes
        $product->update([
            'product_name' => $request->input('product_name'),
            'product_category' => $request->input('product_category'),
            'product_quantity' => $request->input('quantity'),
            'product_description' => $request->input('description'),
            'product_expiry_date' => $request->input('expiry_date'),
            'product_status' => $productStatus,
        ]);

        

        // Redirect with success message
        return redirect()->route('inventory.index')->with('success', 'Product updated successfully.');
    }



    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('inventory.index')->with('success', 'Inventory item deleted successfully.');
    }


    public function donate(Product $product)
    {
        // Check if the product is eligible for donation (near_expiry or good)
        if ($product->product_status == 'near_expiry' || $product->product_status == 'good') {
            // Create a new FoodItem based on the product details
            $foodItem = new FoodItems([
                'user_id' => $product->inventory->user->id,
                'food_item_name' => $product->product_name,
                'food_item_category' => $product->product_category,
                'food_item_quantity' => $product->product_quantity,
                'food_item_expiry_date' => $product->product_expiry_date,
                'has_expiry_date' => true,
            ]);
    
            // Save the FoodItem
            $foodItem->save();
    
            // Mark the product as donated or perform any other necessary action
            $product->update(['product_status' => 'donated']);
    
            // Optionally, you can redirect the user or perform other actions
            return redirect()->back()->with('success', 'Product donated successfully!');
        } else {
            // Product is not eligible for donation, handle accordingly
            return redirect()->back()->with('error', 'Product is not eligible for donation.');
        }
    }
}
