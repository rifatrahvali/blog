@extends("layouts.admin")

@section("title")
Makale Listele Sayfası
@endsection

@section("css")
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
@endsection

@section("content")

<x-bootstrap.card>
    <x-slot:header>
        Makale Liste
    </x-slot:header>
    <x-slot:body>

        <form action="">
            <div class="">
                <div class="row">
                    <div class="col-3">
                        <input type="text" name="name" id="name" class="form-control" placeholder="Adı"
                            value="{{ request()->get('name') }}">
                    </div>
                    <div class="col-3">
                        <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug"
                            value="{{ request()->get('slug') }}">
                    </div>
                    <div class="col-3">
                        <input type="text" name="description" id="description" class="form-control"
                            placeholder="Açıklama" value="{{ request()->get('description') }}">
                    </div>
                    <div class="col-3">
                        <input type="text" name="order" id="order" class="form-control" placeholder="Sıralaması"
                            value="{{ request()->get('order') }}">
                    </div>
                    <div class="col-3 mt-2">
                        <select class="js-states form-control" name="parent_id" id="selectParentCategory" tabindex="-1"
                            style="display: none; width: 100%">
                            <option value="{{ null }}">Üst Kategori</option>
                            @foreach ($parentCategories as $parent )
                            <option value="{{ $parent->id }}" {{ request()->get('parent_id') == $parent->id ? "selected"
                                : "" }}>
                                {{ $parent->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3 mt-2">
                        <select name="user_id" id="user_id" class="form-select">
                            <option value="{{ null }}">Kullanıcılar</option>
                            @foreach ($users as $user )
                            <option value="{{ $user->id }}" {{ request()->get('user_id') == $user->id ? "selected" : ""
                                }}>
                                {{ $user->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3 mt-2">
                        <select name="status" id="status" class="form-select" aria-label="Durumu">
                            <option value="{{ null }}">Durumu</option>
                            <option value="1" {{ request()->get('status') === "1" ? "selected" : "" }}>Aktif</option>
                            <option value="0" {{ request()->get('status') === "0" ? "selected" : "" }}>Pasif</option>
                        </select>
                    </div>
                    <div class="col-3 mt-2">
                        <select name="feature_status" id="feature_status" class="form-select" aria-label="Durumu">
                            <option value="{{ null }}">Öne Çıkanlar</option>
                            <option value="1" {{ request()->get('feature_status') === "1" ? "selected" : "" }}>Aktif
                            </option>
                            <option value="0" {{ request()->get('feature_status') === "0" ? "selected" : "" }}>Pasif
                            </option>
                        </select>
                    </div>
                </div>
                <div class="row m-1">
                    <hr class="mt-2">
                    <div class="mb-3 d-flex">
                        <button class="btn btn-primary w-100 me-4" type="submit">Filtrele</button>
                        <button class="btn btn-warning w-100" type="submit">Temizle</button>
                    </div>
                    <hr>
                </div>
            </div>
        </form>

        <x-bootstrap.table :class="'table-striped table-hover'" :is-responsive="1">
            <x-slot:columns>
                <th scope="col">Name</th>
                <th scope="col">Slug</th>
                <th scope="col">Status</th>
                <th scope="col">Feature Status</th>
                <th scope="col">Description</th>
                <th scope="col">Order</th>
                <th scope="col">Parent Category</th>
                <th scope="col">Owner User</th>
                <th scope="col">Actions</th>
            </x-slot:columns>

            <x-slot:rows>
                @foreach ($list as $category)
                {{-- gelen list değişkenindeki verileri category category dön --}}
                <tr>
                    <td>{{ $category->name}}</td>
                    <td>{{ $category->slug}}</td>
                    <td>
                        @if ($category->status)
                        <a href="javascript:void(0)" data-id="{{ $category->id }}"
                            class="btn btn-success btn-sm btnChangeStatus">Aktif</a>
                        @else
                        <a href="javascript:void(0)" data-id="{{ $category->id }}"
                            class="btn btn-warning btn-sm btnChangeStatus">Pasif</a>
                        @endif
                    </td>
                    <td>
                        @if ($category->feature_status)
                        <a href="javascript:void(0)" data-id="{{ $category->id }}"
                            class="btn btn-success btn-sm btnChangeFeatureStatus">Aktif</a>
                        @else
                        <a href="javascript:void(0)" data-id="{{ $category->id }}"
                            class="btn btn-warning btn-sm btnChangeFeatureStatus">Pasif</a>
                        @endif
                    </td>
                    <td title="{{ $category->description }}">{{ substr($category->description,0,20) }}</td>
                    <td>{{ $category->order}}</td>
                    <td>{{ $category->parentCategory?->name}}</td>
                    <td>{{ $category->user->name}}</td>
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('categories.edit',['id'=>$category->id]) }}"
                                class="btn btn-warning btn-sm"><i class="material-icons ms-0">edit</i></a>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm btnDeleteCategory"
                                data-name="{{ $category->name}}" data-id="{{ $category->id }}">
                                <i class="material-icons ms-0">delete</i></a>
                        </div>
                    </td>
                </tr>
                @endforeach

            </x-slot:rows>
        </x-bootstrap.table>
        <div class="d-flex justify-content-center">

            {{-- {{ $list->onEachSide(0)->links() }} --}}
            {{-- filtreleme yapıldığında pagination sayfalar arasında geçiş yaparken filtre gitmemesi için append kullanıyoruz --}}
            {{ $list->appends(request()->all())->onEachSide(0)->links() }}
        </div>
    </x-slot:body>
</x-bootstrap.card>


<form action="" method="POST" id="statusChangeForm">
    @csrf
    <input type="hidden" name="id" value="" id="inputStatus">
</form>
@endsection

@section("js")
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/select2.js') }}"></script>
<script>
    // Sayfa hazır olduğunda yapılacak işlemler
        $(document).ready(function(){
            // btnChangeStatus tıklandığında
            $('.btnChangeStatus').click(function(){
                // idleri al
                let categoryID = $(this).data('id');
                $('#inputStatus').val(categoryID);

                Swal.fire({
                title: "Bilgi",
                text:"Kategori Durumunu Değirtirmek İstiyor Musunuz ?",
                icon:"info",
                showDenyButton: true,
                // showCancelButton: true,
                confirmButtonText: "Değiştir",
                denyButtonText: `Değiştirme`,
                // cancelButtonText:'İptal Et'
                }).then((result) => {
                
                    if (result.isConfirmed) {
                        $('#statusChangeForm').attr("action","{{ route('categories.changeStatus') }}");
                        $('#statusChangeForm').submit();


                    } else if (result.isDenied) {
                        Swal.fire({
                            title: "Bilgi",
                            text: "Değişiklik Yapılmadı.",
                            confirmButtonText: "Tamam",
                            icon:"info",
                        });
                    }
                });
            });

            // btnChangeFeatureStatus tıklandığında.
            $('.btnChangeFeatureStatus').click(function(){
                // idleri al
                let categoryID = $(this).data('id');
                $('#inputStatus').val(categoryID);

                Swal.fire({
                title: "Bilgi",
                text:"Öne Çıkarma Durumunu (Feature Status) Değirtirmek İstiyor Musunuz ?",
                icon:"info",
                showDenyButton: true,
                // showCancelButton: true,
                confirmButtonText: "Değiştir",
                denyButtonText: `Değiştirme`,
                // cancelButtonText:'İptal Et'
                }).then((result) => {
                
                    if (result.isConfirmed) {
                        $('#statusChangeForm').attr("action","{{ route('categories.changeFeatureStatus') }}");
                        $('#statusChangeForm').submit();


                    } else if (result.isDenied) {
                        Swal.fire({
                            title: "Bilgi",
                            text: "Değişiklik Yapılmadı.",
                            confirmButtonText: "Tamam",
                            icon:"info",
                        });
                    }
                });
            });


            $('.btnDeleteCategory').click(function(){
                // idleri al
                let categoryID = $(this).data('id');
                let categoryName = $(this).data('name');
                $('#inputStatus').val(categoryID);

                Swal.fire({
                title: "Bilgi",
                text: categoryName + " Kategorisini Silmek İstiyor Musunuz ?",
                icon:"info",
                showDenyButton: true,
                // showCancelButton: true,
                confirmButtonText: "Sil",
                denyButtonText: `Silme ve iptal et.`,
                // cancelButtonText:'İptal Et'
                }).then((result) => {
                
                    if (result.isConfirmed) {
                        $('#statusChangeForm').attr("action","{{ route('categories.delete') }}");
                        $('#statusChangeForm').submit();


                    } else if (result.isDenied) {
                        Swal.fire({
                            title: "Bilgi",
                            text: "Değişiklik Yapılmadı.",
                            confirmButtonText: "Tamam",
                            icon:"info",
                        });
                    }
                });
            });

            $('#selectParentCategory').select2();
        });
</script>
@endsection