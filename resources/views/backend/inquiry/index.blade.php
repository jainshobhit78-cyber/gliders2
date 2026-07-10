@extends('backend.layout.app')

@section('content')
    <div class="title-header title-header-1 d-flex align-items-center justify-content-between mb-4">
        <div class="d-flex align-items-center gap-3">
            <h5 class="mb-0 page-title" style="font-family: 'Outfit', sans-serif; font-weight: 800; color: #081d40;">
                Inquiry Messages & Queries
            </h5>
        </div>
    </div>

    <div class="container-fluid" style="font-family: 'Outfit', sans-serif;">
        <!-- Alert banners for responses -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 p-3 mb-4" role="alert" style="background-color: #d1e7dd; color: #0f5132;">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 p-3 mb-4" role="alert" style="background-color: #f8d7da; color: #842029;">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $errors->first() }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 rounded-4 shadow-sm">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" style="border-color: #f1f3f5;">
                        <thead class="table-light text-uppercase" style="font-size: 11.5px; font-weight: 700; color: #6c757d; border-bottom: 2px solid #e9ecef;">
                            <tr>
                                <th style="padding: 15px 10px;">ID</th>
                                <th style="padding: 15px 10px;">Date & Time</th>
                                <th style="padding: 15px 10px;">Sender</th>
                                <th style="padding: 15px 10px;">Subject & Product</th>
                                <th style="padding: 15px 10px;">Message Preview</th>
                                <th style="padding: 15px 10px; text-align: center;">Status</th>
                                <th style="padding: 15px 10px; text-align: center;">Action</th>
                            </tr>
                        </thead>

                        <tbody style="font-size: 13.5px; color: #495057;">
                            @forelse($messages as $message)
                                <tr style="border-bottom: 1px solid #f1f3f5; transition: background-color 0.2s;">
                                    <td class="fw-bold" style="padding: 15px 10px; color: #081d40;">#{{ $message->id }}</td>
                                    <td style="padding: 15px 10px;">
                                        <div style="font-weight: 600; color: #333;">{{ $message->created_at->format('d M Y') }}</div>
                                        <div class="text-muted" style="font-size: 11.5px;">{{ $message->created_at->format('h:i A') }}</div>
                                    </td>
                                    <td style="padding: 15px 10px;">
                                        <div class="fw-bold" style="color: #212529;">{{ $message->name }}</div>
                                        <div style="font-size: 12px; color: #0b2a5b;"><i class="bi bi-envelope-fill me-1"></i>{{ $message->email }}</div>
                                        <div class="text-muted" style="font-size: 12px;"><i class="bi bi-telephone-fill me-1"></i>{{ $message->phone }}</div>
                                    </td>
                                    <td style="padding: 15px 10px; max-width: 200px;">
                                        <div class="fw-bold text-truncate" style="color: #212529;" title="{{ $message->subject }}">{{ $message->subject ?? 'General Inquiry' }}</div>
                                        @if($message->product)
                                            <div style="margin-top: 4px;">
                                                <span class="badge bg-light text-dark border px-2 py-1" style="font-size: 11px; font-weight: 600;">
                                                    <i class="bi bi-box-seam me-1 text-primary"></i> {{ $message->product->title }}
                                                </span>
                                            </div>
                                        @endif
                                    </td>
                                    <td style="padding: 15px 10px; max-width: 250px;">
                                        <div class="text-truncate text-muted" title="{{ $message->message }}">{{ $message->message }}</div>
                                    </td>
                                    <td style="padding: 15px 10px; text-align: center;">
                                        @if($message->status === 'replied')
                                            <span class="badge bg-success-light text-success px-3 py-1.5 rounded-pill" style="font-weight: 600; font-size: 11px; background-color: rgba(25, 135, 84, 0.1);">
                                                <i class="bi bi-check-circle-fill me-1"></i> Replied
                                            </span>
                                        @else
                                            <span class="badge bg-warning-light text-warning px-3 py-1.5 rounded-pill" style="font-weight: 600; font-size: 11px; background-color: rgba(255, 193, 7, 0.1);">
                                                <i class="bi bi-clock-fill me-1"></i> Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td style="padding: 15px 10px; text-align: center;">
                                        <button class="btn btn-sm btn-primary-theme px-3 py-1.5 rounded-3 fw-bold" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#replyModal{{ $message->id }}"
                                                style="font-size: 12px; background-color: #0b2a5b; border-color: #0b2a5b; color: white;">
                                            <i class="bi bi-reply-fill me-1"></i> View & Reply
                                        </button>
                                    </td>
                                </tr>

                                <!-- REPLY MODAL -->
                                <div class="modal fade" id="replyModal{{ $message->id }}" tabindex="-1" aria-labelledby="replyModalLabel{{ $message->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content border-0 rounded-4 shadow-lg">
                                            <div class="modal-header text-white p-4" style="background-color: #0b2a5b; border-bottom: 3px solid #f5821f; border-top-left-radius: 16px; border-top-right-radius: 16px;">
                                                <h5 class="modal-title" id="replyModalLabel{{ $message->id }}" style="font-weight: 800;">
                                                    <i class="bi bi-chat-left-dots-fill me-2"></i> Message Thread #{{ $message->id }}
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4" style="background-color: #f8fafc;">
                                                
                                                <!-- original message card -->
                                                <div class="card border-0 rounded-4 shadow-sm mb-4">
                                                    <div class="card-body p-4">
                                                        <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                                                            <div>
                                                                <h6 class="mb-0 fw-bold" style="color: #081d40; font-size: 14.5px;">{{ $message->name }}</h6>
                                                                <span class="text-muted" style="font-size: 12px;">{{ $message->email }} | {{ $message->phone }}</span>
                                                            </div>
                                                            <div class="text-end">
                                                                <span class="text-muted d-block" style="font-size: 12px;">{{ $message->created_at->format('d M Y h:i A') }}</span>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <strong class="d-block text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Subject</strong>
                                                            <div style="font-weight: 600; color: #212529; font-size: 14px;">{{ $message->subject ?? 'General Inquiry' }}</div>
                                                        </div>

                                                        @if($message->product)
                                                            <div class="mb-3">
                                                                <strong class="d-block text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Product Reference</strong>
                                                                <div style="margin-top: 4px;">
                                                                    <span class="badge bg-light text-dark border px-2.5 py-1.5" style="font-size: 12px; font-weight: 600;">
                                                                        <i class="bi bi-box-seam me-1 text-primary"></i> {{ $message->product->title }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        <div>
                                                            <strong class="d-block text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Message Details</strong>
                                                            <div class="p-3 bg-light rounded-3 mt-2 border-start border-primary border-3" style="font-size: 14px; white-space: pre-wrap; line-height: 1.5; color: #495057;">{{ $message->message }}</div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- if already replied -->
                                                @if($message->status === 'replied')
                                                    <div class="card border-0 rounded-4 shadow-sm mb-4" style="border-left: 4px solid #198754 !important;">
                                                        <div class="card-body p-4" style="background-color: rgba(25, 135, 84, 0.02);">
                                                            <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                                                                <div>
                                                                    <h6 class="mb-0 fw-bold text-success" style="font-size: 14.5px;"><i class="bi bi-check-circle-fill me-1"></i> Admin Response Sent</h6>
                                                                </div>
                                                                <div class="text-end">
                                                                    <span class="text-muted d-block" style="font-size: 12px;">{{ \Carbon\Carbon::parse($message->replied_at)->format('d M Y h:i A') }}</span>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <strong class="d-block text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Reply Sent</strong>
                                                                <div class="p-3 bg-light rounded-3 mt-2" style="font-size: 14px; white-space: pre-wrap; line-height: 1.5; color: #495057;">{{ $message->reply_text }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                <!-- reply editor form -->
                                                <div class="card border-0 rounded-4 shadow-sm">
                                                    <div class="card-body p-4">
                                                        <h6 class="fw-bold mb-3" style="color: #081d40; font-size: 14.5px;">
                                                            <i class="bi bi-envelope-at-fill me-1"></i> Compose Email Reply
                                                        </h6>
                                                        <form action="{{ route('admin.inquiry.reply', $message->id) }}" method="POST">
                                                            @csrf
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted" style="font-size: 12px; font-weight: 600;">Email Subject</label>
                                                                <input type="text" name="reply_subject" class="form-control rounded-3" 
                                                                       value="Re: {{ $message->subject ?? 'Inquiry Reply' }}" required style="font-size: 13.5px;">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted" style="font-size: 12px; font-weight: 600;">Reply Message</label>
                                                                <textarea name="reply_body" rows="6" class="form-control rounded-3" 
                                                                          placeholder="Type your official email reply response here..." required style="font-size: 13.5px;"></textarea>
                                                            </div>
                                                            <div class="text-end mt-4">
                                                                <button type="button" class="btn btn-light px-4 py-2 rounded-3 me-2" data-bs-dismiss="modal" style="font-size: 13px; font-weight: 600;">Cancel</button>
                                                                <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 text-white" 
                                                                        style="background-color: #f5821f; border-color: #f5821f; font-size: 13px; font-weight: 600;">
                                                                    <i class="bi bi-send-fill me-1"></i> Send Reply Email
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="bi bi-envelope-open-fill d-block mb-2" style="font-size: 32px; color: #dee2e6;"></i>
                                        No Inquiry Messages Found
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