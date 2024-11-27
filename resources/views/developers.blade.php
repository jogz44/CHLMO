<x-adminshelter-layout>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Meet the Developers</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col items-center" style="font-family:'Poppins', sans-serif;">

  <!-- Header and Supervisor Centered Above All Cards -->
  <div class="flex flex-row justify-center  ml-[250px] mt-[100px] space-x-10 ">
    <!-- Header Section -->
    <div class="text-center">
      <h1 class="text-3xl font-bold mt-[130px]  text-gray-800">Meet the Team</h1>
      <p class="text-gray-600 text-lg mt-2">The masterminds behind the system</p>
    </div>
  </div>
    <!-- All Cards in One Row -->
<div class="flex justify-center ml-[250px] space-x-5 mt-[50px]">
  <!-- Practicum Supervisor Card -->
<div class="bg-white rounded-xl text-black p-6 w-[350px] h-[330px] shadow-2xl flex flex-col items-center">
  <img src="{{ asset('storage/images/Card1.png') }}" alt="Card1" class="w-[150px] h-[150px] rounded-full">
  <div class="font-bold text-md text-black mt-6 text-center leading-tight">
    MISHILL D. CEMPRON
  </div>
  <div class="text-md text-gray-700 text-center mt-8">Practicum Supervisor</div>
  <div class="text-sm text-gray-600 text-center mt-1">mishillcempron@gmail.com</div>
</div>


   <!-- Developer Card 2 -->
   <div class="bg-white rounded-xl text-black p-6 w-[260px] h-[320px] shadow-2xl flex flex-col items-center">
    <img src="{{ asset('storage/images/Card2.png') }}" alt="Card2" class="w-[140px] h-[130px] rounded-full">
    <div class="font-bold text-md text-black mt-6 text-center leading-tight">
      SYDNEY A. PELINO
    </div>
    <div class="text-sm text-gray-700 text-center mt-6">Project Manager & Head Back-end Developer</div>
    <div class="text-[12px] text-gray-600 text-center mt-1 ">sydneypang2324@gmail.com</div>
  </div>

  <!-- Developer Card 3 -->
  <div class="bg-white rounded-xl text-black p-6 w-[260px] h-[310px] shadow-2xl flex flex-col items-center">
    <img src="{{ asset('storage/images/Card3.png') }}" alt="Card3" class="w-[130px] h-[130px] rounded-full">
    <div class="font-bold text-md text-black mt-6 text-center leading-tight">
      SHEENA MARIZ M. PAGAS
    </div>
    <div class="text-sm text-gray-700 text-center mt-6">Head Front-end & Back-end Developer</div>
    <div class="text-[12px]  text-gray-600 text-center mt-1">sheenamarizpagas117@gmail.com</div>
  </div>

 

  <!-- Developer Card 4 -->
  <div class="bg-white rounded-xl text-black ml-[100px] p-6 w-[260px] h-[300px] shadow-2xl flex flex-col items-center">
    <img src="{{ asset('storage/images/Card4.png') }}" alt="Card4" class="w-[140px] h-[130px] rounded-full">
    <div class="font-bold text-md text-black mt-6 text-center leading-tight">
      NOVA GRACE P. PALMES
    </div>
    <div class="text-sm text-gray-700 text-center text-break w-[200px] mt-6">Assistant Front-end & Back-end Developer</div>
    <div class="text-[12px] text-gray-600 text-center mt-1">novagracepalmes22@gmail.com</div>
  </div>
</div>
<div class="absolute justify-items-center top-[450px] left-[-30px] right-[-30px] h-[2px] bg-white z-0"></div>
</body>

</html>
</x-adminshelter-layout>
