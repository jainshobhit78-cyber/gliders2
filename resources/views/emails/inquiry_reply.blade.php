<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $replySubject }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f6f9;
            color: #333333;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        .email-wrapper {
            width: 100%;
            background-color: #f4f6f9;
            padding: 30px 0;
        }
        .email-content {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
        }
        .email-header {
            background-color: #0b2a5b;
            padding: 25px;
            text-align: center;
            border-bottom: 3px solid #f5821f;
        }
        .email-header h2 {
            color: #ffffff;
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .email-header p {
            color: #cbd5e1;
            margin: 5px 0 0 0;
            font-size: 13px;
        }
        .email-body {
            padding: 30px;
            line-height: 1.6;
        }
        .salutation {
            font-size: 16px;
            font-weight: bold;
            color: #0b2a5b;
            margin-bottom: 15px;
        }
        .message-content {
            font-size: 15px;
            color: #4a5568;
            margin-bottom: 25px;
            white-space: pre-wrap;
        }
        .original-quote {
            background-color: #f8fafc;
            border-left: 4px solid #f5821f;
            padding: 20px;
            margin-top: 30px;
            border-radius: 4px;
        }
        .original-quote h4 {
            margin: 0 0 10px 0;
            color: #0b2a5b;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .original-meta {
            font-size: 12.5px;
            color: #718096;
            margin-bottom: 10px;
            line-height: 1.4;
        }
        .original-text {
            font-size: 14px;
            color: #4a5568;
            font-style: italic;
            white-space: pre-wrap;
        }
        .email-footer {
            background-color: #f8fafc;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
            font-size: 12px;
            color: #718096;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-content">
            <!-- Branded Header -->
            <div class="email-header">
                <h2>Gliders India Limited</h2>
                <p>A Government of India Enterprise, Ministry of Defence</p>
            </div>
            
            <!-- Email Body -->
            <div class="email-body">
                <div class="salutation">Dear {{ $originalMessage->name }},</div>
                
                <div class="message-content">{{ $replyBody }}</div>
                
                <p style="font-size: 14px; color: #718096; margin-top: 30px;">
                    Best Regards,<br>
                    <strong>Customer Support Team</strong><br>
                    Gliders India Limited
                </p>
                
                <!-- Original Message Quote for Context -->
                <div class="original-quote">
                    <h4>Original Inquiry Context</h4>
                    <div class="original-meta">
                        <strong>Subject:</strong> {{ $originalMessage->subject ?? 'General Inquiry' }}<br>
                        @if($originalMessage->product)
                            <strong>Product:</strong> {{ $originalMessage->product->title }}<br>
                        @endif
                        <strong>Submitted on:</strong> {{ $originalMessage->created_at->format('d M Y h:i A') }}
                    </div>
                    <div class="original-text">"{{ $originalMessage->message }}"</div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="email-footer">
                This is an automated response sent from the Gliders India Limited portal.<br>
                Please do not reply directly to this email.<br>
                &copy; {{ date('Y') }} Gliders India Limited. All rights reserved.
            </div>
        </div>
    </div>
</body>
</html>
