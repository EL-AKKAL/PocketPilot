<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        $account = Auth::user()->account;

        $categories = $account
            ->categories()
            ->select(['id', 'value', 'description', 'type'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('categories/List', [
            'categories' => $categories,
        ]);
    }

    public function store(CategoryRequest $request)
    {
        Auth::user()
            ->account
            ->categories()
            ->create($request->validated());

        $this->success('category added successfully');

        return to_route('categories.index');
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $this->authorizeCategory($category);

        $category->update($request->validated());

        $this->success('category updated successfully');

        return to_route('categories.index');
    }

    public function destroy(Category $category)
    {
        $this->authorizeCategory($category);

        $category->delete();

        $this->success('category deleted successfully');

        return to_route('categories.index');
    }

    private function authorizeCategory(Category $category)
    {
        abort_if($category->account_id !== Auth::user()->account->id, 403);
    }

    private function success(string $message)
    {
        Inertia::flash('toast', [
            'type' => 'success',
            'message' => $message,
        ]);
    }
}
