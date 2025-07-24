<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IllnessCategory;
use App\Models\IllnessCategoryDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IllnessCategoryDetailController extends Controller
{
    public function create(IllnessCategory $illnessCategory)
    {
        return view('admin.illness-categories.details.create', compact('illnessCategory'));
    }

    public function store(Request $request, IllnessCategory $illnessCategory)
    {
        $validated = $request->validate([
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'overview' => 'required',
            'symptoms' => 'required',
            'types' => 'required',
            'treatment' => 'required',
            'prevention' => 'required',
        ]);

        if ($request->hasFile('hero_image')) {
            $validated['hero_image'] = $request->file('hero_image')->store('illness-category-details', 'public');
        }

        $illnessCategory->detail()->create($validated);

        return redirect()->route('admin.illness-categories.index')
            ->with('success', 'Category details added successfully.');
    }

    public function edit(IllnessCategory $illnessCategory)
    {
        $detail = $illnessCategory->detail;
        return view('admin.illness-categories.details.edit', compact('illnessCategory', 'detail'));
    }

    public function update(Request $request, IllnessCategory $illnessCategory)
    {
        $validated = $request->validate([
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'overview' => 'required',
            'symptoms' => 'required',
            'types' => 'required',
            'treatment' => 'required',
            'prevention' => 'required',
        ]);

        if ($request->hasFile('hero_image')) {
            if ($illnessCategory->detail->hero_image) {
                Storage::disk('public')->delete($illnessCategory->detail->hero_image);
            }
            $validated['hero_image'] = $request->file('hero_image')->store('illness-category-details', 'public');
        }

        $illnessCategory->detail()->update($validated);

        return redirect()->route('admin.illness-categories.index')
            ->with('success', 'Category details updated successfully.');
    }
}