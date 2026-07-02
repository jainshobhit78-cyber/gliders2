<style>
    .category-card {
        border: 1px solid #0000001A !important;
        padding: 16px;
        padding-top: 0;
        border-radius: 4px;
    }
</style>

<div class="category-card card">

    <div class="card-body">
        <div class="title-header">
            <h5 class="mb-0">
                News Categories
            </h5>
        </div>

        @foreach($categories as $cat)

            <div class="d-flex justify-content-between align-items-center mb-2">

                <span class="badge bg-primary">

                    {{ $cat->name }}

                </span>
                @if(auth()->guard('admin')->user()->can('news_categories.edit'))
                    <button class="btn btn-sm btn-outline-primary editCategory" data-id="{{ $cat->id }}"
                        data-name="{{ $cat->name }}">

                        Edit

                    </button>
                @endif


            </div>

        @endforeach


        <hr>
        @if(auth()->guard('admin')->user()->can('news_categories.create'))
            <form method="post" action="{{ url('admin/news/category/add') }}">

                @csrf

                <label class="form-label-title">
                    Add Category
                </label>

                <input type="text" name="name" class="form-control" placeholder="Category Name" required>

                <button class="btn btn-theme mt-3 w-100 justify-content-center text-center">

                    Add Category

                </button>

            </form>
        @endif
    </div>

</div>