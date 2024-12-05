<table>
    <!-- Spacing -->
    <tr>
        <td colspan="13" height="20"></td>
    </tr>
    <tr>
        <td colspan="13" style="text-align: center; margin-top: 40px; font-size: 11px; font-weight: bold;">
            Republic of the Philippines
        </td>
    </tr>
    <tr>
        <td colspan="13" style="text-align: center; font-size: 11px; font-weight: bold;">
            Province of Davao del Norte
        </td>
    </tr>
    <tr>
        <td colspan="13" style="text-align: center; font-size: 11px; font-weight: bold;">
            CITY OF TAGUM
        </td>
    </tr>
    <tr>
        <td colspan="13"></td>
    </tr>
    <tr>
        <td colspan="13" style="text-align: center; font-size: 9px; font-weight: bold;">
            OFFICE OF THE CITY HOUSING AND LAND MANAGEMENT OFFICER
        </td>
    </tr>
    <tr>
        <td colspan="13" style="text-align: center; font-size: 9px; font-weight: regular;">
            2/F Annex Building, City Government, J.V. Ayala Ave., Barangay Apokon, Tagum City
        </td>
    </tr>
    <tr>
        <td colspan="13" style="text-align: center; font-size: 9px; font-weight: regular;">
            Telephone No. (9) 216 - 9367 Local 141
        </td>

        <!-- Spacing -->
    <tr style="border-bottom: 4px solid #000;">
        <td colspan="13" height="10"></td>
    </tr>
    <tr style="border-bottom: 4px solid #000;">
        <td colspan="13" height="20"></td>
    </tr>

    <tr>
        <td colspan="13" style="text-align: center; font-size: 14px; font-weight: bold;">
            <strong>{{ $title ?? 'SHELTER ASSISTANCE PROGRAM GRANTEES LIST' }}</strong>
        </td>
    </tr>
    <tr>
        <td colspan="13" style="text-align: center; font-size: 12px;">
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
        <td colspan="13" height="20"></td>
    </tr>

    <!-- Table Headers -->
    <tr style="background-color: #f3f4f6;">
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">Profile No</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">Name</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">Purok</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">Barangay</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">House No/Street</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">Contact No</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">Spouse Name</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">Origin Of Request</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">Social Welfare Sector</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">Date Request</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">Date Profiled/Tagged</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">Delivery Date</th>
        <th style="border: 1px solid #000000; font-weight: bold; text-align: center; padding: 10px;">Remarks</th>
    </tr>

    @forelse($grantees as $grantee)
    <tr>
        <td class="py-4 px-2 text-center border-b whitespace-nowrap">{{ $grantee->profiledTaggedApplicant->shelterApplicant->profile_no }}</td>
        <td class="py-4 px-2 text-center capitalize border-b whitespace-nowrap">{{ $grantee->profiledTaggedApplicant->shelterApplicant->person->last_name ?? 'N/A' }}, {{ $grantee->profiledTaggedApplicant->shelterApplicant->person->first_name ?? 'N/A' }} {{ $grantee->profiledTaggedApplicant->shelterApplicant->person->middle_name ?? 'N/A' }}</td>
        <td class="py-4 px-2 text-center border-b whitespace-nowrap">{{ $grantee->profiledTaggedApplicant->shelterApplicant->address->barangay->name ?? 'N/A' }}</td>
        <td class="py-4 px-2 text-center border-b whitespace-nowrap">{{ $grantee->profiledTaggedApplicant->shelterApplicant->address->purok->name ?? 'N/A' }}</td>
        <td class="py-4 px-2 text-center border-b whitespace-nowrap">{{ $grantee->profiledTaggedApplicant->full_address ?? 'N/A' }}</td>
        <td class="py-4 px-2 text-center border-b whitespace-nowrap">{{ $grantee->profiledTaggedApplicant->contact_number ?? 'N/A' }}</td>
        <td class="py-4 px-2 text-center border-b whitespace-nowrap">
            @if($grantee->profiledTaggedApplicant->spouse)
            {{ $grantee->profiledTaggedApplicant->spouse->last_name ?? 'N/A' }},
            {{ $grantee->profiledTaggedApplicant->spouse->first_name ?? 'N/A' }}
            {{ $grantee->profiledTaggedApplicant->spouse->middle_name ?? '' }}
            @else
            N/A
            @endif
        </td>
        <td class="py-4 px-2 text-center capitalize border-b whitespace-nowrap">{{ $grantee->profiledTaggedApplicant->shelterApplicant->originOfRequest->name ?? 'N/A' }}</td>
        <td class="py-4 px-2 text-center border-b whitespace-nowrap">{{ $grantee->profiledTaggedApplicant->governmentProgram->program_name ?? 'N/A' }}</td>
        <td class="py-4 px-2 text-center capitalize border-b whitespace-nowrap"> {{ $grantee->profiledTaggedApplicant->shelterApplicant->date_request->format('Y-m-d') }}</td>
        <td class="py-4 px-2 text-center border-b whitespace-nowrap">{{ optional($grantee->profiledTaggedApplicant)->date_tagged ? $grantee->profiledTaggedApplicant->date_tagged->format('Y-m-d') : '' }}</td>
        <td class="py-4 px-2 text-center border-b whitespace-nowrap">{{ $grantee->date_of_delivery ? $grantee->date_of_delivery->format('Y-m-d') : '' }}</td>
        <td class="py-4 px-2 text-center border-b whitespace-nowrap">{{ $grantee->profiledTaggedApplicant->remarks ?? 'N/A' }}</td>
    </tr>
    @endforeach
    <!-- Spacing -->
    <tr>
        <td colspan="13" height="30"></td>
    </tr>

    <!-- Footer/Signatures -->
    <tr>
        <td colspan="6" style="padding-top: 30px;">
            Prepared by:
        </td>
        <td colspan="4" style="padding-top: 30px;">
            Noted by:
        </td>
    </tr>
</table>