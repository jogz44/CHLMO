<table>
    <!-- Header Section -->
    <!-- Spacing -->
    <tr>
        <td colspan="8" height="81.6"></td>
    </tr>
    <tr>
        <td colspan="8" style="text-align: center; margin-top: 40px; font-size: 16px; font-weight: bold;">
            Republic of the Philippines
        </td>
    </tr>
    <tr>
        <td colspan="8" style="text-align: center; font-size: 16px; font-weight: bold;">
            Province of Davao del Norte
        </td>
    </tr>
    <tr>
        <td colspan="8" style="text-align: center; font-size: 16px; font-weight: bold;">
            City of Tagum
        </td>
    </tr>
    <tr>
        <td colspan="8" style="text-align: center; font-size: 20px; font-weight: bold;">
            CITY HOUSING AND LAND MANAGEMENT OFFICE
        </td>
    </tr>

    <!-- Spacing -->
    <tr>
        <td colspan="8" height="20"></td>
    </tr>

    <!-- Report Title -->
    <tr>
        <td colspan="8" style="text-align: center; font-size: 14px; font-weight: bold;">
            HOUSING APPLICANTS LIST
        </td>
    </tr>
    <tr>
        <td colspan="8" style="text-align: center; font-size: 12px;">
            As of {{ now()->format('F d, Y') }}
        </td>
    </tr>

    <!-- Spacing -->
    <tr>
        <td colspan="8" height="20"></td>
    </tr>

    <!-- Table Headers -->
    <tr style="background-color: #f3f4f6;">
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">ID</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">Name</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">Suffix</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">Contact Number</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">Purok</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">Barangay</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">Transaction Type</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">Date Applied</th>
    </tr>

    <!-- Table Body -->
    @foreach($applicants as $applicant)
        <tr>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">{{ $applicant->applicant_id }}</td>
            <td style="border: 1px solid #000000; padding: 8px;">{{ optional($applicant->person)->full_name }}</td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">{{ optional($applicant->person)->suffix_name }}</td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">{{ optional($applicant->person)->contact_number }}</td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">{{ optional($applicant->address->purok)->name ?? 'N/A' }}</td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">{{ optional($applicant->address->barangay)->name ?? 'N/A' }}</td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">{{ optional($applicant->transactionType)->type_name ?? 'N/A' }}</td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">{{ $applicant->date_applied ? \Carbon\Carbon::parse($applicant->date_applied)->format('m/d/Y') : 'N/A' }}</td>
        </tr>
    @endforeach

    <!-- Spacing -->
    <tr>
        <td colspan="8" height="30"></td>
    </tr>

    <!-- Footer/Signatures -->
    <tr>
        <td colspan="4" style="padding-top: 30px;">
            Prepared by:
        </td>
        <td colspan="4" style="padding-top: 30px;">
            Noted by:
        </td>
    </tr>
    <tr>
        <td colspan="4" style="padding-top: 20px; font-weight: bold;">
            {{ auth()->user()->first_name }} {{ auth()->user()->middle_name }} {{ auth()->user()->last_name }}
        </td>
        <td colspan="4" style="padding-top: 20px; font-weight: bold;">
            ____________________
        </td>
    </tr>
    <tr>
        <td colspan="4" style="padding-top: 5px;">
            {{ auth()->user()->position ?? 'Staff' }}
        </td>
        <td colspan="4" style="padding-top: 5px;">
            Department Head
        </td>
    </tr>
</table>