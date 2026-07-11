<div class="title-header d-flex align-items-center gap-3">

    <a href="javascript:void(0)" class="back-btn backNews">
        <svg width="24" height="24" viewBox="0 0 24 24">
            <path d="M22 13V11H5.82L9.77 7.05L8.36 5.64L2 12L8.36 18.36L9.77 16.95L5.82 13H22Z" />
        </svg>

        <span>Back</span>
    </a>

    <h5>Edit News Article</h5>

</div>

<div class="card">

    <div class="card-body">

        <form method="post" action="{{url('admin/news/update/' . $item->id)}}" enctype="multipart/form-data">

            @csrf

            <div class="mb-4">
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="{{$item->title}}" required>
            </div>

            <div class="mb-4">
                <label>Subtitle</label>
                <input type="text" name="subtitle" class="form-control" value="{{$item->subtitle}}" required>
            </div>

            <div class="mb-4">
                <label>Category</label>
                <select name="category_id" class="form-control" required>

                    @foreach($categories as $cat)

                        <option value="{{$cat->id}}" @if($item->category_id == $cat->id) selected @endif>

                            {{$cat->name}}

                        </option>

                    @endforeach

                </select>
            </div>

            <div class="mb-4">
                <label>Author</label>
                <input type="text" name="author" class="form-control" value="{{$item->author}}" required>
            </div>

            <div class="mb-4">
                <label>Wallpaper</label>

                <input type="file" name="wallpaper" id="pictureInput" class="form-control"
                    accept="image/jpeg,image/png,image/jpg,image/webp,image/svg+xml">

                @if($item->wallpaper)

                    <img src="{{asset('uploads/news/' . $item->wallpaper)}}" id="imagePreview"
                        style="margin-top:10px;height:120px;border:1px solid #ddd;padding:4px;">

                @endif

            </div>

            <div class="mb-4">
                <label>Content</label>

                <textarea name="content" class="editor form-control">

                        {{$item->content}}

                        </textarea>

            </div>

            <div class="mb-4">
                <label>Publish Date</label>
                <input type="date" name="publish_date" class="form-control" value="{{$item->publish_date}}" required>
            </div>

            <div class="mb-4">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="hide_during_election" id="hide_during_election" style="cursor:pointer;" {{ $item->hide_during_election ? 'checked' : '' }}>
                    <label class="form-check-label" for="hide_during_election" style="cursor:pointer; font-weight:600;">Hide this article during Election Periods</label>
                </div>
            </div>

            @if(auth()->guard('admin')->user()->hasRole('admin') || auth()->guard('admin')->user()->can('news.edit'))
                <div class="mb-4">
                    <label>Status</label>

                    <select name="status" class="form-control">

                        <option value="Published" @if($item->status == "Published") selected @endif>

                            Published

                        </option>
                        <option value="Pending" @if($item->status == "Pending") selected @endif>

                            Pending

                        </option>

                    </select>

                </div>
            @endif

            <button class="btn btn-theme">
                {{ auth()->guard('admin')->user()->hasRole('admin') ? 'Update News' : 'Send to Admin for Approval' }}
            </button>

        </form>

    </div>

</div>