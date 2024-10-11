<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\TaxonomyDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TaxonomyCreateRequest;
use App\Http\Requests\Admin\TaxonomyUpdateRequest;
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
        return $dataTable->render('admin.taxonomy.index');
    }

    /**
     * Show the form for creating a new resource.
     */



    public function create(): View
    {
        $parentCategories = Taxonomy::where('parent', 0)->get();
        return view('admin.taxonomy.create', compact('parentCategories'));
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(TaxonomyCreateRequest $request): RedirectResponse
    {
        $taxonomy = new Taxonomy();
        $taxonomy->name = $request->name;
        $taxonomy->parent = $request->parent ?? 0;
        $taxonomy->slug = Str::slug($request->name);
        $taxonomy->show_at_home = $request->show_at_home;
        $taxonomy->status = $request->status;
        $taxonomy->save();

        toastr()->success('Created Successfully');

        return to_route('admin.taxonomy.index');
    }


    /**
     * Show the form for editing the specified resource.
     */

    public function edit(string $id): View
    {
        $taxonomy = Taxonomy::findOrFail($id);
        $parentCategories = Taxonomy::where('parent', 0)->get();

        return view('admin.taxonomy.edit', compact('taxonomy', 'parentCategories'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(TaxonomyUpdateRequest $request, string $id)
    {
        $taxonomy = Taxonomy::findOrFail($id);
        $taxonomy->name = $request->name;
        $taxonomy->parent = $request->parent ?? 0;
        $taxonomy->slug = Str::slug($request->name);
        $taxonomy->show_at_home = $request->show_at_home;
        $taxonomy->status = $request->status;
        $taxonomy->save();

        toastr()->success('Updated Successfully');

        return to_route('admin.taxonomy.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Taxonomy::findOrFail($id)->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
