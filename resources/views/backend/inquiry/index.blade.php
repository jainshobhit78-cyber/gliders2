@extends('backend.layout.app')

@section('content')

    <div class="title-header title-header-1 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3">
            <h5 class="mb-0 page-title">
                Update Profile
            </h5>
        </div>
    </div>
    <div class="container-fluid">

        <div class="page-title pb-4">
            <h3>Inquiry Messages</h3>
        </div>

        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="user-table table table-bordered table-hover">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Message</th>
                                <th>Date</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($messages as $message)
                                <tr>
                                    <td>{{ $message->id }}</td>
                                    <td>{{ $message->name }}</td>
                                    <td>{{ $message->email }}</td>
                                    <td>{{ $message->phone }}</td>
                                    <td>{{ $message->message }}</td>
                                    <td>{{ $message->created_at->format('d M Y h:i A') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        No Inquiry Found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </div>

@endsection