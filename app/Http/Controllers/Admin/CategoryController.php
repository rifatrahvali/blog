<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with(["parentCategory:id,name", "user"])->orderBy("order", "desc")->get();

        return view('admin.categories.list', ['list' => $categories]);
    }
    public function create()
    {
        return view('admin.categories.create-update');
    }
    public function changeStatus(Request $request)
    {

        $request->validate([
            'id' => ['required', 'integer', "exists:categories"],
        ]);
        $categoryID = $request->id;

        $category = Category::where("id", $categoryID)->first();

        $category->status = !$category->status;
        $category->save();

        // alert()
        //     ->success('Güncelleme Başarılı', $category->name . "durumu güncellendi.")
        //     ->autoClose(5000)
        //     ->showConfirmButton("tamam","#3085d6");

        $toastTitle = $category->name . "durumu güncellendi.";
        toast($toastTitle, 'success')->autoClose(3000);

        return redirect()->route("category.index");
    }
    public function changeFeatureStatus(Request $request)
    {

        $request->validate([
            'id' => ['required', 'integer', "exists:categories"],
        ]);
        $categoryID = $request->id;
        $category = Category::where("id", $categoryID)->first();

        $category->feature_status = !$category->feature_status;
        $category->save();

        // alert()
        //     ->success('Güncelleme Başarılı', $category->name . "durumu güncellendi.")
        //     ->autoClose(5000)
        //     ->showConfirmButton("tamam","#3085d6");

        $toastTitle = $category->name . "feature status güncellendi.";
        toast($toastTitle, 'success')->autoClose(3000);

        return redirect()->route("category.index");
    }

    public function delete(Request $request)
    {

        $request->validate([
            'id' => ['required', 'integer', "exists:categories"],
        ]);
        $categoryID = $request->id;
        Category::where("id", $categoryID)->delete();

        toast('Kategori Silindi', 'success')->autoClose(3000);

        return redirect()->route("category.index");
    }

    public function edit(Request $request)
    {

        $categoryID = $request->id;
        $category = Category::where("id", $categoryID)->first();
        if (is_null($category)) {
            toast('Kategori Bulunamadı.', 'warning')->autoClose(3000);
            return redirect()->route('category.index');

        }
        return view('admin.categories.create-update', compact('category'));
    }
}


