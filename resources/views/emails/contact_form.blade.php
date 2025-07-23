<!DOCTYPE html>
<html>
<head>
    <title>New Contact Message</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f9fc;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 82, 204, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #0d47a1, #2196f3);
            color: white;
            padding: 25px 30px;
            text-align: center;
        }
        .header h2 {
            margin: 0;
            font-size: 26px;
            letter-spacing: 0.5px;
        }
        .content {
            padding: 30px;
        }
        .detail-card {
            background: #f0f7ff;
            border-left: 4px solid #2196f3;
            border-radius: 4px;
            padding: 15px 20px;
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }
        .detail-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 8px rgba(33, 150, 243, 0.15);
        }
        .detail-title {
            color: #0d47a1;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }
        .detail-value {
            font-size: 18px;
            color: #333;
            word-break: break-word;
        }
        .message-container {
            background: #e3f2fd;
            border-radius: 8px;
            padding: 20px;
            margin-top: 10px;
            border-top: 1px dashed #90caf9;
        }
        .message-label {
            color: #0d47a1;
            font-weight: bold;
            margin-bottom: 10px;
            display: block;
            font-size: 18px;
        }
        .message-content {
            font-size: 16px;
            line-height: 1.6;
            color: #333;
            white-space: pre-line;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 14px;
            background: #f5f9fc;
            border-top: 1px solid #e0e0e0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Calm Core Recovery</h2>
        </div>
        
        <div class="content">
            <div class="detail-card">
                <div class="detail-title">Name</div>
                <div class="detail-value">{{ $data['name'] }}</div>
            </div>
            
            <div class="detail-card">
                <div class="detail-title">Email</div>
                <div class="detail-value">{{ $data['email'] }}</div>
            </div>
            
            @if (!empty($data['whatsapp']))
            <div class="detail-card">
                <div class="detail-title">Phone Number</div>
                <div class="detail-value">{{ $data['whatsapp'] }}</div>
            </div>
            @endif
            
            <div class="message-container">
                <span class="message-label">Message:</span>
                <div class="message-content">{{ $data['message'] }}</div>
            </div>
        </div>
        
        <div class="footer">
            <p>This message was sent from the Calm Core Recovery contact form</p>
            <p>&copy; {{ date('Y') }} Calm Core Recovery. All rights reserved.</p>
        </div>
    </div>
</body>
</html>