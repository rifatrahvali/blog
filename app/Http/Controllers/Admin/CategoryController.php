<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {

        // tüm kagetorileri ve kullanıcıları getir
        $parentCategories = Category::All();
        $users = User::All();


        // 'veya' kullanarak filtreleme yapacağız
        $categories = Category::with(["parentCategory:id,name", "user"])
            ->name($request->name) //scopeName - where
            ->description($request->description) //scopeDescription - orWhere
            ->slug($request->slug) //scopeSlug - orWhere
            ->order($request->order) //scopeOrder - orWhere
            ->status($request->status) //scopeStatus - orWhere
            ->featureStatus($request->feature_status) //scopeStatus - orWhere
            ->orderBy("order", "desc")
            ->paginate(perPage: 5)
            ->onEachSide(0);
            //->get();

        return view('admin.categories.list', [
            'list' => $categories,
            'users' => $users,
            'parentCategories'=>$parentCategories
        ]);
    }
    public function create()
    {
        $categories = Category::all();
        return view('admin.categories.create-update',compact('categories'));
    }

    public function store(CategoryStoreRequest $request)
    {
        $slugCheck = Category::where("slug",$request->slug)->first();

        try{
            $category = new Category();
            $category->name = $request->name;
            $category->slug = is_null($slugCheck) ? Str::slug($request->slug) : Str::slug($request->slug.time()) ;
            $category->description = $request->description;
            $category->status = $request->status ? 1 : 0;
            $category->feature_status = $request->feature_status ? 1 : 0;
            $category->parent_id = $request->parent_id;
            $category->seo_keywords = $request->seo_keywords;
            $category->seo_description = $request->seo_description;
            $category->user_id = random_int(1,9);
            $category->order = $request->order;
            $category->save();
    
        }catch(\Exception $exception){
            abort(404,$exception->getMessage());
        }

        toast("Kategori Eklendi.", 'success')->autoClose(3000);
        return redirect()->back();

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

        $categories = Category::all();

        $categoryID = $request->id;
        $category = Category::where("id", $categoryID)->first();
        if (is_null($category)) {
            toast('Kategori Bulunamadı.', 'warning')->autoClose(3000);
            return redirect()->route('category.index');

        }
        return view('admin.categories.create-update', compact('category','categories'));
    }

    public function update(CategoryStoreRequest $request){
        
        $slug = Str::slug($request->slug);
        $slugCheck = Category::where("slug",$request->slug)->first();

        $category = Category::find($request->id);
        $category->name = $request->name;
        if((!is_null($slugCheck) && $slugCheck->id == $category->id)|| is_null($slugCheck)){
            $category->slug = $slug;
        }else if(!is_null($slugCheck) && $slugCheck->id != $category->id){
            $category->slug = Str::slug($slug.time());
        }
        else{
            $category->slug = Str::slug($slug.time());
        }
        $category->description = $request->description;
        $category->status = $request->status ? 1 : 0;
        $category->feature_status = $request->feature_status ? 1 : 0;
        $category->parent_id = $request->parent_id;
        $category->seo_keywords = $request->seo_keywords;
        $category->seo_description = $request->seo_description;
        //$category->user_id = random_int(1,9);
        $category->order = $request->order;
        $category->save();

        toast("Kategori Güncellendi.", 'success')->autoClose(3000);
        return redirect()->route('category.index');

    }
}


