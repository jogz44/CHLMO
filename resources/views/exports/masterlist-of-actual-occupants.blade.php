<table>
    <colgroup>
        <col style="width: 15.56%; word-wrap: break-word; white-space: normal;">
        <col style="width: 36.89%; word-wrap: break-word; white-space: normal;">
        <col style="width: 4.22%; word-wrap: break-word; white-space: normal;">
        <col style="width: 14.67%; word-wrap: break-word; white-space: normal;">
        <col style="width: 9.67%; word-wrap: break-word; white-space: normal;">
        <col style="width: 10.89%; word-wrap: break-word; white-space: normal;">
        <col style="width: 10.11%; word-wrap: break-word; white-space: normal;">
        <col style="width: 10.78%; word-wrap: break-word; white-space: normal;">
        <col style="width: 11.78%; word-wrap: break-word; white-space: normal;">
        <col style="width: 15.67%; word-wrap: break-word; white-space: normal;">
        <col style="width: 19.22%; word-wrap: break-word; white-space: normal;">
        <col style="width: 8.89%; word-wrap: break-word; white-space: normal;">
        <col style="width: 33.22%; word-wrap: break-word; white-space: normal;">
        <col style="width: 11.89%; word-wrap: break-word; white-space: normal;">
        <col style="width: 10.56%; word-wrap: break-word; white-space: normal;">
        <col style="width: 12%; word-wrap: break-word; white-space: normal;">
        <col style="width: 9.22%; word-wrap: break-word; white-space: normal;">
        <col style="width: 10.33%; word-wrap: break-word; white-space: normal;">
        <col style="width: 11.78%; word-wrap: break-word; white-space: normal;">
        <col style="width: 26.22%; word-wrap: break-word; white-space: normal;">
    </colgroup>

    <!-- Header Section -->
    <!-- Spacing -->
    <tr>
        <td colspan="20" height="81.6"></td>
    </tr>
    <tr>
        <td colspan="20" style="text-align: center; margin-top: 40px; font-size: 16px; font-weight: bold;">
            Republic of the Philippines
        </td>
    </tr>
    <tr>
        <td colspan="20" style="text-align: center; font-size: 16px; font-weight: bold;">
            Province of Davao del Norte
        </td>
    </tr>
    <tr>
        <td colspan="20" style="text-align: center; font-size: 16px; font-weight: bold;">
            City of Tagum
        </td>
    </tr>
    <tr>
        <td colspan="20" style="text-align: center; font-size: 20px; font-weight: bold;">
            CITY HOUSING AND LAND MANAGEMENT OFFICE
        </td>
    </tr>

    <!-- Spacing -->
    <tr>
        <td colspan="20" height="20"></td>
    </tr>

    <!-- Report Title -->
    <tr>
        <td colspan="20" style="text-align: center; font-size: 14px; font-weight: bold;">
            <strong>{{ $title ?? 'MASTERLIST OF ACTUAL OCCUPANTS' }}</strong>
        </td>
    </tr>
    <tr>
        <td colspan="20" style="text-align: center; font-size: 12px;">
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
        <td colspan="20" height="20"></td>
    </tr>

    <!-- Table Headers -->
    <tr style="background-color: #f3f4f6;">
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">ID</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">PRINCIPAL NAME</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">AGE</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">OCCUPATION</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">MONTHLY INCOME</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">MARITAL STATUS</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">BARANGAY</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">PUROK</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">DATE TAGGED</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">LIVING SITUATION</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">LIVING SITUATION (CASE SPECIFICATION)</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">LIVING STATUS</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">SPOUSE</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">OCCUPATION</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">MONTHLY INCOME</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">NO. OF DEPENDENTS</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">FAMILY INCOME</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">LENGTH OF RESIDENCY (YEARS)</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">CONTACT NUMBER</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">REMARKS</th>
    </tr>

    <!-- Table Body -->
    @foreach($applicants as $applicant)
        <tr>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">{{ $applicant->applicant->applicant_id ?? 'N/A' }}</td>
            <td style="border: 1px solid #000000; padding: 8px;">
                {{ $applicant->applicant->person->last_name ?? 'N/A' }}, {{ $applicant->applicant->person->first_name ?? 'N/A' }} {{ $applicant->applicant->person->middle_name ?? 'N/A' }}
            </td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">{{ $applicant->date_of_birth ? $applicant->date_of_birth->age : 'N/A' }}</td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">{{ $applicant->occupation ?? 'N/A' }}</td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">{{ number_format($applicant->monthly_income, 2) }}</td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">{{ $applicant->civilStatus->civil_status ?? 'N/A' }}</td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">{{ $applicant->applicant->address->barangay->name ?? 'N/A' }}</td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">{{ $applicant->applicant->address->purok->name ?? 'N/A' }}</td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">{{ $applicant->tagging_date->format('m/d/Y') }}</td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">{{ $applicant->livingSituation->living_situation_description ?? 'N/A' }}</td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">
                @if($applicant->livingSituation->id == 8)
                    {{ $applicant->caseSpecification->case_specification_name ?? 'N/A' }}
                @else
                    {{ $applicant->living_situation_case_specification ?? 'N/A' }}
                @endif
            </td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">{{ $applicant->livingStatus->living_status_name ?? 'N/A' }}</td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">
                @if ($applicant->civil_status_id == 3) <!-- Married -->
                {{ $applicant->spouse->spouse_first_name ?? '' }}
                {{ $applicant->spouse->spouse_middle_name ?? '' }}
                {{ $applicant->spouse->spouse_last_name ?? '' }}
                @elseif ($applicant->civil_status_id == 2) <!-- Live-in -->
                {{ $applicant->liveInPartner->partner_first_name ?? '' }}
                {{ $applicant->liveInPartner->partner_middle_name ?? '' }}
                {{ $applicant->liveInPartner->partner_last_name ?? '' }}
                @else
                    N/A
                @endif
            </td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">
                @if ($applicant->civil_status_id == 3) <!-- Married -->
                {{ $applicant->spouse->spouse_occupation ?? '' }}
                @elseif ($applicant->civil_status_id == 2) <!-- Live-in -->
                {{ $applicant->liveInPartner->partner_occupation ?? '' }}
                @else
                    N/A
                @endif
            </td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">
                @if ($applicant->civil_status_id == 3) <!-- Married -->
                {{ $applicant->spouse->spouse_monthly_income ? number_format($applicant->spouse->spouse_monthly_income, 2) : 'N/A' }}
                @elseif ($applicant->civil_status_id == 2) <!-- Live-in -->
                {{ $applicant->liveInPartner->partner_monthly_income ? number_format($applicant->liveInPartner->partner_monthly_income, 2) : 'N/A' }}
                @else
                    N/A
                @endif
            </td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">
                {{ $applicant->dependents->count() }}
            </td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">
                @if ($applicant->civil_status_id == 3) <!-- Married -->
                {{ number_format(($applicant->monthly_income ?? 0) + ($applicant->spouse->spouse_monthly_income ?? 0), 2) }}
                @elseif ($applicant->civil_status_id == 2) <!-- Live-in -->
                {{ number_format(($applicant->monthly_income ?? 0) + ($applicant->liveInPartner->partner_monthly_income ?? 0), 2) }}
                @else
                    N/A
                @endif
            </td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">
                {{ $applicant->years_of_residency }}
            </td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">
                {{ $applicant->applicant->person->contact_number ?? 'N/A' }}
            </td>
            <td style="border: 1px solid #000000; text-align: center; padding: 8px;">
                {{ $applicant->remarks ?? 'N/A' }}
            </td>
        </tr>
    @endforeach

    <!-- Spacing -->
    <tr>
        <td colspan="20" height="30"></td>
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