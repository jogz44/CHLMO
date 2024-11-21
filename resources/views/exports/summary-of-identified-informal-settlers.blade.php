<table>
    <colgroup>
        <col style="width: 5.11%; word-wrap: break-word; white-space: normal;">
        <col style="width: 9%; word-wrap: break-word; white-space: normal;">
        <col style="width: 13.56%; word-wrap: break-word; white-space: normal;">
        <col style="width: 13.33%; word-wrap: break-word; white-space: normal;">
        <col style="width: 20.44%; word-wrap: break-word; white-space: normal;">
        <col style="width: 22%; word-wrap: break-word; white-space: normal;">
        <col style="width: 12.44%; word-wrap: break-word; white-space: normal;">
        <col style="width: 24.11%; word-wrap: break-word; white-space: normal;">
        <col style="width: 9.67%; word-wrap: break-word; white-space: normal;">
        <col style="width: 34.56%; word-wrap: break-word; white-space: normal;">
        <col style="width: 16.67%; word-wrap: break-word; white-space: normal;">
    </colgroup>

    <!-- Header Section -->
    <!-- Spacing -->
    <tr>
        <td colspan="11" height="81.6"></td>
    </tr>
    <tr>
        <td colspan=11" style="text-align: center; margin-top: 40px; font-size: 9px; font-weight: bold;">
            Republic of the Philippines
        </td>
    </tr>
    <tr>
        <td colspan="11" style="text-align: center; font-size: 9px; font-weight: bold;">
            Province of Davao del Norte
        </td>
    </tr>
    <tr>
        <td colspan="11" style="text-align: center; font-size: 9px; font-weight: bold;">
            City of Tagum
        </td>
    </tr>
    <tr>
        <td colspan="11" style="text-align: center; font-size: 11px; font-weight: bold;">
            CITY HOUSING AND LAND MANAGEMENT OFFICE
        </td>
    </tr>

    <!-- Spacing -->
    <tr>
        <td colspan="11" height="20"></td>
    </tr>

    <!-- Report Title -->
    <tr>
        <td colspan="11" style="text-align: center; font-size: 14px; font-weight: bold;">
            <strong>{{ $title }}</strong>
        </td>
    </tr>
    <tr>
        <td colspan="11" style="text-align: center; font-size: 12px;">
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
        <td colspan="11" height="20"></td>
    </tr>

    <!-- Table Headers -->
    <tr style="background-color: #f3f4f6;">
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px; word-wrap: break-word; white-space: normal;">
            NO.
        </th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px; word-wrap: break-word; white-space: normal;">
            DATE TAGGED
        </th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px; word-wrap: break-word; white-space: normal;">
            BARANGAY
        </th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px; word-wrap: break-word; white-space: normal;">
            PUROK
        </th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px; word-wrap: break-word; white-space: normal;">
            CASE
        </th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px; word-wrap: break-word; white-space: normal;">
            CASE SPECIFICATION
        </th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px; word-wrap: break-word; white-space: normal;">
            NO. OF ACTUAL OCCUPANTS
        </th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px; word-wrap: break-word; white-space: normal;">
            ASSIGNED RELOCATION SITE
        </th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px; word-wrap: break-word; white-space: normal;">
            AWARDED
        </th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px; word-wrap: break-word; white-space: normal;">
            ACTUAL RELOCATION SITE
        </th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px; word-wrap: break-word; white-space: normal;">
            REMARKS
        </th>
    </tr>

    <!-- Table Body -->
    @foreach($taggedAndValidatedApplicants as $taggedAndValidatedApplicant)
        <tr>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">
                {{ $taggedAndValidatedApplicant->row_num }}
            </td>
            <td style="border: 1px solid #000000; padding: 8px;">
                {{ \Carbon\Carbon::parse($taggedAndValidatedApplicant->tagging_date)->format('M d, Y') }}
            </td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">
                {{ $taggedAndValidatedApplicant->barangay }}
            </td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">
                {{ $taggedAndValidatedApplicant->purok }}
            </td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">
                {{ $taggedAndValidatedApplicant->living_situation }}
            </td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">
                {{ $taggedAndValidatedApplicant->case_specification ?? 'N/A' }}
            </td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">
                {{ number_format($taggedAndValidatedApplicant->occupants_count) }}
            </td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">
                {{ $taggedAndValidatedApplicant->assigned_relocation_site ?? 'N/A' }}
            </td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">
                {{ number_format($taggedAndValidatedApplicant->awarded_count) }}
            </td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">
                {{ $taggedAndValidatedApplicant->actual_relocation_sites ?? 'N/A' }}
            </td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">
                {{ $taggedAndValidatedApplicant->remarks ?? 'N/A' }}
            </td>
        </tr>
    @endforeach

    <!-- Spacing -->
    <tr>
        <td colspan="11" height="30"></td>
    </tr>

    <!-- Footer/Signatures -->
    <tr>
        <td colspan="4" style="padding-top: 30px; border: none;">
            Prepared by:
        </td>
    <tr>
        <td colspan="4" style="padding-top: 20px; font-weight: bold; border: none;">
            {{ auth()->user()->first_name }} {{ auth()->user()->middle_name }} {{ auth()->user()->last_name }}
        </td>
    </tr>
    <tr>
        <td colspan="4" style="padding-top: 5px; border: none;">
            {{ auth()->user()->position ?? 'Staff' }}
        </td>
    </tr>
</table>
