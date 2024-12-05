<table>
    <!-- Spacing -->
    <tr>
        <td colspan="6" height="20"></td>
    </tr>
    <tr>
        <td colspan="6" style="text-align: center; margin-top: 40px; font-size: 11px; font-weight: bold;">
            Republic of the Philippines
        </td>
    </tr>
    <tr>
        <td colspan="6" style="text-align: center; font-size: 11px; font-weight: bold;">
            Province of Davao del Norte
        </td>
    </tr>
    <tr>
        <td colspan="6" style="text-align: center; font-size: 11px; font-weight: bold;">
            CITY OF TAGUM
        </td>
    </tr>
    <tr>
        <td colspan="6"></td>
    </tr>
    <tr>
        <td colspan="6" style="text-align: center; font-size: 9px; font-weight: bold;">
            OFFICE OF THE CITY HOUSING AND LAND MANAGEMENT OFFICER
        </td>
    </tr>
    <tr>
        <td colspan="6" style="text-align: center; font-size: 9px; font-weight: regular;">
            2/F Annex Building, City Government, J.V. Ayala Ave., Barangay Apokon, Tagum City
        </td>
    </tr>
    <tr>
        <td colspan="6" style="text-align: center; font-size: 9px; font-weight: regular;">
            Telephone No. (9) 216 - 9367 Local 141
        </td>

        <!-- Spacing -->
    <tr style="border-bottom: 4px solid #000;">
        <td colspan="6" height="10"></td>
    </tr>
    <tr style="border-bottom: 4px solid #000;">
        <td colspan="6" height="20"></td>
    </tr>

    <tr>
        <td colspan="6" style="text-align: center; font-size: 14px; font-weight: bold;">
            <strong>{{ $title ?? 'SHELTER ASSISTANCE PROGRAM APPLICANTS LIST' }}</strong>
        </td>
    </tr>
    <tr>
        <td colspan="6" style="text-align: center; font-size: 12px;">
            @if(!empty($subtitle))
                @foreach($subtitle as $line)
                    {{ $line }}<br>
                @endforeach
            @endif
            As of {{ now()->format('F d, Y') }}
        </td>
    </tr>
    <!-- Spacing -->
    <tr>
        <td colspan="6" height="20"></td>
    </tr>
    <!-- Table Headers -->
    <tr style="background-color: #f3f4f6;">
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">Profile No</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">Name</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">Purok</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">Barangay</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">Origin Of Request</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">Date Request</th>
    </tr>

     <!-- Table Body -->
     @foreach($shelterApplicants as $applicant)
        <tr>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">{{ $applicant->profile_no }}</td>
            <td style="border: 1px solid #000000; padding: 8px;">{{ optional($applicant->person)->full_name }}</td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">{{ optional($applicant->address->purok)->name ?? 'N/A' }}</td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">{{ optional($applicant->address->barangay)->name ?? 'N/A' }}</td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">{{ optional($applicant->originOfRequest)->name ?? 'N/A' }}</td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">{{ $applicant->date_request ? \Carbon\Carbon::parse($applicant->date_request)->format('m/d/Y') : 'N/A' }}</td>
        </tr>
    @endforeach

     <!-- Spacing -->
     <tr>
        <td colspan="6" height="30"></td>
    </tr>

    <!-- Footer/Signatures -->
    <tr>
        <td colspan="3" style="padding-top: 30px;">
            Prepared by:
        </td>
        <td colspan="3" style="padding-top: 30px;">
            Noted by:
        </td>
    </tr>
</table>