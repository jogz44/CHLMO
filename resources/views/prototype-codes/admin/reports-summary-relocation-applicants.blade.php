@extends('layouts.admin')

@section('sidebar')
@include('prototype-codes.components.sidebar')
@endsection

@section('header')
@include('prototype-codes.components.header')
@endsection

@section('content')
<div class="flex bg-gray-100 text-[12px]">
    <!-- Sidebar -->
    <aside class="w-[17%] bg-white h-full shadow-md">
        <!-- Sidebar content -->
        <!-- Your existing sidebar code here -->
    </aside>

    <!-- Main Content -->
    <div x-data="pagination()" class="flex-1 h-screen p-6 overflow-auto">
        <div class="bg-white rounded mt-[60px] shadow mb-6 flex items-center justify-between relative p-3">
            <div class="flex items-center">
                <h2 class="text-[13px] ml-2 items-center text-gray-700">REPORTS</h2>
            </div>
            <img src="{{ asset('storage/halmsAssets/design.png') }}" alt="Design" class="absolute right-0 top-0 h-full object-cover opacity-40 z-0">
            <div x-data="{ selectedReport: '' }" class="flex space-x-2 z-0">
                <select @change="window.location.href = selectedReport" x-model="selectedReport"
                    class="w-full px-3 py-3 bg-transparent border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]" style="padding: 4px 4px;">
                    <option value="" default>Reports</option>
                    <option value="/prototype-codes/admin/reports-summary-informal-settlers">Summary of Identified Informal Settlers</option>
                    <option value="/prototype-codes/admin/reports-summary-relocation-applicants" selected>Summary of Relocation Lot Applicant </option>
                </select>
            </div>
        </div>
        <div class="flex items-center mb-2 ml-2">
            <h2 class="text-[14px] font-semibold items-center text-gray-700">Summary of Relocation Lot Applicant</h2>
        </div>
        <div x-data="fileUpload()" class="bg-white p-6 rounded shadow">
            <div class="flex justify-between items-center mb-4">
                <div class="flex space-x-2">
                    <!-- Search -->
                    <div class="relative hidden md:block">
                        <svg class="absolute top-[13px] left-4" width="19" height="19" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.625 16.625C13.491 16.625 16.625 13.491 16.625 9.625C16.625 5.75901 13.491 2.625 9.625 2.625C5.75901 2.625 2.625 5.75901 2.625 9.625C2.625 13.491 5.75901 16.625 9.625 16.625Z" stroke="#787C7F" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M18.3746 18.375L14.5684 14.5688" stroke="#787C7F" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <input type="search" name="search" id="search" class="rounded-md px-12 py-2 placeholder:text-[13px] outline-none border-none z-10 bg-[#f7f7f9] hover:ring-custom-yellow focus:ring-custom-yellow" placeholder="Search">
                    </div>
                </div>

                <!-- filters and button -->
                <div class="flex space-x-2">
                    <label for="start-date" class="text-[13px] py-2 font-medium">Date Range:</label>
                    <input type="date" id="start-date" class="border text-[13px] border-gray-300 rounded px-2 py-1">
                    <input type="date" id="end-date" class="border text-[13px] border-gray-300 rounded px-2 py-1">
                    <button class="bg-custom-green text-white px-4 py-2 rounded">Export</button>
                </div>
            </div>

            <!-- Table with transaction requests -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-2 px-10 font-semibold  text-center">Relocation Lot Applicants</th>
                            <th class="py-2 px-10 border-b text-center  font-medium">No. of Applicants</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="py-2 px-2 text-center  border-b font-semibold">Walkin Applicants</td>
                            <td class="py-2 px-2 border-b text-center font-medium"> 21008 </td>

                        </tr>
                        <tr>
                            <td class="py-2 px-2 text-center  border-b font-semibold">Tagged and Validated</td>
                            <td class="py-2 px-2 border-b text-center font-medium"> 12567</td>

                        </tr>
                        <tr>
                            <td class="py-2 px-2 text-center  border-b font-semibold">Identified Informal Settlers</td>
                            <td class="py-2 px-2 border-b text-center font-medium">8767 </td>

                        </tr>
                        <tr>
                            <td class="py-4 px-2 text-center  border-b font-semibold"></td>
                            <td class="py-4 px-2 b text-center border-b font-medium"> </td>

                        </tr>
                        <tr>
                            <td class="py-2 px-2 text-center  border-b font-semibold">Total Number Relocation Lot Applicants</td>
                            <td class="py-2 px-2 border-b text-center font-medium"> 10873</td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @endsection