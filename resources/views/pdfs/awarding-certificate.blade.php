<!DOCTYPE html>
<html>
<head>
    <title>Award Certificate</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            text-align: center;
            padding: 50px;
        }
        .certificate-header {
            font-size: 24px;
            margin-bottom: 30px;
        }
        .certificate-details {
            margin-top: 30px;
        }
    </style>
</head>
<body>
<div class="certificate-header">
    <h1>Award Certificate</h1>
</div>
<div class="certificate-details">
    <p>This is to certify that</p>
    <h2>{{ $applicant->full_name }}</h2>
    <p>Has been awarded a relocation lot</p>
    <p>Lot Size: {{ $awardee->lot_size }} {{ $awardee->unit }}</p>
    <p>Grant Date: {{ $awardee->grant_date->format('F d, Y') }}</p>
</div>
</body>
</html>