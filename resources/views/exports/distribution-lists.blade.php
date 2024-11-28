<table>
    <!-- Spacing -->
    <tr>
        <td colspan="5" height="81.6"></td>
    </tr>
    <tr>
        <td colspan="5" style="text-align: center; margin-top: 40px; font-size: 9px; font-weight: bold;">
            Republic of the Philippines
        </td>
    </tr>
    <tr>
        <td colspan="5" style="text-align: center; font-size: 9px; font-weight: bold;">
            Province of Davao del Norte
        </td>
    </tr>
    <tr>
        <td colspan="5" style="text-align: center; font-size: 9px; font-weight: bold;">
            City of Tagum
        </td>
    </tr>
    <tr>
        <td colspan="5" style="text-align: center; font-size: 11px; font-weight: bold;">
            CITY HOUSING AND LAND MANAGEMENT OFFICE
        </td>
    </tr>

    <!-- Spacing -->
    <tr>
        <td colspan="5" height="20"></td>
    </tr>

    <!-- Report Title -->
    <tr>
        <td colspan="5" style="text-align: center; font-size: 14px; font-weight: bold;">
            <strong>{{ $title }}</strong>
        </td>
    </tr>
    <tr>
        <td colspan="5" style="text-align: center; font-size: 12px;">
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
        <td colspan="5" height="20"></td>
    </tr>

    <tr style="background-color: #f3f4f6;">
        <th class="py-2 px-[20px]  text-center font-medium whitespace-nowrap">No.</th>
        <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap">DATE OF RIS</th>
        <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap">NAME OF RECIPIENT</th>
        <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap">CONTACT NO.</th>
        @foreach ($allMaterials as $material)
        <th class="py-2 px-2 text-center font-medium whitespace-nowrap">
            {{ strtoupper($material->item_description) }}
            ({{ $material->materialUnit->unit_name ?? 'N/A' }})
        </th>
        @endforeach
    </tr>

    @forelse($grantees as $grantee)
    <tr>
        <td class="py-4 px-2 text-center border-b whitespace-nowrap">{{ $grantee->profiledTaggedApplicant->shelterApplicant->profile_no }}</td>
        <td class="py-4 px-2 text-center border-b whitespace-nowrap">{{ $grantee->date_of_ris ? $grantee->date_of_ris->format('Y-m-d') : '' }}</td>
        <td class="py-4 px-2 text-center capitalize border-b whitespace-nowrap">
            {{ $grantee->profiledTaggedApplicant->shelterApplicant->person->last_name ?? 'N/A' }},
            {{ $grantee->profiledTaggedApplicant->shelterApplicant->person->first_name ?? 'N/A' }}
            {{ $grantee->profiledTaggedApplicant->shelterApplicant->person->middle_name ?? 'N/A' }}
        </td>
        <td class="py-4 px-2 text-center border-b whitespace-nowrap">{{ $grantee->profiledTaggedApplicant->contact_number ?? 'N/A' }}</td>

        @foreach ($allMaterials as $material)
        @php
        $deliveredMaterial = $grantee->deliveredMaterials->firstWhere('material_id', $material->id);
        @endphp
        <td class="py-4 px-2 text-center border-b whitespace-nowrap">
            {{ $deliveredMaterial->grantee_quantity ?? '0' }}
        </td>
        @endforeach
    </tr>
    @empty
    <tr>
        <td colspan="{{ 4 + $allMaterials->count() }}" class="text-center py-4">No Grantees found.</td>
    </tr>
    @endforelse

    <!-- Spacing -->
    <tr>
        <td colspan="5" height="30"></td>
    </tr>

    <!-- Footer/Signatures -->
    <tr>
        <td colspan="3" style="padding-top: 30px;">
            Prepared by:
        </td>
        <td colspan="2" style="padding-top: 30px;">
            Noted by:
        </td>
    </tr>

</table>