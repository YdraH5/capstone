<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Reminder</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
        .amount {
            font-weight: bold;
            color: #e74c3c;
        }
        .footer {
            margin-top: 20px;
            font-size: 0.9em;
            color: #777;
        }
        .due-item {
            margin-bottom: 15px;
        }
        .due-item span {
            display: inline-block;
            width: 150px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Payment Reminder</h1>
        <p>Dear {{ $data['name'] }},</p>
        <p>This is a friendly reminder that you have unpaid rent. Please review the details below:</p>

        @foreach($data['dues'] as $due)
            <div class="due-item">
                <span>Amount Due:</span> ${{ $due['amount'] }}<br>
                <span>Due Date:</span> {{ $due['date'] }}<br>
                <span>Days Overdue:</span> {{  $data['daysOverdue'] }}
            </div>
        @endforeach

        <p>Please make the payment at your earliest convenience to avoid any late fees.</p>
        <p>If you have already made the payment, please disregard this notice.</p>
        <p>Thank you for your attention to this matter.</p>
        <p>Best regards,<br>Your Apartment Management Team</p>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} Your Company Name. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
