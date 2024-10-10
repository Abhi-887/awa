<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\TaxonomyDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryUpdateRequest;
use App\Http\Requests\Admin\TaxonomyCreateRequest;
use App\Models\Taxonomy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Str;

class TaxonomyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TaxonomyDataTable $dataTable)
    {
        return $dataTable->render('admin.product.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */



public function create(): View
{
    $parentCategories = Taxonomy::where('parent', 0)->get();
    return view('admin.product.category.create', compact('parentCategories'));
}




    /**
     * Store a newly created resource in storage.
     */
    public function store(TaxonomyCreateRequest $request) : RedirectResponse
    {
        $category = new Taxonomy();
        $category->name = $request->name;
	        $category->parent = $request->parent ?? 0;
		$category->slug = Str::slug($request->name);
        $category->show_at_home = $request->show_at_home;
        $category->status = $request->status;
        $category->save();

        toastr()->success('Created Successfully');

        return to_route('admin.category.index');

    }


    /**
     * Show the form for editing the specified resource.
     */

	public function edit(string $id): View
{
    $category = Taxonomy::findOrFail($id);
    $parentCategories = Taxonomy::where('parent', 0)->get();

    return view('admin.product.category.edit', compact('category', 'parentCategories'));
}



    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, string $id)
    {
        $category = Taxonomy::findOrFail($id);
        $category->name = $request->name;
        $category->parent = $request->parent ?? 0;
        $category->slug = Str::slug($request->name);
        $category->show_at_home = $request->show_at_home;
        $category->status = $request->status;
        $category->save();

        toastr()->success('Updated Successfully');

        return to_route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            Taxonomy::findOrFail($id)->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        }catch(\Exception $e){
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
