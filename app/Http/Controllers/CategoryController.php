<?php

namespace App\Http\Controllers;

use App\Concerns\HasToast;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CategoryController extends Controller
{
    use HasToast;

    public function index()
    {
        $categories = Category::dataTable()->getResponse();

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

        $this->toast('category added successfully');

        return to_route('categories.index');
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $this->authorizeCategory($category);

        $category->update($request->validated());

        $this->toast('category updated successfully');

        return to_route('categories.index');
    }

    public function destroy(Category $category)
    {
        $this->authorizeCategory($category);

        $category->delete();

        $this->toast('category deleted successfully');

        return to_route('categories.index');
    }

    private function authorizeCategory(Category $category)
    {
        abort_if($category->account_id !== Auth::user()->account->id, 403);
    }
}
