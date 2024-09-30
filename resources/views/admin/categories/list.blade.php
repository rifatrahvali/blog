@extends("layouts.admin")

@section("title")
Kategori Listele Sayfası
@endsection

@section("css")

@endsection

@section("content")

<x-bootstrap.card>
    <x-slot:header>
        Kategori Liste
    </x-slot:header>
    <x-slot:body>

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
                    <td>{{ substr($category->description,0,20) }}</td>
                    <td>{{ $category->order}}</td>
                    <td>{{ $category->parentCategory?->name}}</td>
                    <td>{{ $category->user->name}}</td>
                    <td>
                        <div class="d-flex">
                            <a href="javascript:void(0)" class="btn btn-warning btn-sm"><i
                                    class="material-icons ms-0">edit</i></a>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm btnDeleteCategory"
                                data-name="{{ $category->name}}" data-id="{{ $category->id }}">
                                <i class="material-icons ms-0">delete</i></a>
                        </div>
                    </td>
                </tr>

                @endforeach

            </x-slot:rows>
        </x-bootstrap.table>

    </x-slot:body>
</x-bootstrap.card>


<form action="" method="POST" id="statusChangeForm">
    @csrf
    <input type="hidden" name="id" value="" id="inputStatus">
</form>
@endsection

@section("js")
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
                confirmButtonText: "Değiştir",
                denyButtonText: `Değiştirme`,
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


        });
</script>
@endsection