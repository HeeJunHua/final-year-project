<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //check admin
    private function isAdmin()
    {
        if (auth()->user()->user_role != "admin") {
            return redirect()->route('user.dashboard')->with('error', 'No Permission');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //check if is admin
        $this->isAdmin();

        // per page
        $perPage = 10;

        // start a query
        $query = Category::query();

        // Search category name
        if ($request->has('search')) {
            $query->where('category_name', 'like', '%' . $request->input('search') . '%');
        }

        // paginate
        $records = $query->paginate($perPage);

        // return view with data
        return view('category/index', ['records' => $records]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //check if is admin
        $this->isAdmin();

        return View::make('category.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //check if is admin
        $this->isAdmin();

        //validate data
        try {
            //custom message
            $customErrorMessages = [
                'required' => 'The :attribute field is required.',
                'min' => 'The :attribute must have at least :min characters.',
                'max_length' => 'The :attribute must not exceed :max characters.',
                'email' => 'The :attribute must be a valid email address.',
                'unique' => 'The :attribute is already in use.',
                'confirmed' => 'The :attribute confirmation does not match.',
                'in' => 'Invalid :attribute value.',
                'image' => 'The :attribute must be an image file.',
                'mimes' => 'The :attribute must be a JPEG or PNG image.',
                'max_size' => 'The :attribute must not be larger than :max kilobytes.',
                'regex' => 'Invalid contact number format. It should match the pattern +1234567890.',
                'numeric' => 'The :attribute must be a number.',
            ];

            //validate
            $request->validate([
                'category_name' => 'required|string|max:255',
                'image_path' => 'image|mimes:jpeg,jpg,png|max:2048',
            ],$customErrorMessages);
        } catch (ValidationException $exception) {
            //if validate error, return json, http error 422 code
            return response()->json(['errors' => $exception->errors()], 422);
        }

        // new record
        $record = new Category();

        if ($request->hasFile('image_path')) {
            $picture = $request->file('image_path');
            $extension = $picture->getClientOriginalExtension();
        
            // Generate a unique filename for the image, e.g., user_id_timestamp.jpg
            $fileName = auth()->id() . '_' . time() . '.' . $extension;
        
            // Store the file in the public storage and use the generated filename
            $picture->storeAs('public/categories', $fileName);
        
            // Update the picture with the generated filename
            $record->image_path = $fileName;
        }

        //update field
        $record->category_name = $request->input('category_name');

        //save
        $record->save();

        //return url for js to redirect, redirect to global function = user.redirect
        return response()->json(['route' => route('user.redirect',['route'=>'category.index','status'=>'success','message'=>'Category created successfully'])], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //check if is admin
        $this->isAdmin();

        //get record
        $record = Category::find($id);

        return View::make('category.view', compact('record'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //check if is admin
        $this->isAdmin();

        //get record
        $record = Category::find($id);

        return View::make('category.edit', compact('record'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //check if is admin
        $this->isAdmin();

        //validate data
        try {
            //custom message
            $customErrorMessages = [
                'required' => 'The :attribute field is required.',
                'min' => 'The :attribute must have at least :min characters.',
                'max_length' => 'The :attribute must not exceed :max characters.',
                'email' => 'The :attribute must be a valid email address.',
                'unique' => 'The :attribute is already in use.',
                'confirmed' => 'The :attribute confirmation does not match.',
                'in' => 'Invalid :attribute value.',
                'image' => 'The :attribute must be an image file.',
                'mimes' => 'The :attribute must be a JPEG or PNG image.',
                'max_size' => 'The :attribute must not be larger than :max kilobytes.',
                'regex' => 'Invalid contact number format. It should match the pattern +1234567890.',
                'numeric' => 'The :attribute must be a number.',
            ];

            //validate
            $request->validate([
                'category_name' => 'required|string|max:255',
                'image_path' => 'image|mimes:jpeg,jpg,png|max:2048',
            ],$customErrorMessages);
        } catch (ValidationException $exception) {
            //if validate error, return json, http error 422 code
            return response()->json(['errors' => $exception->errors()], 422);
        }

        // Find the record
        $record = Category::find($id);

        if ($request->hasFile('image_path')) {
            $picture = $request->file('image_path');
            $extension = $picture->getClientOriginalExtension();
        
            // Generate a unique filename for the image, e.g., user_id_timestamp.jpg
            $fileName = auth()->id() . '_' . time() . '.' . $extension;
        
            // Store the file in the public storage and use the generated filename
            $picture->storeAs('public/categories', $fileName);
        
            // Update the picture with the generated filename
            $record->image_path = $fileName;
        }

        //update field
        $record->category_name = $request->input('category_name');

        //save
        $record->save();

        //return url for js to redirect, redirect to global function = user.redirect
        return response()->json(['route' => route('user.redirect',['route'=>'category.index','status'=>'success','message'=>'Category updated successfully'])], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //check if is admin
        $this->isAdmin();
        
        // delete
        try {
            $category->delete();
        } catch (QueryException $exception) {
            return redirect()->back()->with('error', 'Delete fail. There is data link with this record.');
        }

        return redirect()->route('category.index')->with('success', 'Category deleted successfully.');
    }
}
