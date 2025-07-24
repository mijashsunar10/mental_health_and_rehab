<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IllnessCategory;
use Illuminate\Http\Request;

class IllnessCategoryController extends Controller
{
    public function index()
    {
        $categories = IllnessCategory::latest()->get();
        return view('admin.illness-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.illness-categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255|unique:illness_categories',
        ]);

        IllnessCategory::create($request->only('category_name'));

        return redirect()->route('admin.illness-categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(IllnessCategory $illnessCategory)
    {
        return view('admin.illness-categories.edit', compact('illnessCategory'));
    }

    public function update(Request $request, IllnessCategory $illnessCategory)
    {
        $request->validate([
            'category_name' => 'required|string|max:255|unique:illness_categories,category_name,'.$illnessCategory->id,
        ]);

        $illnessCategory->update($request->only('category_name'));

        return redirect()->route('admin.illness-categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(IllnessCategory $illnessCategory)
    {
        $illnessCategory->delete();

        return redirect()->route('admin.illness-categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    public function show(IllnessCategory $illnessCategory)
{
    return view('admin.illness-categories.show', compact('illnessCategory'));
}
}