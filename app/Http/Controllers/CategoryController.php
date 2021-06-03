<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // Выводим все категории
    public function index()
    {
        $categories = DB::table('categories')->orderBy('sort_order', 'asc')->paginate(10);

        $title = "Категории";
        return view('backend.category.index', compact('title', 'categories'));
    }

    public function create(Request $request)
    {
    	// Log::info($request->name);
    	// Log::info($request->description);

        $this->validate($request, [
            'name' => 'required|max:60',
            'description' => 'required|max:500',
        ]);

        $category = new Category;
        $category->name = $request->name;
        $category->description = $request->description;
        if ($category->save())
            return true;

        return false;
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:60',
            'description' => 'required|max:500',
        ]);

        $category = Category::find($id);
        if ($category) {
            $category->name = $request->name;
            $category->description = $request->description;
            if ($category->save())
                return true;
        }
        return false;
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if ($category) {
            if ($category->delete())
                return true;
        }
    }

    public function on($id)
    {
        $category = Category::find($id);

        if ($category) {
            $category->on_off = 1;
            if ($category->save())
                return true;
        }
    }

    public function off($id)
    {
        $category = Category::find($id);

        if ($category) {
            $category->on_off = 0;
            if ($category->save())
                return true;
        }
    }
}
