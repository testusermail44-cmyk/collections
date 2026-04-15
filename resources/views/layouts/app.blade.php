<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    @vite(['resources/css/app.css'])
</head>

<body class="overflow-y-hidden flex flex-col">
    @include('partials.header')
    <main class="h-[calc(100vh-68px)] container mx-auto px-4 py-4 lg:px-20 overflow-y-auto">
        @yield('content')
    </main>
    @php
        $hasMessage = $errors->any() || session('success');
        $message = $errors->any() ? $errors->first() : session('success');
        $type = session('type', 0);
        $color = $type == 1 ? '#ef4444' : ($type == 2 ? '#20e250' : '#0891b2');
    @endphp
    @if ($hasMessage)
        <script>
            Toastify({
                text: "{{ $message }}",
                duration: 4000,
                gravity: "top",
                position: "center",
                stopOnFocus: true,
                style: {
                    background: "white",
                    color: "{{ $color }}",
                    borderLeft: "4px solid {{ $color }}",
                    borderRight: "4px solid {{ $color }}",
                    borderRadius: "12px",
                    boxShadow: "0 0 8px 2px rgba(0, 0, 0, 0.3)",
                    padding: "12px 24px",
                    fontSize: "18px",
                    marginTop: '20px'
                },
                onClick: function () { }
            }).showToast();
        </script>
    @endif
</body>

</html>