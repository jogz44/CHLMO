<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-[120px] py-[4px] h-[30px] bg-green-600 hover:bg-green-500 text-white font-semibold rounded-full flex items-center justify-center space-x-2 transition']) }}>
    {{ $slot }}
</button>
