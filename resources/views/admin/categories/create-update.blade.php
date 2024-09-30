@extends("layouts.admin")

@section("title")
Kategori {{ isset($category) ? "Güncelle" : "Ekle"}}
@endsection

@section("css")
@endsection

@section("content")

<x-bootstrap.card>
    <x-slot:header>
        <h2 class="card-title">Kategori {{ isset($category) ? "Güncelle" : "Ekle"}}</h2>
    </x-slot:header>
    <x-slot:body>
        <p class="card-description">Makalelerin türünü belirlediğimiz kategori alanıdır. * 'lı alanların doldurulması
            zorunludur. </p>
        <div class="example-container">
            <div class="example-content">
                {{-- Hata göstermeleri --}}
                {{-- @if ($errors->any())
                @foreach ($errors->all() as $error )
                <div class="alert alert-danger">
                    {{ $error }}
                </div>
                @endforeach
                @endif --}}
                <form action="{{ isset($category) ? route('categories.edit',['id' => $category->id]) : route('category.create') }}" method="POST">
                    @csrf
                    <input type="text" class="form-control form-control-solid-bordered m-b-sm"
                        aria-describedby="solidBoderedInputExample" placeholder="Kategori Adı" name="name"
                        value="{{ isset($category) ? $category->name : "" }}" required>
                    @if ($errors->has('name'))
                    <div class="alert alert-danger alert-dismissible fade show m-b-sm" role="alert">
                        {{ $errors->first('name') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <input type="text" class="form-control form-control-solid-bordered m-b-sm"
                        aria-describedby="solidBoderedInputExample" placeholder="Kategori Slug - URL" name="slug"
                        value="{{ isset($category) ? $category->slug : "" }}">

                    <textarea class="form-control form-control-solid-bordered m-b-sm"
                        aria-describedby="solidBoderedInputExample" placeholder="Kategori Açıklaması" id=""
                        name="description" cols="30" rows="3" style="resize: none">
                        {{ isset($category) ? $category->description : "" }}
                    </textarea>

                    <input type="number" class="form-control form-control-solid-bordered m-b-sm"
                        aria-describedby="solidBoderedInputExample" placeholder="Kategori Sıralaması / Order"
                        name="order" value="{{ isset($category) ? $category->order : "" }}">

                    <select name="parent_id" id="parent_id" class="form-control form-control-solid-bordered m-b-sm"
                        aria-label="Üst Kategori Seçimi">
                        @foreach ($categories as $item)
                        <option value="{{ $item->id }}" {{ isset($category) && $category->id == $item->id ? "selected" :
                            "" }}>
                            {{ $item->name }}
                        </option>
                        @endforeach
                    </select>

                    <textarea class="form-control form-control-solid-bordered m-b-sm"
                        aria-describedby="solidBoderedInputExample" placeholder="SEO Kelimeleri" id="seo_keywords"
                        name="seo_keywords" cols="30" rows="2" style="resize: none">
                        {{ isset($category) ? $category->seo_keywords : "" }}
                    </textarea>
                    <textarea class="form-control form-control-solid-bordered m-b-sm"
                        aria-describedby="solidBoderedInputExample" placeholder="SEO Açıklamaları" id="seo_description"
                        name="seo_description" cols="30" rows="2" style="resize: none">
                        {{ isset($category) ? $category->seo_description : "" }}
                    </textarea>


                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="status" id="status" value="1" {{
                            isset($category) && $category->status ? "checked" : "" }}>
                        <label for="status" class="form-check-label">
                            Aktif - Kategorinin sitede görünmesi için
                            tıklayınız.
                        </label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="feature_status" id="feature_status"
                            value="1" {{ isset($category) && $category->feature_status ? "checked" : "" }} >
                        <label for="feature_status" class="form-check-label">Öne Çıkar - Kategorinin sitede öne
                            çıkarılması için tıklayınız.</label>
                    </div>
                    <hr>
                    <div class="col-6 mx-auto mt-3">
                        <button type="submit" class="btn btn-success btn-rounded w-100">Kategori {{ isset($category) ? "Güncelle" : "Ekle"}}</button>
                    </div>
                </form>
            </div>
        </div>
    </x-slot:body>
</x-bootstrap.card>

@endsection

@section("js")

@endsection