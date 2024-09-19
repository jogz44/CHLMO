<div class="min-h-screen flex justify-center items-center relative">
    <!-- Container with flex to hold both content and SVG -->
    <div class="flex flex-col sm:flex-row w-full sm:max-w-2xl lg:max-w-4xl px-48 py-14 bg-white bg-opacity-90 shadow-md overflow-hidden sm:rounded-lg relative">
        <!-- Left side content (logo and slot) -->
        <div class="w-full sm:max-w-md z-10">
            <div>
                {{ $logo }}
            </div>
            <div class="mt-10">
                {{ $slot }}
            </div>
        </div>

        <!-- Right side SVG -->
        <div class="absolute inset-y-0 right-0 hidden sm:flex items-center justify-end">
            <svg class="w-auto h-full sm:w-[300px] lg:w-[400px]" width="548" height="677" viewBox="0 0 548 677" fill="none" xmlns="http://www.w3.org/2000/svg">
                <ellipse cx="883.5" cy="451.241" rx="628.553" ry="626.673" transform="rotate(140.581 883.5 451.241)" fill="#FF9100"/>
                <ellipse cx="829.374" cy="454.5" rx="511.228" ry="526.686" transform="rotate(140.581 829.374 454.5)" fill="#10B152" fill-opacity="0.9"/>
                <ellipse cx="889.831" cy="486.488" rx="431.596" ry="487.273" transform="rotate(140.581 889.831 486.488)" fill="#328D56"/>
            </svg>
        </div>
    </div>
</div>






{{--<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">--}}
{{--    <div>--}}
{{--        {{ $logo }}--}}
{{--    </div>--}}

{{--    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">--}}
{{--        {{ $slot }}--}}
{{--    </div>--}}
{{--</div>--}}

{{--<div class="min-h-screen flex flex-col sm:justify-center items-center pt-1 sm:pt-0 bg-gray-100">--}}
{{--    <div class="w-full sm:max-w-md mt-6 p-10 bg-white shadow-md overflow-hidden sm:rounded-lg z-10">--}}
{{--        <div>--}}
{{--            {{ $logo }}--}}
{{--        </div>--}}

{{--        <div class="mt-10">--}}
{{--            {{ $slot }}--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div>--}}
{{--        <svg width="548" height="677" viewBox="0 0 548 677" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--            <ellipse cx="883.5" cy="451.241" rx="628.553" ry="626.673" transform="rotate(140.581 883.5 451.241)" fill="#FF9100"/>--}}
{{--            <ellipse cx="829.374" cy="454.5" rx="511.228" ry="526.686" transform="rotate(140.581 829.374 454.5)" fill="#10B152" fill-opacity="0.9"/>--}}
{{--            <ellipse cx="889.831" cy="486.488" rx="431.596" ry="487.273" transform="rotate(140.581 889.831 486.488)" fill="#328D56"/>--}}
{{--        </svg>--}}
{{--    </div>--}}
{{--</div>--}}

{{--<div class="min-h-screen flex justify-center items-center pt-1 sm:pt-0 bg-gray-100">--}}
{{--    <!-- Container with flex to hold both content and SVG, adjusted width -->--}}
{{--    <div class="flex flex-col sm:flex-row w-full sm:max-w-2xl lg:max-w-4xl mt-6 p-10 bg-white shadow-md overflow-hidden sm:rounded-lg relative space-x-0 sm:space-x-6">--}}

{{--        <!-- Left side content (logo and slot) -->--}}
{{--        <div class="w-full sm:max-w-md z-10">--}}
{{--            <div>--}}
{{--                {{ $logo }}--}}
{{--            </div>--}}

{{--            <div class="mt-10">--}}
{{--                {{ $slot }}--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <!-- Right side SVG -->--}}
{{--        <div class="hidden sm:flex absolute sm:relative right-0 top-0 h-full justify-end items-start">--}}
{{--            <svg class="w-auto h-full sm:w-[300px] lg:w-[400px]" width="548" height="677" viewBox="0 0 548 677" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                <ellipse cx="883.5" cy="451.241" rx="628.553" ry="626.673" transform="rotate(140.581 883.5 451.241)" fill="#FF9100"/>--}}
{{--                <ellipse cx="829.374" cy="454.5" rx="511.228" ry="526.686" transform="rotate(140.581 829.374 454.5)" fill="#10B152" fill-opacity="0.9"/>--}}
{{--                <ellipse cx="889.831" cy="486.488" rx="431.596" ry="487.273" transform="rotate(140.581 889.831 486.488)" fill="#328D56"/>--}}
{{--            </svg>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}




