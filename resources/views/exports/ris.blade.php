<table style="width: 100%; border-collapse: collapse;">
    <tr>
        <td colspan="9"></td>
    </tr>
    <tr>
        <td colspan="9" style="text-align: center; margin-top: 40px; font-size: 11px; font-weight: bold;">
            Republic of the Philippines
        </td>
    </tr>
    <tr>
        <td colspan="9" style="text-align: center; font-size: 11px; font-weight: bold;">
            Province of Davao del Norte
        </td>
    </tr>
    <tr>
        <td colspan="9" style="text-align: center; font-size: 11px; font-weight: bold;">
            CITY GOVERNMENT OF TAGUM
        </td>
    </tr>
    <tr>
        <td colspan="9" height="20"></td>
    </tr>
    <tr>
        <td colspan="9" style="text-align: center; font-weight: bold;">SHELTER ASSISTANCE PROGRAM</td>
    </tr>
    <tr>
        <td colspan="9" style="text-align: center; font-weight: bold;">ACKNOWLEDGEMENT RECEIPT (AR)</td>
    </tr>
    <tr>
        <td colspan="9" height="20"></td>
    </tr>
    <tr>
        <td colspan="2">Office:</td>
        <td colspan="5">City Housing and Land Management Office</td>
        <td>AR No.:</td>
        <td>{{ $grantee->ar_no }}</td>
    </tr>
    <tr>
        <td colspan="2">Name of Requester:</td>
        <td colspan="5">{{ $grantee->profiledTaggedApplicant->shelterApplicant->person->full_name }}</td>
        <td>Date:</td>
        <td>{{ now()->format('Y-m-d') }}</td>
    </tr>
    <tr>
        <td colspan="2">Purok/Barangay:</td>
        <td colspan="5">{{ $grantee->profiledTaggedApplicant->shelterApplicant->address->purok->name }}, {{ $grantee->profiledTaggedApplicant->shelterApplicant->address->barangay->name }}</td>
        <td>PO No.:</td>
        <td>{{ $selectedPO }}</td>
    </tr>
    <tr>
        <td colspan="9" height="30"></td>
    </tr>
    <tr  style="border-bottom: 2px solid #000;">
        <td style="padding: 8px; border-bottom-width: 1px; text-align: center; font-weight: 500; white-space: nowrap;">ITEM NO.</td>
        <td style="padding: 8px; border-bottom-width: 1px; text-align: center; font-weight: 500; white-space: nowrap;">UNIT</td>
        <td colspan="4" style="padding: 8px; border-bottom-width: 1px; text-align: center; font-weight: 500; white-space: nowrap;">DESCRIPTION</td>
        <td style="padding: 8px; border-bottom-width: 1px; text-align: center; font-weight: 500; white-space: nowrap;">QUANTITY</td>
        <td colspan="2" style="padding: 8px; border-bottom-width: 1px; text-align: center; font-weight: 500; white-space: nowrap;">REMARKS</td>
    </tr>
    @foreach ($materials as $index => $material)
    <tr style="border-bottom: 1px solid #ccc;">
        <td style="padding: 8px; text-align: center; border-bottom-width: 1px; white-space: nowrap;">{{ $index + 1 }}</td>
        <td style="padding: 8px; text-align: center; border-bottom-width: 1px; white-space: nowrap;">{{ $material['material_unit_id'] }}</td>
        <td colspan="4" style="padding: 8px; text-align: center; border-bottom-width: 1px; white-space: nowrap;">{{ $material['item_description'] ?? 'No description available' }}</td>
        <td style="padding: 8px; text-align: center; border-bottom-width: 1px; white-space: nowrap;">{{ $material['grantee_quantity'] }}</td>
        <td colspan="2" style="padding: 8px; text-align: center; border-bottom-width: 1px; white-space: nowrap;"></td>
    </tr>
    @endforeach

    <tr>
        <td colspan="9" height="30"></td>
    </tr>

    <!-- Footer/Signatures -->
    <tr>
        <td colspan="2" style="padding-top: 30px;">
            Recieved by:
        </td>
        <td colspan="3" style="padding-top: 30px;">
            Prepared and Released by:
        </td>
        <td colspan="3" style="padding-top: 30px;">
            Verified and Reviewed by:
        </td>
        <td colspan="1" style="padding-top: 30px;">
            Noted by:
        </td>
    </tr>

</table>