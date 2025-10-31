<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Medical Records - {{ $user->name }}</title>
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
        .patient-info {
            background-color: #f3f4f6;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .patient-info h2 {
            margin: 0 0 10px 0;
            color: #1f2937;
        }
        .section {
            margin-bottom: 30px;
        }
        .section h2 {
            color: #2563eb;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th {
            background-color: #2563eb;
            color: white;
            padding: 10px;
            text-align: left;
        }
        table td {
            padding: 8px;
            border-bottom: 1px solid #e5e7eb;
        }
        table tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-completed { background-color: #d1fae5; color: #065f46; }
        .badge-confirmed { background-color: #dbeafe; color: #1e40af; }
        .badge-pending { background-color: #fef3c7; color: #92400e; }
        .badge-cancelled { background-color: #fee2e2; color: #991b1b; }
        .badge-active { background-color: #d1fae5; color: #065f46; }
        .note-box {
            background-color: #f9fafb;
            padding: 10px;
            margin: 10px 0;
            border-left: 4px solid #2563eb;
        }
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
        <h1>Medical Records</h1>
        <p><strong>Mental Health and Rehab System</strong></p>
        @if($dateFrom || $dateTo)
            <p style="font-size: 11px;">
                Period: {{ $dateFrom ? \Carbon\Carbon::parse($dateFrom)->format('M d, Y') : 'Start' }} -
                {{ $dateTo ? \Carbon\Carbon::parse($dateTo)->format('M d, Y') : 'Present' }}
            </p>
        @endif
        <p style="font-size: 10px;">Generated on {{ \Carbon\Carbon::now()->format('F d, Y \a\t g:i A') }}</p>
    </div>

    <div class="patient-info">
        <h2>Patient Information</h2>
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        @if($user->phone)
            <p><strong>Phone:</strong> {{ $user->phone }}</p>
        @endif
        @if($user->dob)
            <p><strong>Date of Birth:</strong> {{ \Carbon\Carbon::parse($user->dob)->format('M d, Y') }}</p>
        @endif
    </div>

    <!-- Appointments Section -->
    <div class="section">
        <h2>Appointments ({{ $appointments->count() }})</h2>
        @if($appointments->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Doctor</th>
                        <th>Type</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->appointment_date->format('M d, Y') }}</td>
                            <td>{{ date('g:i A', strtotime($appointment->start_time)) }}</td>
                            <td>Dr. {{ $appointment->doctor->name }}</td>
                            <td>{{ ucfirst($appointment->appointment_type ?? 'N/A') }}</td>
                            <td>
                                <span class="badge badge-{{ $appointment->status }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </td>
                        </tr>
                        @if($appointment->patient_notes)
                            <tr>
                                <td colspan="5">
                                    <div class="note-box">
                                        <strong>Patient Notes:</strong> {{ $appointment->patient_notes }}
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No appointments found.</p>
        @endif
    </div>

    <!-- Packages Section -->
    <div class="section">
        <h2>Packages Purchased ({{ $purchases->count() }})</h2>
        @if($purchases->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Package</th>
                        <th>Amount</th>
                        <th>Sessions</th>
                        <th>Duration</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($purchases as $purchase)
                        <tr>
                            <td>{{ $purchase->package->title }}</td>
                            <td>NPR {{ number_format($purchase->amount, 2) }}</td>
                            <td>{{ $purchase->selected_option['sessions'] ?? 'N/A' }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($purchase->start_date)->format('M d, Y') }} -
                                {{ \Carbon\Carbon::parse($purchase->end_date)->format('M d, Y') }}
                            </td>
                            <td>
                                <span class="badge badge-{{ $purchase->status }}">
                                    {{ ucfirst($purchase->status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No packages purchased.</p>
        @endif
    </div>

    <!-- Doctor Notes Section -->
    <div class="section">
        <h2>Doctor Notes ({{ $notes->count() }})</h2>
        @if($notes->count() > 0)
            @foreach($notes as $note)
                <div class="note-box" style="margin-bottom: 15px;">
                    <p><strong>{{ $note->title ?: 'Note from Dr. ' . $note->doctor->name }}</strong></p>
                    <p style="font-size: 10px; color: #6b7280;">
                        By Dr. {{ $note->doctor->name }} on {{ $note->created_at->format('M d, Y \a\t g:i A') }}
                        @if($note->category)
                            | Category: {{ $note->category }}
                        @endif
                    </p>
                    <p style="margin-top: 8px; white-space: pre-wrap;">{{ $note->content }}</p>
                </div>
            @endforeach
        @else
            <p>No doctor notes found.</p>
        @endif
    </div>

    <div class="footer">
        <p>This is a confidential medical document. Please keep it secure.</p>
        <p>&copy; {{ date('Y') }} Mental Health and Rehab System. All rights reserved.</p>
    </div>
</body>
</html>
