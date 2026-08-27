<table>
    <!-- Spacing -->
    <tr>
        <td colspan="8" height="20"></td>
    </tr>
    <tr>
        <td colspan="8" style="text-align: center; margin-top: 40px; font-size: 11px; font-weight: bold;">
            Republic of the Philippines
        </td>
    </tr>
    <tr>
        <td colspan="8" style="text-align: center; font-size: 11px; font-weight: bold;">
            Province of Davao del Norte
        </td>
    </tr>
    <tr>
        <td colspan="8" style="text-align: center; font-size: 11px; font-weight: bold;">
            CITY OF TAGUM
        </td>
    </tr>
    <tr>
        <td colspan="8"></td>
    </tr>
    <tr>
        <td colspan="8" style="text-align: center; font-size: 9px; font-weight: bold;">
            OFFICE OF THE CITY HOUSING AND LAND MANAGEMENT OFFICER
        </td>
    </tr>
    <tr>
        <td colspan="8" style="text-align: center; font-size: 9px; font-weight: regular;">
            2/F Annex Building, City Government, J.V. Ayala Ave., Barangay Apokon, Tagum City
        </td>
    </tr>
    <tr>
        <td colspan="8" style="text-align: center; font-size: 9px; font-weight: regular;">
            Telephone No. (9) 216 - 9367 Local 141
        </td>
    </tr>

        <!-- Spacing -->
    <tr style="border-bottom: 4px solid #000;">
        <td colspan="8" height="10"></td>
    </tr>
    <tr style="border-bottom: 4px solid #000;">
        <td colspan="8" height="20"></td>
    </tr>

    <!-- Report Title -->
    <tr>
        <td colspan="8" style="text-align: center; font-size: 14px; font-weight: bold;">
            <strong>{{ $title ?? 'HOUSING APPLICANTS LIST' }}</strong>
        </td>
    </tr>
    <tr>
        <td colspan="8" style="text-align: center; font-size: 12px;">
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
        <tr style="background-color: {{ $applicant->is_tagged ? '#E8F5E9' : '#FFEBEE' }}">
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
        <td colspan="8" height="20"></td>
    </tr>

    <!-- Totals Summary -->
    <tr>
        <td colspan="8" style="padding: 8px; text-align: right; font-weight: bold;">
            Total Walk-in: {{ $applicants->count() }} |
            Tagged: {{ $applicants->where('is_tagged', true)->count() }} |
            Untagged: {{ $applicants->where('is_tagged', false)->count() }}
        </td>
    </tr>

    <!-- Color Legend -->
{{--    <tr>--}}
{{--        <td colspan="8" height="20"></td>--}}
{{--    </tr>--}}
{{--    <tr>--}}
{{--        <td colspan="8" style="padding: 8px; font-weight: bold;">Color Legend:</td>--}}
{{--    </tr>--}}
{{--    <tr style="background-color: #E8F5E9">--}}
{{--        <td colspan="8" style="padding: 8px;">Tagged Applicants</td>--}}
{{--    </tr>--}}
{{--    <tr style="background-color: #FFEBEE">--}}
{{--        <td colspan="8" style="padding: 8px;">Untagged Applicants</td>--}}
{{--    </tr>--}}

    <!-- Spacing -->
{{--    <tr>--}}
{{--        <td colspan="8" height="30"></td>--}}
{{--    </tr>--}}

</table>