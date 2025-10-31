<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Doctor Note - {{ $note->title ?: 'Note #' . $note->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #2563eb;
        }
        .header h1 {
            color: #2563eb;
            margin: 0 0 10px 0;
        }
        .info-section {
            background-color: #f3f4f6;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .info-row {
            margin-bottom: 8px;
        }
        .label {
            font-weight: bold;
            color: #1f2937;
        }
        .content-section {
            margin: 30px 0;
            padding: 20px;
            background-color: #f9fafb;
            border-left: 4px solid #2563eb;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            margin-left: 5px;
        }
        .badge-private { background-color: #fee2e2; color: #991b1b; }
        .badge-followup { background-color: #fef3c7; color: #92400e; }
        .badge-category { background-color: #dbeafe; color: #1e40af; }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #6b7280;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Doctor Note</h1>
        <p><strong>Mental Health and Rehab System</strong></p>
        <p style="font-size: 10px;">Generated on {{ \Carbon\Carbon::now()->format('F d, Y \a\t g:i A') }}</p>
    </div>

    <div class="info-section">
        <h2 style="margin-top: 0; color: #1f2937;">Note Information</h2>

        <div class="info-row">
            <span class="label">Note ID:</span> #{{ $note->id }}
            @if($note->is_private)
                <span class="badge badge-private">PRIVATE</span>
            @endif
            @if($note->follow_up_required)
                <span class="badge badge-followup">FOLLOW-UP REQUIRED</span>
            @endif
            @if($note->category)
                <span class="badge badge-category">{{ $note->category }}</span>
            @endif
        </div>

        @if($note->title)
            <div class="info-row">
                <span class="label">Title:</span> {{ $note->title }}
            </div>
        @endif

        <div class="info-row">
            <span class="label">Date Created:</span> {{ $note->created_at->format('F d, Y \a\t g:i A') }}
        </div>

        <div class="info-row">
            <span class="label">Doctor:</span> Dr. {{ $note->doctor->name }}
        </div>

        <div class="info-row">
            <span class="label">Patient:</span> {{ $note->user->name }}
        </div>

        @if($note->appointment)
            <div class="info-row">
                <span class="label">Linked Appointment:</span>
                {{ $note->appointment->appointment_date->format('F d, Y') }} at
                {{ date('g:i A', strtotime($note->appointment->start_time)) }}
            </div>
        @endif
    </div>

    <div style="margin-bottom: 10px;">
        <h2 style="color: #1f2937;">Note Content</h2>
    </div>

    <div class="content-section">
        <div style="white-space: pre-wrap;">{{ $note->content }}</div>
    </div>

    @if($note->is_private)
        <div style="padding: 15px; background-color: #fee2e2; border-left: 4px solid #991b1b; margin: 20px 0;">
            <p style="margin: 0; color: #991b1b; font-weight: bold;">
                ⚠ CONFIDENTIAL - This note is marked as private and should not be shared with the patient.
            </p>
        </div>
    @endif

    @if($note->follow_up_required)
        <div style="padding: 15px; background-color: #fef3c7; border-left: 4px solid #92400e; margin: 20px 0;">
            <p style="margin: 0; color: #92400e; font-weight: bold;">
                📋 FOLLOW-UP REQUIRED - This patient needs a follow-up consultation.
            </p>
        </div>
    @endif

    <div class="footer">
        <p>This is a confidential medical document. Please keep it secure.</p>
        <p>&copy; {{ date('Y') }} Mental Health and Rehab System. All rights reserved.</p>
    </div>
</body>
</html>
