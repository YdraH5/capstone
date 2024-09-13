<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Confirmation</title>
    <style>
        /* Basic styling for the email */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header-image {
            width: 100%;
            height: auto;
            border-radius: 8px 8px 0 0;
        }
        .content {
            padding: 20px;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header Image -->
        <img src="header-image-url.jpg" alt="Welcome to NRN Building" class="header-image">
        
        <div class="content">
            <!-- Email Content -->
            <p>Dear {{$data['name']}},</p>
            <p>Thank you for choosing NRN Building as your new home. We are pleased to inform you that we have received your payment of ₱{{$data['payment']}}, and your reservation has been successfully processed.</p>
            <p>We look forward to welcoming you to your new space and are excited to have you as part of our community.</p>
            <p>If you have any questions or need further assistance, please do not hesitate to contact us.</p>
            <p>Warm regards,</p>
            <p><strong>NRN Building Management Team</strong><br>
               [Contact Information]<br>
               [Website]</p>
        </div>

        <!-- Optional Footer -->
        <div class="footer">
            &copy; 2024 NRN Building. All rights reserved.
        </div>
    </div>
</body>
</html>
