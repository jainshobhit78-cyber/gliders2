@extends('backend.layout.app')

@section('content')

    <div class="title-header d-flex justify-content-between align-items-center">
        <h5>Add FAQ</h5>

    </div>

    <div class="card mt-3">
        <div class="card-body">

            <form method="POST" action="{{ route('chatbot.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label-title">Question</label>
                    <input type="text" name="question" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label-title">Answer</label>
                    <textarea name="answer" class="form-control"></textarea>
                </div>

                <div class="panel-footer">

                    <button class="btn btn-primary" id="submitBtn">

                        <span class="btnText">Add</span>

                        <span class="btnLoader d-none">

                            <i class="fa fa-spinner fa-spin"></i> Saving...

                        </span>

                    </button>

                </div>
            </form>
        </div>
    </div>
@endsection

<script>
    $(document).on('submit', '.theme-form', function () {

        $('#submitBtn').prop('disabled', true)

        $('.btnText').addClass('d-none')
        $('.btnLoader').removeClass('d-none')

    })

</script>