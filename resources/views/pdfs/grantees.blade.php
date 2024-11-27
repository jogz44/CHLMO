<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Shelter Assistance Program Applicants</title>
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

        .header h3,
        .header h2 {
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

        th,
        td {
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
            <span style="font-size: 14px; font-weight: bolder">SHELTER ASSISTANCE PROGRAM APPLICANTS LIST</span>
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

    <div style="margin-top: 25%;">
        <table>
            <thead>
                <tr>
                    <th>Profile No</th>
                    <th>Name</th>
                    <th>Purok</th>
                    <th>Barangay</th>
                    <th>House No/Street</th>
                    <th>Contact No</th>
                    <th>Spouse Name</th>
                    <th>Origin Of Request</th>
                    <th>Social Welfare Sector</th>
                    <th>Date Request</th>
                    <th>Date Profiled/Tagged</th>
                    <th>Delivery Date</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @forelse($grantees as $grantee)
                <tr>
                    <td>{{ $grantee->profiledTaggedApplicant->shelterApplicant->profile_no }}</td>
                    <td>{{ $grantee->profiledTaggedApplicant->shelterApplicant->person->last_name ?? 'N/A' }}, {{ $grantee->profiledTaggedApplicant->shelterApplicant->person->first_name ?? 'N/A' }} {{ $grantee->profiledTaggedApplicant->shelterApplicant->person->middle_name ?? 'N/A' }}</td>
                    <td>{{ $grantee->profiledTaggedApplicant->shelterApplicant->address->barangay->name ?? 'N/A' }}</td>
                    <td>{{ $grantee->profiledTaggedApplicant->shelterApplicant->address->purok->name ?? 'N/A' }}</td>
                    <td>{{ $grantee->profiledTaggedApplicant->full_address ?? 'N/A' }}</td>
                    <td>{{ $grantee->profiledTaggedApplicant->contact_number ?? 'N/A' }}</td>
                    <td>
                        @if($grantee->profiledTaggedApplicant->spouse)
                        {{ $grantee->profiledTaggedApplicant->spouse->last_name ?? 'N/A' }},
                        {{ $grantee->profiledTaggedApplicant->spouse->first_name ?? 'N/A' }}
                        {{ $grantee->profiledTaggedApplicant->spouse->middle_name ?? '' }}
                        @else
                        N/A
                        @endif
                    </td>
                    <td>{{ $grantee->profiledTaggedApplicant->shelterApplicant->originOfRequest->name ?? 'N/A' }}</td>
                    <td>{{ $grantee->profiledTaggedApplicant->governmentProgram->program_name ?? 'N/A' }}</td>
                    <td> {{ $grantee->profiledTaggedApplicant->shelterApplicant->date_request->format('Y-m-d') }}</td>
                    <td>{{ optional($grantee->profiledTaggedApplicant)->date_tagged ? $grantee->profiledTaggedApplicant->date_tagged->format('Y-m-d') : '' }}</td>
                    <td>{{ $grantee->date_of_delivery ? $grantee->date_of_delivery->format('Y-m-d') : '' }}</td>
                    <td>{{ $grantee->profiledTaggedApplicant->remarks ?? 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>