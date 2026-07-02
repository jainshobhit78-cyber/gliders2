@extends('backend.layout.app')

@section('content')
    <div class="title-header title-header-1 d-flex align-items-center justify-content-between">
        <h5>
            Chatbot FAQs
        </h5>
        <a href="{{ route('chatbot.create') }}" class="btn btn-primary">
            + Add New Q/A
        </a>

    </div>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                @include('_message')
                <div class="table-responsive">
                    <table class="user-table table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Question</th>
                                <th>Answer</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($faqs as $faq)
                                <tr>
                                    <td>{{ $faq->id }}</td>
                                    <td>{{ $faq->question }}</td>
                                    <td class="text-wrap">{{ $faq->answer }}</td>

                                    <td>

                                        <ul class="table-action">
                                            <li>

                                                <a href="javascript:void(0)" class="btn btn-edit openReportEdit"
                                                    data-url="{{ route('chatbot.edit', $faq->id) }}">

                                                    Edit

                                                </a>

                                            </li>

                                            <li>

                                                <a href="{{ route('chatbot.delete', $faq->id) }}"
                                                    class="btn btn-delete" onclick="return confirm('Delete this record?')">

                                                    Delete

                                                </a>

                                            </li>
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
@endsection