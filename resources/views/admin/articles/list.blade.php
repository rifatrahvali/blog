@extends("layouts.admin")

@section("title")
Makale Listele Sayfası
@endsection

@section("css")
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}">
@endsection

@section("content")

<x-bootstrap.card>
    <x-slot:header>
        Makale Liste
    </x-slot:header>
    <x-slot:body>

        <form action="">
            <div class="row">
                <div class="col-3">
                    <input type="text" class="form-control flatpickr2 form-control-solid-bordered m-b-sm"
                        id="publish_date" name="publish_date" placeholder="Makale Yayın Tarihini Seçin"
                        value="{{ request()->get('publish_date') }}">
                </div>
                <div class="col-3">
                    <select class="js-states form-control" name="category_id" id="selectParentCategory" tabindex="-1"
                        style="display: none; width: 100%">
                        <option value="{{ null }}">Kategori Seçin</option>
                        @foreach ($categories as $parent )
                        <option value="{{ $parent->id }}" {{ request()->get('parent_id') == $parent->id ? "selected"
                            : "" }}>
                            {{ $parent->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3">
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
                <div class="col-3">
                    <select name="status" id="status" class="form-select" aria-label="Durumu">
                        <option value="{{ null }}">Durumu</option>
                        <option value="1" {{ request()->get('status') === "1" ? "selected" : "" }}>Aktif</option>
                        <option value="0" {{ request()->get('status') === "0" ? "selected" : "" }}>Pasif</option>
                    </select>
                </div>
                <div class="col-3 mt-2">
                    <input type="text" name="search_text" id="search_text" class="form-control"
                        placeholder="Title, Slug, Body, Tag & Başlık, İçerik, Slug ve Tag"
                        value="{{ request()->get('search_text') }}">
                </div>
                <div class="col-9 mt-2">
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-6">
                                    <input type="number" class="form-control" placeholder="Minimum View Count"
                                        name="min_view_count" id="min_view_count"
                                        value="{{ request()->get('min_view_count') }}">
                                </div>
                                <div class="col-6">
                                    <input type="number" class="form-control" placeholder="Maximum View Count"
                                        name="max_view_count" id="max_view_count"
                                        value="{{ request()->get('max_view_count') }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-6">
                                    <input type="number" class="form-control" placeholder="Minimum Like Count"
                                        name="min_like_count" id="min_like_count"
                                        value="{{ request()->get('min_like_count') }}">
                                </div>
                                <div class="col-6">
                                    <input type="number" class="form-control" placeholder="Maximum Like Count"
                                        name="max_like_count" id="max_like_count"
                                        value="{{ request()->get('max_like_count') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3 d-flex mt-2">
                    <button class="btn btn-primary w-100 me-4" type="submit">Filtrele</button>
                    <button class="btn btn-warning w-100" type="submit">Temizle</button>
                </div>

            </div>
        </form>

        <x-bootstrap.table :class="'table-striped table-hover'" :is-responsive="1">
            <x-slot:columns>
                <th scope="col">Image</th>
                <th scope="col">Title</th>
                <th scope="col">Slug</th>
                <th scope="col">Status</th>
                <th scope="col">Body</th>
                <th scope="col">Tags</th>
                <th scope="col">View Count</th>
                <th scope="col">Like Count</th>
                <th scope="col">Category</th>
                <th scope="col">Publish Date</th>
                <th scope="col">User</th>
                <th scope="col">Actions</th>
            </x-slot:columns>

            <x-slot:rows>
                @foreach ($list as $article)

                <tr id="row-{{$article->id}}">
                    <td>
                        @if (!empty($article->image))
                        <img src="{{ asset($article->image) }}" height="100" class="img-fluid">
                        @endif
                    </td>
                    <td>{{ $article->title }}</td>
                    <td>{{ $article->slug }}</td>
                    <td>
                        @if ($article->status)
                        <a href="javascript:void(0)" class="btn btn-success btn-sm btnChangeStatus"
                            data-id="{{ $article->id }}">Aktif</a>
                        @else
                        <a href="javascript:void(0)" class="btn btn-danger btn-sm btnChangeStatus"
                            data-id="{{ $article->id }}">Pasif</a>
                        @endif
                    </td>
                    {{-- popovers ile üzerine gelince card ile yapabiliriz. --}}
                    <td>
                        <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                            data-bs-title="{{ substr($article->body,0,255) }}">
                            {{ substr($article->body,0,25) }}
                        </span>
                    </td>
                    <td>{{ $article->tags }}</td>
                    <td>{{ $article->view_count }}</td>
                    <td>{{ $article->like_count }}</td>
                    <td>{{ $article->category->name }}</td>
                    <td>{{ $article->user->name }}</td>
                    <td>
                        <div class="d-flex">
                            <a href="javascript:void(0)" class="btn btn-warning btn-sm">
                                <i class="material-icons ms-0">edit</i>
                            </a>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm btnDeleteArticle"
                                data-name="{{ $article->title}}" data-id="{{ $article->id }}">
                                <i class="material-icons ms-0">delete</i>
                            </a>
                        </div>
                    </td>
                </tr>

                @endforeach

            </x-slot:rows>
        </x-bootstrap.table>
        <div class="d-flex justify-content-center">

            {{-- {{ $list->onEachSide(0)->links() }} --}}
            {{-- filtreleme yapıldığında pagination sayfalar arasında geçiş yaparken filtre gitmemesi için append
            kullanıyoruz --}}
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
<script src="{{ asset('assets/js/pages/datepickers.js') }}"></script>
<script src="{{ asset('assets/plugins/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<script>
    // Sayfa hazır olduğunda yapılacak işlemler
        $(document).ready(function(){


            // DURUM BUTONUNA tıklandığında - btnChangeStatus
            $('.btnChangeStatus').click(function(){
                // idleri al
                let articleID = $(this).data('id');
                let self = $(this); // butonun kendisini seçiyoruz

                Swal.fire({
                    title: "Bilgi",
                    text: "Makalenin Durumunu Değiştirmek İstiyor Musunuz?",
                    icon: "info",
                    showDenyButton: true,
                    confirmButtonText: "Değiştir",
                    denyButtonText: `Değiştirme`,
                }).then((result) => {
                    // Değiştir Butonuna Tıklanırsa
                    if (result.isConfirmed) {
                        // STATUS değiştirmek için ajax isteği oluşturuyoruz
                        $.ajax({
                            method: "POST",
                            url: "{{ route('article.changeStatus') }}",
                            data: {
                                articleID: articleID,
                            },
                            success: function(data) {
                                // Doğru json verisini kontrol edelim
                                console.log(data); // AJAX cevabını konsola basıyoruz

                                // Gelen status değerine göre butonun görünümünü güncelle
                                if (data.article_status === 1) { 
                                    self.removeClass('btn-danger').addClass('btn-success').text('Aktif');
                                } else {
                                    self.removeClass('btn-success').addClass('btn-danger').text('Pasif');
                                }

                                Swal.fire({
                                    title: "Bilgi",
                                    text: "Makalenin durumu güncellendi.",
                                    confirmButtonText: "Tamam",
                                    icon: "success",
                                });
                            },
                            error: function(data) {
                                console.log("Hata oluştu", data);
                            }
                        });
                    }
                });
            });

            // MAKALE SİL BUTONUNA TIKLANDIĞINDA
            $('.btnDeleteArticle').click(function(){
                // idleri al
                let articleID = $(this).data('id');
                let articleName = $(this).data('name');

                Swal.fire({
                title: "Bilgi",
                text: articleName + " Makalesini Silmek İstiyor Musunuz ?",
                icon:"info",
                showDenyButton: true,
                confirmButtonText: "Sil",
                denyButtonText: `Silme ve iptal et.`,
                }).then((result) => {
                    
                    // SİL BUTONUNA TIKLANIRSA
                    if (result.isConfirmed) {
                        // AJAX İLE SAYFA YENİLENMEDEN SİLME İŞLEMLERİ
                        $.ajax({
                            method: "POST",
                            url: "{{ route('article.delete') }}",
                            data: {
                                "_method":"DELETE",
                                articleID: articleID,
                            },
                            success: function(data) {

                                $('#row-'+articleID).remove();
                                
                                Swal.fire({
                                    title: "Bilgi",
                                    text: "Makale Silindi.",
                                    confirmButtonText: "Tamam",
                                    icon: "success",
                                });
                            },
                            error: function(data) {
                                console.log("Hata oluştu", data);
                            }
                        });
                    }
                });
            });

            $('#selectParentCategory').select2();

            $('#publish_date').flatpickr({
                enableTime:true,
                dateFormat:'Y-m-d H:i',
            });

            const popover = new bootstrap.Popover('.example-popover', {
            container: 'body'
            })
        });
</script>
@endsection