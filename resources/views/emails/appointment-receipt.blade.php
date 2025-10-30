<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(to right, #2563eb, #1d4ed8);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .content {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-top: none;
            padding: 30px;
        }
        .success-badge {
            background: #10b981;
            color: white;
            padding: 10px 20px;
            border-radius: 50px;
            display: inline-block;
            font-weight: bold;
            margin: 20px 0;
        }
        .info-section {
            background: #f9fafb;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .info-section h3 {
            margin-top: 0;
            color: #1f2937;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 10px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: 600;
            color: #6b7280;
        }
        .value {
            color: #1f2937;
        }
        .payment-summary {
            background: #eff6ff;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .total-amount {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
            text-align: right;
        }
        .button {
            display: inline-block;
            background: #2563eb;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #6b7280;
            font-size: 14px;
            border-top: 1px solid #e5e7eb;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Payment Successful!</h1>
        <p>Your appointment has been confirmed</p>
        <div class="success-badge">✓ PAID</div>
    </div>

    <div class="content">
        <p>Dear {{ $appointment->patient->name }},</p>

        <p>Thank you for your payment. Your appointment with <strong>{{ $appointment->doctor->name }}</strong> has been confirmed.</p>

        <div class="info-section">
            <h3>Appointment Details</h3>
            <div class="info-row">
                <span class="label">Date:</span>
                <span class="value">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, F d, Y') }}</span>
            </div>
            <div class="info-row">
                <span class="label">Time:</span>
                <span class="value">
                    {{ \Carbon\Carbon::parse($appointment->start_time)->format('g:i A') }} -
                    {{ \Carbon\Carbon::parse($appointment->end_time)->format('g:i A') }}
                </span>
            </div>
            <div class="info-row">
                <span class="label">Type:</span>
                <span class="value">{{ ucfirst($appointment->appointment_type) }} {{ $appointment->appointment_type === 'physical' ? 'Visit' : 'Call' }}</span>
            </div>
            <div class="info-row">
                <span class="label">Doctor:</span>
                <span class="value">{{ $appointment->doctor->name }}</span>
            </div>
        </div>

        <div class="info-section">
            <h3>Payment Information</h3>
            <div class="info-row">
                <span class="label">Receipt Number:</span>
                <span class="value">#{{ $appointment->id }}</span>
            </div>
            <div class="info-row">
                <span class="label">Transaction ID:</span>
                <span class="value">{{ $appointment->transaction_id }}</span>
            </div>
            <div class="info-row">
                <span class="label">Payment Date:</span>
                <span class="value">{{ $appointment->payment_date->format('M d, Y g:i A') }}</span>
            </div>
            <div class="info-row">
                <span class="label">Payment Method:</span>
                <span class="value">Khalti</span>
            </div>
        </div>

        <div class="payment-summary">
            <div class="info-row">
                <span class="label">Consultation Fee:</span>
                <span class="value">Rs. {{ number_format($appointment->payment_amount, 2) }}</span>
            </div>
            <hr style="border: none; border-top: 2px solid #2563eb; margin: 15px 0;">
            <div class="info-row">
                <span class="label" style="font-size: 18px;">Total Paid:</span>
                <span class="total-amount">Rs. {{ number_format($appointment->payment_amount, 2) }}</span>
            </div>
        </div>

        @if($appointment->patient_notes)
        <div class="info-section">
            <h3>Reason for Visit</h3>
            <p style="margin: 10px 0;">{{ $appointment->patient_notes }}</p>
        </div>
        @endif

        <div style="text-align: center;">
            <a href="{{ route('appointment.receipt', ['appointment' => $appointment->id]) }}" class="button">
                View Full Receipt
            </a>
        </div>

        <p style="margin-top: 30px;">If you have any questions or need to make changes to your appointment, please contact us.</p>

        <p>Best regards,<br>
        <strong>Mental Health & Rehab Team</strong></p>
    </div>

    <div class="footer">
        <p>This is an automated email. Please do not reply to this message.</p>
        <p>&copy; {{ date('Y') }} Mental Health & Rehab. All rights reserved.</p>
    </div>
</body>
</html>
