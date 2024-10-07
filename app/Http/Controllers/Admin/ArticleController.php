<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleCreateRequest;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


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
        $explodeName = explode(".", $originalName)[0];

        // slugLuAD.uzantı
        $fileName = Str::slug($explodeName) . "." . $originalExtension;

        $folder = "articles";
        $publicPath = "storage/" . $folder;

        // Görsel Yükleme
        // "görsel klasörü" 
        // hash
        // $imageFile->store("articles","public");
        // kendimiz isim verirsek

        // public->storage->articles/ dosya varmı yok mu ?
        // dd(public_path("storage/articles".$fileName));
        if (file_exists(public_path($publicPath . $fileName))) {
            return redirect()->back()->withErrors([
                'image' => 'Görsel daha önce yüklenmiştir. (ismi aynı)',
            ]);
        }

        // Tokeni haric tut
        $data = $request->except('_token');

        // slug kontrol
        $slug = $data['slug'] ?? $data['title'];
        $slug = Str::slug($slug);

        $slugTitle = Str::slug($data['title']);

        $checkSlug = $this->slugCheck($slug);

        // slug kullanılıyorsa - title slug kontrol et
        if (!is_null($checkSlug)) {
            $checkTitleSlug = $this->slugCheck($slugTitle);

            // title slug dolu ise yani kullanılıyorsa
            if (!is_null($checkTitleSlug)) {
                $slug = Str::slug($slug . time());
            } else {
                // kullanılmıyorsa sluga ata
                $slug = $slugTitle;
            }
        }

        $data['slug'] = $slug;
        $data['image'] = $publicPath .'/'. $fileName;
        $data['user_id'] = auth()->id();

        Article::create($data);
        $imageFile->storeAs($folder, $fileName, "public");
        toast("Makale Kaydedildi", 'success')->autoClose(3000);
        return redirect()->back();
    }

    // slug check
    public function slugCheck(string $text)
    {
        return Article::where('slug', $text)->first();
    }
}
