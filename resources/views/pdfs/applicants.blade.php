<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Housing Applicants</title>
    <style>
        @page {
            margin: 100px 25px;
        }
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 0;
        }
        .header {
            position: fixed;
            top: -60px;
            left: 0;
            right: 0;
            text-align: center;
        }
        .header img {
            width: 60px;
            height: auto;
        }
        .header h3, .header h2 {
            margin: 5px 0;
        }
        .footer {
            position: fixed;
            bottom: -60px;
            left: 0;
            right: 0;
            width: 100%;
            text-align: right;
            font-size: 10px;
        }
        .footer .page-number:after {
            content: "Page " counter(page) " of " counter(pages);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .subtitle {
            font-size: 12px;
            margin-bottom: 10px;
        }
        .signatures {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }
        .signature-block {
            float: left;
            width: 45%;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="header">
    <img src="{{ public_path('storage/images/housing_logo.png') }}"
         alt="Logo" style="width: 100px; height: 100px;">
    <p>
        <span style="font-size: 10px;">Republic of the Philippines</span> <br>
        <span style="font-size: 10px;">Province of Davao del Norte</span> <br>
        <span style="font-size: 10px;">City of Tagum</span> <br>
        <span style="font-size: 12px;">CITY HOUSING AND LAND MANAGEMENT SYSTEM</span> <br>
        <span style="font-size: 14px; font-weight: bolder">HOUSING APPLICANTS LIST</span>
    </p>

    @if(!empty($subtitle))
        <div class="subtitle">
            {{ $subtitle }}
        </div>
    @endif

    <p style="font-size: 10px;">As of {{ now()->format('F d, Y') }}</p>
</div>

<div class="footer">
    <div class="page-number"></div>
</div>

<div style="margin-top: 30%;">
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Suffix</th>
            <th>Contact Number</th>
            <th>Purok</th>
            <th>Barangay</th>
            <th>Transaction Type</th>
            <th>Date Applied</th>
        </tr>
        </thead>
        <tbody>
        @foreach($applicants as $applicant)
            <tr>
                <td>{{ $applicant->applicant_id }}</td>
                <td>{{ $applicant->person->full_name }}</td>
                <td>{{ $applicant->person->suffix_name }}</td>
                <td>{{ $applicant->person->contact_number }}</td>
                <td>{{ $applicant->address->purok->name }}</td>
                <td>{{ $applicant->address->barangay->name }}</td>
                <td>{{ $applicant->transactionType->type_name }}</td>
                <td>{{ $applicant->date_applied->format('m/d/Y') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
