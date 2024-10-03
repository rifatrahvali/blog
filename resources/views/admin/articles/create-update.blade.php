@extends("layouts.admin")

@section("title")
Makale {{ isset($article) ? "Güncelle" : "Ekle"}}
@endsection

@section("css")
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-lite.min.css') }}">

@endsection

@section("content")

<x-bootstrap.card>
    <x-slot:header>
        <h2 class="card-title">Makale {{ isset($article) ? "Güncelle" : "Ekle"}}</h2>
    </x-slot:header>
    <x-slot:body>
        <p class="card-description">Makalelerin türünü belirlediğimiz Makale alanıdır. * 'lı alanların doldurulması
            zorunludur. </p>
        <div class="example-container">
            <div class="example-content">
                <form
                    action="{{ isset($article) ? route('article.edit',['id' => $article->id]) : route('article.create') }}"
                    method="POST">
                    {{-- NAME ALANI --}}
                    @csrf
                    <input type="text" class="form-control form-control-solid-bordered m-b-sm"
                        aria-describedby="solidBoderedInputExample" placeholder="Makale Başlığı" name="title"
                        value="{{ isset($article) ? $article->title : "" }}" required>
                    @if ($errors->has('title'))
                    <div class="alert alert-danger alert-dismissible fade show m-b-sm" role="alert">
                        {{ $errors->first('title') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    {{-- SLUG ALANI --}}
                    <input type="text" class="form-control form-control-solid-bordered m-b-sm mb-3"
                        placeholder="Makale Slug - URL" name="slug" value="{{ isset($article) ? $article->slug : "" }}">

                    {{-- KATEGORİ ALANI --}}
                    <select class="js-states form-control mb-3 " name="category_id" id="selectCategory" tabindex="-1"
                        style="display: none; width: 100%;">
                        <option value="{{ null }}">Kategori Seçin</option>
                        @foreach ($categories as $item)
                        <option value="{{ $item->id }}" {{ isset($article) && $article->category_id == $item->id ?
                            "selected" : "" }}
                            >
                            {{ $item->name }}
                        </option>
                        @endforeach
                    </select>

                    {{-- BODY - İÇERİK ALANI --}}
                    {{-- <div id="summernote" class="form-control form-control-solid-bordered m-b-sm mt-3" name="body">Hello Summernote</div> --}}

                    <div class="card mt-3">
                        <div class="form-text mt-3">Makale İçeriği</div>
                        <div id="summernote" class="form-control form-control-solid-bordered m-b-sm" name="body">Hello Summernote</div>
                    </div>

                    {{-- ETİKET EKLEME ALANI --}}
                    <div class="form-text mt-3" id="tags">Herbir etiketi virgül ile ayırın.</div>
                    <input type="text" 
                        class="form-control form-control-solid-bordered m-b-sm"
                        placeholder="Makale için etiket belirt" 
                        name="tags" 
                        id="tags"
                        value="{{ isset($article) ? $article->tags : "" }}">
                    

                    {{-- SEO KELİME ALANI --}}
                    <div class="form-text mt-3" id="seo_keywords">SEO Kelimeleri</div>
                    <textarea class="form-control form-control-solid-bordered  m-b-sm" id="seo_keywords"
                        name="seo_keywords" rows="1" style="resize: none">{{ isset($article) ? $article->seo_keywords : "" }}
                    </textarea>

                    {{-- SEO KELİME AÇIKLAMALARI ALANI --}}
                    <div class="form-text mt-3" id="seo_description">SEO Açıklamaları</div>
                    <textarea class="form-control form-control-solid-bordered m-b-sm" id="seo_description"
                        name="seo_description" rows="1" style="resize: none">
                        {{ isset($article) ? $article->seo_description : "" }}
                    </textarea>

                    {{-- YAYINLANMA TARİHİ ALANI --}}
                    <input type="text" 
                        class="form-control flatpickr2 form-control-solid-bordered m-b-sm" 
                        id="publish_date" 
                        name="publish_date" 
                        placeholder="Makale Yayın Tarihini Seçin">

                    {{-- MAKALE GÖRSELİ ALANI --}}
                    <div class="form-text mt-3" id="image">Makaleniz için görsel ekleyin.</div>
                    <input type="file" class="form-control form-control-solid-bordered m-b-sm" name="image" id="image" accept="image/png, image/jpg, image/jpeg">

                    {{-- MAKALE DURUMU ALANI --}}
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="status" id="status" value="1" {{
                            isset($article) && $article->status ? "checked" : "" }}>
                        <label for="status" class="form-check-label">
                            Aktif - Makalenin sitede görünmesi için
                            tıklayınız.
                        </label>
                    </div>
                    <hr>
                    {{-- MAKALE EKLE / GÜNCELLE BUTONU --}}
                    <div class="col-6 mx-auto mt-3">
                        <button type="submit" class="btn btn-success btn-rounded w-100">Makale {{ isset($article) ?
                            "Güncelle" : "Ekle"}}</button>
                    </div>
                </form>
            </div>
        </div>
    </x-slot:body>
</x-bootstrap.card>

@endsection

@section("js")
<script src="{{ asset('assets/plugins/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/select2.js') }}"></script>
<script src="{{ asset('assets/js/pages/datepickers.js') }}"></script>
<script src="{{ asset('assets/js/pages/text-editor.js') }}"></script>
<script src="{{ asset('assets/plugins/summernote/summernote-lite.min.js') }}"></script>

<script>
    // Sayfa hazır olduğunda yapılacak işlemler
        $(document).ready(function(){

            $('#selectParentCategory').select2();

            $('#publish_date').flatpickr({
                enableTime:true,
                dateFormat:'Y-m-d H:i',
            });
        });
</script>
@endsection