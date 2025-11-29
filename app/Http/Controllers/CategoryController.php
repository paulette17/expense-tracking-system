<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('expenses')->paginate(15);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'monthly_limit' => 'nullable|numeric|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $category = Category::create($validated);

        AuditLog::logActivity(
            'created',
            $category,
            "Category '{$category->name}' created",
            null,
            $category->toArray()
        );

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'monthly_limit' => 'nullable|numeric|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $oldValues = $category->toArray();
        $category->update($validated);

        AuditLog::logActivity(
            'updated',
            $category,
            "Category '{$category->name}' updated",
            $oldValues,
            $category->fresh()->toArray()
        );

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        if ($category->expenses()->count() > 0) {
            return back()->with('error', 'Cannot delete category with existing expenses.');
        }

        $oldValues = $category->toArray();
        $category->delete();

        AuditLog::logActivity(
            'deleted',
            $category,
            "Category '{$category->name}' deleted",
            $oldValues,
            null
        );

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}