<x-app-layout>
    <div x-data="{ openFilters: false }" class="p-10 h-screen  ml-[17%] mt-[60px]">
        <div class="flex bg-gray-100 text-[12px]">
            <livewire:walkin-transaction/>
        </div>
    </div>

{{--    <script>--}}
{{--        function pagination() {--}}
{{--            return {--}}
{{--                currentPage: 1,--}}
{{--                totalPages: 3, // Set this to the total number of pages you have--}}

{{--                prevPage() {--}}
{{--                    if (this.currentPage > 1) this.currentPage--;--}}
{{--                },--}}
{{--                nextPage() {--}}
{{--                    if (this.currentPage < this.totalPages) this.currentPage++;--}}
{{--                },--}}
{{--                goToPage(page) {--}}
{{--                    this.currentPage = page;--}}
{{--                }--}}
{{--            }--}}
{{--        }--}}
{{--    </script>--}}
</x-app-layout>