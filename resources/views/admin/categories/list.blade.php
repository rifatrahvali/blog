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
                        Aktif
                        @else
                        Pasif
                        @endif
                    </td>
                    <td>
                        @if ($category->feature_status)
                        Aktif
                        @else
                        Pasif
                        @endif
                    </td>
                    <td>{{ substr($category->description,0,20) }}</td>
                    <td>{{ $category->order}}</td>
                    <td>{{ $category->parentCategory?->name}}</td>
                    <td>{{ $category->user->name}}</td>
                    <td>
                        <div class="d-flex">
                            <a href="" class="btn btn-warning btn-sm"><i class="material-icons ms-0">edit</i></a>
                            <a href="" class="btn btn-danger btn-sm"><i class="material-icons ms-0">delete</i></a>
                        </div>
                    </td>
                </tr>

                @endforeach

            </x-slot:rows>
        </x-bootstrap.table>

    </x-slot:body>
</x-bootstrap.card>

@endsection

@section("js")

@endsection