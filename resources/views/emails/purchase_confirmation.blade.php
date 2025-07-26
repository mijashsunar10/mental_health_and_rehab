<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Confirmation</title>
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
            background-color: #3b82f6;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            padding: 20px;
            background-color: #f9fafb;
            border-radius: 0 0 8px 8px;
            border: 1px solid #e5e7eb;
            border-top: none;
        }
        h1 {
            color: #1e40af;
            margin-top: 0;
        }
        h2 {
            color: #1e40af;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 8px;
        }
        ul {
            padding-left: 20px;
        }
        li {
            margin-bottom: 8px;
        }
        .footer {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            font-size: 14px;
            color: #6b7280;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3b82f6;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Thank you for your purchase!</h1>
    </div>
    
    <div class="content">
        <p>Your order #{{ $order->id }} has been confirmed.</p>

        <h2>Order Details:</h2>
        <ul>
            <li><strong>Package:</strong> {{ $order->package->title }}</li>
            <li><strong>Option:</strong> {{ $order->package->options[$order->option_index]['name'] }}</li>
            <li><strong>Amount:</strong> ${{ number_format($order->amount, 2) }}</li>
            <li><strong>Payment Reference:</strong> {{ $order->payment_reference }}</li>
            <li><strong>Date:</strong> {{ $order->created_at->format('F j, Y') }}</li>
        </ul>

        <p>We've received your payment and your treatment package is now active.</p>
        
        <h2>Next Steps:</h2>
        <ul>
            <li>You will receive a separate email with login instructions</li>
            <li>Our support team will contact you within 24 hours</li>
            <li>Check your spam folder if you don't see our emails</li>
        </ul>

        <div class="footer">
            <p>If you have any questions, please contact our support team at <a href="mailto:support@example.com">support@example.com</a> or call us at +1 (555) 123-4567.</p>
            <p>Thank you for choosing our services!</p>
        </div>
    </div>
</body>
</html>