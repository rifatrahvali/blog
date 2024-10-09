<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleCreateRequest;
use App\Http\Requests\ArticleFilterRequest;
use App\Http\Requests\ArticleUpdateRequest;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Models\User;


class ArticleController extends Controller
{
    public function index(ArticleFilterRequest $request)
    {
        // dd($request->all());

        $users = User::all();

        $categories = Category::all();

        $list = Article::query()
                        ->with([
                            'category',
                            'user'
                        ])
                        ->where(function($query) use ($request){
                            $query->orWhere('title','LIKE','%'.$request->search_text)
                                ->orWhere('slug','LIKE','%'.$request->search_text)
                                ->orWhere('body','LIKE','%'.$request->search_text)
                                ->orWhere('tags','LIKE','%'.$request->search_text);
                        })
                        ->status($request->status)
                        ->category($request->category_id)
                        ->user($request->user_id)
                        ->publishDate($request->publish_date)
                        ->paginate(10);

        return view('admin.articles.list', compact('users','categories','list'));
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
        $data['image'] = $publicPath . '/' . $fileName;
        $data['user_id'] = auth()->id();

        Article::create($data);
        $imageFile->storeAs($folder, $fileName, "public");
        toast("Makale Kaydedildi", 'success')->autoClose(3000);
        return redirect()->back();
    }


    public function edit(Request $request, int $articleID)
    {

        $categories = Category::all();
        $users = User::all();

        $article = Article::query()
            ->where("id", $articleID)
            ->first();
        if (is_null($article)) {
            toast('Makale Bulunamadı.', 'warning')->autoClose(3000);
            return redirect()->route('article.index');
        }
        return view('admin.articles.create-update', compact('article', 'categories', 'users'));

    }

    public function update(ArticleUpdateRequest $request, int $articleID)
    {

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

        // Requestten gelen image inputunun içerisinde görsel var ise
        if (!is_null($request->image)) {
            $imageFile = $request->file('image');
            $originalName = $imageFile->getClientOriginalName();
            $originalExtension = $imageFile->getClientOriginalExtension();
            $explodeName = explode(".", $originalName)[0];
            $fileName = Str::slug($explodeName) . "." . $originalExtension;
            $folder = "articles";
            $publicPath = "storage/" . $folder;

            // daha önce aynı isimli görsel yüklendi ise
            if (file_exists(public_path($publicPath . $fileName))) {
                return redirect()->back()->withErrors([
                    'image' => 'Görsel daha önce yüklenmiştir. (ismi aynı)',
                ]);
            }

            $data['image'] = $publicPath . '/' . $fileName;
        }

        $data['user_id'] = auth()->id();


        // Makaleyi Güncelle
        $articleQuery = Article::query()->where('id',$request->id);
        $articleFind = $articleQuery->first();
        
        $articleQuery->update($data);
       

        if (!is_null($request->image)) {

            if(file_exists(public_path($articleFind->image))){
                File::delete(public_path($articleFind->image));
            }

            // eski görselin silinmesini sağlar.
            // Storage::delete(public_path($articleFind->image));
            $imageFile->storeAs($folder, $fileName);
        }
        toast("Makale Kaydedildi", 'success')->autoClose(3000);
        return redirect()->route('article.index');
        

    }


    // slug check
    public function slugCheck(string $text)
    {
        return Article::where('slug', $text)->first();
    }


}
