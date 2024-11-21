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
                    <td>Tagged and Validated</td>
                    <td>{{ $taggedAndValidated }}</td>
                </tr>
                <tr>
                    <td>Identified Informal Settlers</td>
                    <td>{{ $identifiedInformalSettlers }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td> <!-- SPACING -->
                </tr>
                <tr>
                    <td>Total Number Relocation Lot Applicants</td>
                    <td>{{ $totalRelocationLotApplicants }}</td>
                </tr>
            </tbody>
        </table>

        <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
            <h5 class="text-xl font-bold text-center">INFORMAL SETTLERS CLASSIFICATION</h5>
            <h6>
                NOTE: THE FOLLOWING CASES ARE CLASSIFIED AS INFORMAL SETTLERS
            </h6>
            <ul class="space-y-3 pl-6 list-disc text-gray-700">
                <li style="font-size: 9px;">AFFECTED BY GOVERNMENT INFRASTRUCTURE</li>
                <li style="font-size: 9px;">GOVERNMENT PROPERTIES</li>
                <li style="font-size: 9px;">WITH COURT ORDER FOR DEMOLITION AND EVICTION</li>
                <li style="font-size: 9px;">WITH NOTICE TO VACATE</li>
                <li style="font-size: 9px;">PRIVATE PROPERTIES</li>
                <li style="font-size: 9px;">PRIVATE CONSTRUCTION PROJECTS</li>
                <li style="font-size: 9px;">ALIENABLE AND DISPOSABLE LAND</li>
                <li style="font-size: 9px;">
                    DANGER ZONE: ACCRETION AREA, LANDSLIDE PRONE AREA, IDENTIFIED FLOOD PRONE AREA,
                    NPC LINE, ALONG THE CREEK, ALONG THE RIVER, ETC.
                </li>
                <li style="font-size: 9px;">AND OTHER CASES</li>
            </ul>
        </div>
    </div>
</body>
</html>
