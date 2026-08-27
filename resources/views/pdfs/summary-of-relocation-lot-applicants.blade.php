<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Summary of Relocation Lot Applicants</title>
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
        td.sub-row {
            padding-left: 24px;
            font-style: italic;
        }
        tr.total-row td {
            font-weight: bold;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('storage/images/housing_logo.png') }}"
             alt="Logo" style="width: 100px; height: 100px;">
        <p>
            <span style="font-size: 10px;">REPUBLIC OF THE PHILIPPINES</span> <br>
            <span style="font-size: 10px;">PROVINCE OF DAVAO DEL NORTE</span> <br>
            <span style="font-size: 10px;">CITY OF TAGUM</span> <br>
            <span style="font-size: 12px;">CITY HOUSING AND LAND MANAGEMENT SYSTEM</span> <br>
            <span style="font-size: 14px; font-weight: bolder">SUMMARY OF RELOCATION LOT APPLICANTS</span>
        </p>
        <p style="font-size: 10px;">As of {{ now()->format('F d, Y') }}</p>
    </div>

    <div class="footer">
        <div class="page-number"></div>
    </div>

    <div style="margin-top: 35%;">
        <table>
            <thead>
                <tr>
                    <th>Relocation Lot Applicants</th>
                    <th>No. of Applicants</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>WALK-IN APPLICANTS</td>
                    <td>{{ $walkInApplicants }}</td>
                </tr>
                <tr>
                    <td class="sub-row">Tagged</td>
                    <td>{{ $taggedWalkInApplicants }}</td>
                </tr>
                <tr>
                    <td class="sub-row">Untagged</td>
                    <td>{{ $untaggedWalkInApplicants }}</td>
                </tr>

                <tr>
                    <td>TAGGED &amp; VALIDATED</td>
                    <td>{{ $totalTaggedValidated }}</td>
                </tr>
                <tr>
                    <td class="sub-row">Informal Settlers</td>
                    <td>{{ $informalSettlers }}</td>
                </tr>
                <tr>
                    <td class="sub-row">Non-informal Settlers</td>
                    <td>{{ $nonInformalSettlers }}</td>
                </tr>

                <tr>
                    <td>IDENTIFIED INFORMAL SETTLERS</td>
                    <td>{{ $totalInformalSettlers }}</td>
                </tr>
                <tr>
                    <td class="sub-row">Awarded</td>
                    <td>{{ $awardedInformalSettlers }}</td>
                </tr>
                <tr>
                    <td class="sub-row">Non-awarded</td>
                    <td>{{ $nonAwardedInformalSettlers }}</td>
                </tr>

                <tr class="total-row">
                    <td>TOTAL NUMBER OF RELOCATION LOT APPLICANTS</td>
                    <td>{{ $totalRelocationLotApplicants }}</td>
                </tr>
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            <h5 style="text-align: center; font-size: 13px; margin-bottom: 4px;">INFORMAL SETTLERS CLASSIFICATION</h5>
            <p style="font-size: 9px; font-weight: bold; margin-bottom: 6px;">
                NOTE: THE FOLLOWING CASES ARE CLASSIFIED AS INFORMAL SETTLERS
            </p>
            <ul style="padding-left: 18px; margin: 0;">
                @foreach ($informalSettlersCases as $case)
                    <li style="font-size: 9px; margin-bottom: 3px;">{{ $case }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</body>
</html>