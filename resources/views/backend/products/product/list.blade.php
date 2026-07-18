@extends('backend.layout.app')

@section('content')

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <div class="about-section">

        <div class="title-header d-flex justify-content-between">

            <h5>Products</h5>
            @if(auth()->guard('admin')->user()->can('product.view'))
                <a href="{{ url('admin/product/add') }}" class="btn btn-theme">
                    Add Product
                </a>
            @endif
        </div>


        <div class="container-fluid">

            <div class="card">

                <div class="card-body">

                    @include('_message')

                    <div class="row mb-3">

                        <div class="col-md-4">

                            <select id="categoryFilter" class="form-control">

                                <option value="">All Categories</option>

                                @foreach($categories as $cat)

                                    <option value="{{ $cat->name }}">
                                        {{ $cat->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>


                    <div class="table-responsive">

                        <table id="productTable" class="user-table table table-bordered">

                            <thead>

                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Wallpaper</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Display Order</th>
                                    <th>Action</th>
                                </tr>

                            </thead>

                            <tbody>

                                @foreach($products as $p)

                                    <tr>

                                        <td>{{ $p->id }}</td>

                                        <td>

                                            @if($p->images->count())

                                                <img src="{{ asset('uploads/products/' . $p->images->first()->image) }}" width="60"
                                                    style="border-radius:6px">

                                            @endif

                                        </td>

                                       <td>
                                            @if($p->wallpaper)
                                                <img src="{{ asset('uploads/products/' . $p->wallpaper) }}" width="80" style="border-radius:6px">
                                            @endif
                                        </td>

                                        <td>{{ $p->title }}</td>

                                        <td>{{ $p->category->name ?? '' }}</td>

                                        <td>{{ $p->display_order }}</td>

                                        <td>

                                            <ul class="table-action">
                                                @if(auth()->guard('admin')->user()->can('product.edit'))
                                                    <li>
                                                        <a href="{{ url('admin/product/edit/' . $p->id) }}" class="btn btn-edit">
                                                            Edit
                                                        </a>
                                                    </li>
                                                @endif
                                                @if(auth()->guard('admin')->user()->can('product.delete'))
                                                    <li>
                                                        <form action="{{ url('admin/product/delete/' . $p->id) }}" method="POST" onsubmit="return confirm('Delete this record?')" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-delete" style="border: none; background: none; padding: 0; margin: 0; width: 100%; text-align: left; color: inherit; font: inherit;">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                            </ul>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection


@section('script')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>

        $(document).ready(function () {

            var table = $('#productTable').DataTable({

                pageLength: 10

            });


            $('#categoryFilter').on('change', function () {

                var category = $(this).val();

                table.column(4).search(category).draw();

            });

        });

    </script>

@endsection