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
</body>

</html>