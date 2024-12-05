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

        <!-- Spacing -->
    <tr style="border-bottom: 4px solid #000;">
        <td colspan="8" height="10"></td>
    </tr>
    <tr style="border-bottom: 4px solid #000;">
        <td colspan="8" height="20"></td>
    </tr>

    <!-- Report Title -->
    <tr>
        <td colspan="8" style="text-align: center; font-size: 11px; font-weight: bold;">
            <strong>{{ $title ?? 'REPORT ON AVAILABILITY OF MATERIALS UNDER THE SHELTER ASSISTANCE PROGRAM' }}</strong>
        </td>
    </tr>
    <tr>
        <td colspan="8" style="text-align: center; font-size: 9px;">
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

    <!-- Table Headers -->
    <tr>
        <th style="border: 2px solid #000000; text-align: center; padding: 8px;">ITEM NO.</th>
        <th style="border: 2px solid #000000; text-align: center; padding: 8px;">ITEM DESCRIPTION</th>
        <th style="border: 2px solid #000000; text-align: center; padding: 8px;">UNIT</th>
        @if(!$isFiltered)
        @foreach($prPoHeaders as $header)
        <th style="border: 2px solid #000000; text-align: center; padding: 8px;">
            PR {{ $header->pr_number }}<br>PO {{ $header->po_number }}
        </th>
        @endforeach
        @endif
    </tr>

    <!-- Table Body -->
    @foreach($materials as $index => $material)
    <tr>
        <td style="border: 1px solid #000000; text-align: center; padding: 8px;">{{ $index + 1 }}</td>
        <td style="border: 1px solid #000000; padding: 8px;">{{ $material->item_description }}</td>
        <td style="border: 1px solid #000000; text-align: center; padding: 8px;">{{ $material->unit }}</td>
        <!-- <td style="border: 1px solid #000000; text-align: center; padding: 8px;">>{{ $material->pr_number }}</td> -->
        <!-- <td style="border: 1px solid #000000; text-align: center; padding: 8px;">{{ $material->po_number }}</td> -->
        <td style="border: 1px solid #000000; text-align: center; padding: 8px;">{{ $material->available_quantity }}</td>
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