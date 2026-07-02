<style>
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0;
    }

    #newsTable_filter {
        display: none !important;
    }
</style>
<div class="d-flex justify-content-between align-items-center mb-3">

    <div style="width:60%">

        <input type="text" id="newsSearch" class="form-control" placeholder="Search articles...">

    </div>

    <div style="width:35%">

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

    <table id="newsTable" class="user-table table table-striped">

        <thead>

            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
            </tr>

        </thead>

        <tbody>

            @forelse($items as $key => $item)

                <tr>

                    <td>{{ $key + 1 }}</td>

                    <td>{{ $item->title }}</td>

                    <td>

                        @if($item->category)

                            <span class="badge bg-info">

                                {{ $item->category->name }}

                            </span>

                        @endif

                    </td>

                    <td>

                        @if($item->status == "Published")

                            <span class="badge bg-success">

                                Published

                            </span>

                        @else

                            <span class="badge bg-warning">

                                Pending

                            </span>

                        @endif

                    </td>

                    <td>

                        {{ $item->publish_date }}

                    </td>

                    <td>

                        <ul class="table-action">
                            @if(auth()->guard('admin')->user()->can('news.edit'))
                                <li>
                                    <a href="javascript:void(0)" class="btn btn-edit openNewsEdit"
                                        data-url="{{ url('admin/news/edit/' . $item->id) }}">
                                        Edit
                                    </a>
                                </li>
                            @endif
                            @if(auth()->guard('admin')->user()->can('news.delete'))
                                <li>
                                    <a href="{{ url('admin/news/delete/' . $item->id) }}"
                                        onclick="return confirm('Delete this article?')" class="btn btn-delete">
                                        Delete
                                    </a>
                                </li>
                            @endif


                        </ul>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="6">

                        No News Found

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>

<script>

    $(document).ready(function () {

        let table = $('#newsTable').DataTable({
            paging: true,
            searching: true,
            info: true,
            lengthChange: false
        })

        // Custom Search Input
        $('#newsSearch').on('keyup', function () {

            table.search(this.value).draw()

        })

        // Category Filter
        $('#categoryFilter').on('change', function () {

            let category = $(this).val()

            table.column(2).search(category).draw()

        })

    })

</script>