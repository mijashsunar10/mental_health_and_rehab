{{-- resources/views/emails/panic-alert.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Emergency Panic Alert</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #dc2626;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .alert-icon {
            font-size: 48px;
            margin-bottom: 10px;
        }
        .content {
            padding: 30px;
        }
        .alert-box {
            background-color: #fef2f2;
            border-left: 4px solid #dc2626;
            padding: 15px;
            margin-bottom: 20px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 10px;
            margin-bottom: 20px;
        }
        .info-label {
            font-weight: bold;
            color: #555;
        }
        .info-value {
            color: #333;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 12px;
        }
        .priority {
            background-color: #dc2626;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="alert-icon">🚨</div>
            <h1>EMERGENCY PANIC ALERT</h1>
            <p>Immediate attention required</p>
        </div>
        
        <div class="content">
            <div class="priority">HIGH PRIORITY - EMERGENCY</div>
            
            <div class="alert-box">
                <strong>A panic button has been activated on your website.</strong>
                <br>
                This alert requires immediate attention and investigation.
            </div>
            
            <h3>Alert Details:</h3>
            <div class="info-grid">
                <div class="info-label">User:</div>
                <div class="info-value">{{ $alertData['user_name'] }} ({{ $alertData['user_email'] }})</div>
                
                @if($alertData['user_id'])
                <div class="info-label">User ID:</div>
                <div class="info-value">{{ $alertData['user_id'] }}</div>
                @endif
                
                <div class="info-label">Date & Time:</div>
                <div class="info-value">{{ $alertData['timestamp']->format('Y-m-d H:i:s T') }}</div>
{{--                 
                <div class="info-label">IP Address:</div>
                <div class="info-value">{{ $alertData['ip_address'] }}</div> --}}
                
                <div class="info-label">Current Page:</div>
                <div class="info-value">
                    <a href="{{ $alertData['current_url'] }}">{{ $alertData['current_url'] }}</a>
                </div>
                
                <div class="info-label">Session ID:</div>
                <div class="info-value">{{ $alertData['session_id'] }}</div>
            </div>
            
            <h3>Technical Information:</h3>
            <div class="info-grid">
                <div class="info-label">User Agent:</div>
                <div class="info-value" style="word-break: break-all;">{{ $alertData['user_agent'] }}</div>
            </div>
            
            <div style="margin-top: 30px; padding: 15px; background-color: #fff3cd; border: 1px solid #ffeaa7; border-radius: 4px;">
                <strong>⚠️ Immediate Action Required:</strong>
                <ul style="margin: 10px 0;">
                    <li>Contact the user immediately if possible</li>
                    <li>Check system logs for any related issues</li>
                    <li>Investigate the current page for potential problems</li>
                    <li>Document this incident for security review</li>
                </ul>
            </div>
        </div>
        
        <div class="footer">
            <p>This is an automated emergency alert from {{ config('app.name') }}</p>
            <p>Generated at {{ now()->format('Y-m-d H:i:s T') }}</p>
            <p>Please do not reply to this email. This alert has been logged for security purposes.</p>
        </div>
    </div>
</body>
</html>