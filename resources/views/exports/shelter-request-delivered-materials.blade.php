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
        <th class="py-2 px-[20px] text-center font-medium whitespace-nowrap">NO.</th>
        <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap">BARANGAY</th>
        <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap">NO. OF REQUEST</th>
        <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap">NO. OF REQUEST TAGGED AND VALIDATED</th>
        <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap">NO. OF REQUEST DELIVERED</th>
    </tr>
    @forelse ($statistics as $index => $stat)
    <tr>
        <td class="py-4 px-2 text-center border-b">{{ $index + 1 }}</td>
        <td class="py-4 px-2 text-center border-b whitespace-nowrap">{{ $stat->barangay_name }}</td>
        <td class="py-4 px-2 text-center border-b">{{ $stat->total_requests }}</td>
        <td class="py-4 px-2 text-center border-b">{{ $stat->tagged_requests }}</td>
        <td class="py-4 px-2 text-center border-b">{{ $stat->delivered_requests }}</td>
    </tr>
    @empty
    <tr>
        <td colspan="5" class="py-4 px-2 text-center border-b">No records found</td>
    </tr>
    @endforelse
    <!-- Totals Row -->
    <tr class="bg-yellow-100 font-bold">
        <td class="py-4 px-2 text-center border-t"></td>
        <td class="py-4 px-2 text-center border-t"><strong>TOTAL</strong></td>
        <td class="py-4 px-2 text-center border-t">{{ $totals['total_requests'] }}</td>
        <td class="py-4 px-2 text-center border-t">{{ $totals['tagged_requests'] }}</td>
        <td class="py-4 px-2 text-center border-t">{{ $totals['delivered_requests'] }}</td>
    </tr>

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