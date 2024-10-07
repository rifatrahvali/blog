<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleCreateRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {

        return view('admin.articles.list', );
    }
    public function create()
    {
        $categories = Category::All();
        return view('admin.articles.create-update', compact('categories'));
    }

    public function store(ArticleCreateRequest $request)
    {

        // dosya ismini kullanarak görsel kayıt edeceğim.

        // Requestteki input'un adı
        $imageFile = $request->file('image');
        // requestteki file'ın adını alıyor
        $originalName = $imageFile->getClientOriginalName();
        // 
        $originalExtension = $imageFile->getClientOriginalExtension();

        // explode ile dosyaadi.png olan dosyayı . ile böldük. 0 olan kısım dosya adını temsil eder.
        $explodeName = explode(".",$originalName)[0]; 

        // slugLuAD.uzantı
        $fileName = Str::slug($explodeName) . "." . $originalExtension;

        // Görsel Yükleme
        // "görsel klasörü" 
        // hash
        // $imageFile->store("articles","public");
        // kendimiz isim verirsek
        $imageFile->storeAs("articles",$fileName,"public");
        
        // dd($fileName);
        // dd($request->all());

    }
}
