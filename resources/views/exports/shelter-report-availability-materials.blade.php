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
            <strong>{{ $title ?? 'REPORT ON AVAILABILITY OF MATERIALS UNDER THE SHELTER ASSISTANCE PROGRAM' }}</strong>
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

    <!-- Table Headers -->
    <tr>
        <th class="py-2 px-4 text-center text-gray-700">ITEM NO.</th>
        <th class="py-2 px-4 text-center text-gray-700">ITEM DESCRIPTION</th>
        <th class="py-2 px-4 text-center text-gray-700">UNIT</th>
        @if(!$isFiltered)
        @foreach($prPoHeaders as $header)
        <th class="py-2 px-4 text-center text-gray-700 whitespace-nowrap">
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
        <td style="border: 1px solid #000000; text-align: center; padding: 8px;">>{{ $material->pr_number }}</td>
        <td style="border: 1px solid #000000; text-align: center; padding: 8px;">{{ $material->po_number }}</td>
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