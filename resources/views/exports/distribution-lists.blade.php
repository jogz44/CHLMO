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
        <td colspan="9"></td>
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
            <strong>{{ $title }}</strong>
        </td>
    </tr>
    <tr>
        <td colspan="8" style="text-align: center; font-size: 12px;">
            <span style="font-weight: medium;">{{ $subtitle }}</span>
        </td>
    </tr>
    <!-- Spacing -->
    <tr>
        <td colspan="8" height="20"></td>
    </tr>
    <tr style="width: 100%; border-collapse: collapse; border-top: 2px solid #000000;">
        <th style="padding: 8px; border: 1px solid #000000; border-color:black; text-align: center; font-weight: 800; white-space: nowrap;"></th>
        <th style="padding: 8px; border: 1px solid #000000; border-color:black; text-align: center; font-weight: 500; white-space: nowrap;">(PR #)</th>
        <th style="padding: 8px; border: 1px solid #000000; border-color:black; text-align: center; font-weight: 500; white-space: nowrap;">(PO #)</th>
        <th style="padding: 8px; border: 1px solid #000000; border-color:black; text-align: center; font-weight: 500; white-space: nowrap;"></th>
        @foreach ($allMaterials as $material)
        <th class="py-2 px-2 text-center font-medium whitespace-nowrap">
            {{ strtoupper($material->quantity) }}
            ({{ $material->materialUnit->unit ?? 'N/A' }})
        </th>
        @endforeach
    </tr>
    <tr style="width: 100%; border-collapse: collapse;">
        <th style="padding: 8px; border: 1px solid #000000; border-color:black; text-align: center; font-weight: 500; white-space: nowrap;">No.</th>
        <th style="padding: 8px; border: 1px solid #000000; border-color:black; text-align: center; font-weight: 500; white-space: nowrap;">DATE OF RIS</th>
        <th style="padding: 8px; border: 1px solid #000000; border-color:black; text-align: center; font-weight: 500; white-space: nowrap;">NAME OF RECIPIENT</th>
        <th style="padding: 8px; text-align: center; font-weight: 500; white-space: nowrap;">SERIES NO.</th>
        @foreach ($allMaterials as $material)
        <th style="padding: 8px; border: 1px solid #000000; border-color:black; text-align: center; font-weight: 500; white-space: nowrap;">
            {{ strtoupper($material->item_description) }}
        </th>
        @endforeach
    </tr>

    @forelse($grantees as $grantee)
    <tr style="width: 100%; border-collapse: collapse;">
        <td style="padding: 8px; text-align: center; border: 1px solid #000000; border-color:black; white-space: nowrap;">{{ $grantee->profiledTaggedApplicant->shelterApplicant->profile_no ?? 'N/A'  }}</td>
        <td style="padding: 8px; text-align: center; border: 1px solid #000000; white-space: nowrap;">{{ $grantee->date_of_ris ? $grantee->date_of_ris->format('Y-m-d') : '' }}</td>
        <td style="padding: 8px; text-align: center; border: 1px solid #000000; white-space: nowrap;">
            {{ $grantee->profiledTaggedApplicant->shelterApplicant->person->last_name ?? 'N/A' }},
            {{ $grantee->profiledTaggedApplicant->shelterApplicant->person->first_name ?? 'N/A' }}
            {{ $grantee->profiledTaggedApplicant->shelterApplicant->person->middle_name ?? 'N/A' }}
        </td>
        <td style="padding: 8px; text-align: center; border: 1px solid #000000; white-space: nowrap;">{{ $grantee->ar_no ?? 'N/A' }}</td>

        @foreach ($allMaterials as $material)
        @php
        $deliveredMaterial = $grantee->deliveredMaterials->firstWhere('material_id', $material->id);
        @endphp
        <td style="padding: 8px; text-align: center; border: 1px solid #000000; white-space: nowrap;">
            {{ $deliveredMaterial->grantee_quantity ?? '0' }}
        </td>
        @endforeach
    </tr>
    @empty
    <tr>
        <td colspan="{{ 4 + $allMaterials->count() }}" class="text-center py-4">No Records found.</td>
    </tr>
    @endforelse

    <!-- Totals Row -->
    <tr style="width: 100%; border-collapse: collapse;">
        <td style="padding: 8px; text-align: center; border-bottom: 2px solid #000000; border-top: 2px solid #000000;  white-space: nowrap;"></td>
        <td style="padding: 8px; text-align: center; border-bottom: 2px solid #000000; border-top: 2px solid #000000;  white-space: nowrap;"></td>
        <td style="padding: 8px; text-align: center; border-bottom: 2px solid #000000; border-top: 2px solid #000000;  white-space: nowrap;"></td>
        <td style="padding: 8px; text-align: center; border-bottom: 2px solid #000000; border-top: 2px solid #000000;  border: 1px solid #000000; white-space: nowrap;"><strong>Total Items</strong></td>
        <td style="padding: 8px; text-align: center; border-bottom: 2px solid #000000; border-top: 2px solid #000000;  border: 1px solid #000000; white-space: nowrap;">{{ $totals['total_delivered'] }}</td>
    </tr>

    <!-- Spacing -->
    <tr>
        <td colspan="8" height="30"></td>
    </tr>

    <!-- Footer/Signatures -->
    <tr>
        <td colspan="2" style="padding-top: 30px;">
            Prepared by:
        </td>
        <td colspan="1" style="padding-top: 30px;">
            Certified Correct by:
        </td>
        <td colspan="2" style="padding-top: 30px;">
            Noted by:
        </td>
        <td colspan="2" style="padding-top: 30px;">
            Approved by:
        </td>
    </tr>

</table>