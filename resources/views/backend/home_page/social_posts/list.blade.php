<style>
    .user-table { text-align: center; }
    .badge { padding: 11px 13px !important; }
    .dataTables_wrapper .dataTables_paginate .paginate_button { padding: 0 !important; }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover { background: transparent !important; border: none; }
    .platform-pill { padding: 5px 12px; border-radius: 20px; color: #fff; font-size: 12px; font-weight: 600; text-transform: capitalize; }
    .platform-pill.facebook { background: #1877F2; }
    .platform-pill.linkedin { background: #0A66C2; }
    .platform-pill.instagram { background: #d6249f; }
</style>
<div class="about-section">

    <div class="title-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0 page-title">Latest from Social Media</h5>
        <a href="javascript:void(0)" class="btn btn-theme openLogoAdd"
            data-url="{{ url('admin/home/social_posts/form') }}">
            <i data-feather="plus-square"></i>
            Add New Post
        </a>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">

                @include('_message')

                <div class="table-responsive">
                    <table id="socialTable" class="user-table table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Platform</th>
                                <th>Content</th>
                                <th>Image</th>
                                <th>Date</th>
                                <th>Likes</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($posts as $key => $post)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><span class="platform-pill {{ strtolower($post->platform) }}">{{ $post->platform }}</span></td>
                                    <td style="max-width:320px; text-align:left;">{{ \Illuminate\Support\Str::limit($post->content, 90) }}</td>
                                    <td>
                                        @if($post->image)
                                            <img src="{{ asset('uploads/social/' . $post->image) }}"
                                                style="width:70px; height:50px; object-fit:cover; border-radius:6px;">
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>{{ $post->post_date ? \Carbon\Carbon::parse($post->post_date)->format('d M Y') : '—' }}</td>
                                    <td>{{ $post->likes }}</td>
                                    <td>
                                        <span class="badge {{ $post->status === 'Published' ? 'bg-success' : 'bg-secondary' }}">{{ $post->status }}</span>
                                    </td>
                                    <td>
                                        <ul class="table-action">
                                            <li>
                                                <a href="javascript:void(0)" class="btn btn-edit openLogoEdit"
                                                    data-url="{{ url('admin/home/social_posts/form/' . $post->id) }}">
                                                    Edit
                                                </a>
                                            </li>
                                            <li>
                                                <x-delete-form :action="url('admin/home/social_posts/delete/' . $post->id)" class="btn btn-delete" confirm="Delete this post?" />
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">No Social Posts Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#socialTable').DataTable({
            paging: true, searching: false, info: true, lengthChange: false, pageLength: 10, ordering: false
        });
    });
</script>
