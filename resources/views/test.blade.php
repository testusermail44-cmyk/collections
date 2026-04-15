<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css'])
</head>

<body>
    radius: {{ $r }}
    answer: {{ $answer }}
    <a class="inline-flex items-center justify-center 
          px-6 py-3 
          text-[#1b1b18] font-bold 
          border-2 border-[#003399] 
          rounded-xl 
          hover:bg-[#003399] hover:text-white 
          transition-all duration-300" href="{{ route('test-session') }}">ТЕСТОВА СЕСІЯ</a>
    <form action="{{ route('test-upload') }}" method="POST" enctype="multipart/form-data" class="mb-6">
        @csrf
        <input type="text" name="item_name" placeholder="Назва предмета" class="border p-2 mb-2 block w-full" required>
        <input type="file" name="my_file" class="mb-2 block">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">ЗБЕРЕГТИ В БД</button>
    </form>
</body>

</html>