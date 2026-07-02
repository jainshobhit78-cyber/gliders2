@extends('backend.layout.app')

@section('content')


    <div class="about-section">

        <div class="title-header d-flex align-items-center justify-content-between">

            <h5 class="mb-0 page-title">
                Product Categories
            </h5>
            @if(auth()->guard('admin')->user()->can('product_categories.create'))
                <a href="{{ url('admin/category/add') }}" class="btn btn-theme">
                    Add New Category
                </a>
            @endif


        </div>

        <div class="container-fluid">
            <div class="card">

                <div class="card-body">
                    @include('_message')

                    <div class="table-responsive">

                        <table class="user-table table table-bordered">

                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Category Name</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($categories as $cat)

                                    <tr>

                                        <td>
                                            <span class="badge bg-secondary" style="font-size:0.9rem;">{{ $cat->display_order != 999 ? $cat->display_order : '-' }}</span>
                                        </td>

                                        <td>{{ $cat->name }}</td>

                                        <td>
                                            @if($cat->image)
                                                <img src="{{ asset('uploads/category/' . $cat->image) }}" width="60">
                                            @endif
                                        </td>


                                        <td>
                                            @if($cat->status == 'active')
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>

                                        <td>

                                            <ul class="table-action">
                                                @if(auth()->guard('admin')->user()->can('product_categories.edit'))
                                                    <li>
                                                        <a href="{{ url('admin/category/edit/' . $cat->id) }}" class="btn btn-edit">
                                                            Edit
                                                        </a>
                                                    </li>
                                                @endif

                                                @if(auth()->guard('admin')->user()->can('product_categories.delete'))
                                                    <li>
                                                        <a href="{{ url('admin/category/delete/' . $cat->id) }}"
                                                            class="btn btn-delete" onclick="return confirm('Delete this record?')">
                                                            Delete
                                                        </a>
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