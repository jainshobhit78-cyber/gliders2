<div class="title-header d-flex align-items-center gap-3">

    <a href="javascript:void(0)" class="back-btn backNews">

        <svg width="24" height="24" viewBox="0 0 24 24">
            <path d="M22 13V11H5.82L9.77 7.05L8.36 5.64L2 12L8.36 18.36L9.77 16.95L5.82 13H22Z" />
        </svg>

        <span>Back</span>

    </a>

    <h5>Add News Article</h5>

</div>


<div class="card">

    <div class="card-body">

        <form method="post" action="{{ url('admin/news/add') }}" enctype="multipart/form-data" class="theme-form">

            @csrf


            <div class="mb-4">

                <label class="form-label-title">

                    Title

                </label>

                <input type="text" name="title" class="form-control" required>

            </div>


            <div class="mb-4">

                <label class="form-label-title">

                    Subtitle

                </label>

                <input type="text" name="subtitle" class="form-control" required>

            </div>


            <div class="mb-4">

                <label class="form-label-title">

                    Category

                </label>

                <select name="category_id" class="form-control" required>

                    @foreach($categories as $cat)

                        <option value="{{$cat->id}}">

                            {{$cat->name}}

                        </option>

                    @endforeach

                </select>

            </div>


            <div class="mb-4">

                <label class="form-label-title">

                    Author

                </label>

                <input type="text" name="author" class="form-control" required>

            </div>


            <div class="mb-4">

                <label class="form-label-title">

                    Wallpaper

                </label>

                <input type="file" name="wallpaper" id="pictureInput" class="form-control"
                    accept="image/jpeg,image/png,image/jpg,image/webp,image/svg+xml">
                <img id="imagePreview" style="max-width:200px;margin-top:10px;display:none;border-radius:6px;">

            </div>


                <div class="mb-4">

                    <label class="form-label-title">

                        Content

                    </label>

                    <textarea name="content" class="editor form-control">
                    </textarea>

                </div>


            <div class="mb-4">

                <label class="form-label-title">

                    Publish Date

                </label>

                <input type="date" name="publish_date" class="form-control" required>

            </div>


            <div class="mb-4">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="hide_during_election" id="hide_during_election" style="cursor:pointer;">
                    <label class="form-check-label" for="hide_during_election" style="cursor:pointer; font-weight:600;">Hide this article during Election Periods</label>
                </div>
            </div>

            @if(auth()->guard('admin')->user()->hasRole('admin'))
                <div class="mb-4">

                    <label class="form-label-title">

                        Status

                    </label>

                    <select name="status" class="form-control">
                        <option value="Published">

                            Published

                        </option>

                        <option value="Pending">

                            Pending

                        </option>

                    </select>

                </div>
            @endif


            <button class="btn btn-theme">

                {{ auth()->guard('admin')->user()->hasRole('admin') ? 'Save News' : 'Send to Admin for Approval' }}

            </button>


        </form>

    </div>

</div>