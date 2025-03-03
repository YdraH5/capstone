<!DOCTYPE html>
<html>
<head>
    <title>Rent Price Change Notification</title>
</head>
<body>
    <p>Dear {{ $data['name'] }},</p>

    <p>We hope this message finds you well. We are writing to inform you that the rent price for your apartment category has been updated.</p>

    <p>The new monthly rent is <strong>₱{{ $data['newPrice'] }}</strong>, effective starting from next month.</p>

    <p>If you have any questions or concerns, please feel free to contact us.</p>

    <p>Thank you,<br>{{ $data['updatedBy'] }}</p>
</body>
</html>
