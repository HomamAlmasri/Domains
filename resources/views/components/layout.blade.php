<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Domain check </title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-black text-white font-hanken-grotesk mb-16">
    <div class="px-10">
        <nav class="flex justify-between py-4 border-b border-white/10 ">
            <div class="flex space-x-5">
                <img class="w-16 h-16o" src="{{ asset('storage/images/logo2.jpg') }}" alt="logo">
            </div>
            <div class="space-x-16 font-bold mt-auto mb-5">
                @auth
                <x-heading>
                    <a href="/do" class="hover:bg-blue-900 rounded-xl px-2 py-1">Check Domains</a>
                </x-heading>

                <x-heading> <a class="hover:bg-blue-900 rounded-xl px-2 py-1" href="/domains">Domains</a></x-heading>
                <x-heading> <a class="hover:bg-blue-900 rounded-xl px-2 py-1" href="{{Route('domain.create')}}">Add Domain</a></x-heading>
                @endauth
            </div>
            @guest
                <div class="mt-5">
                    <x-heading><a href="{{route('login')}}" class="hover:bg-blue-900 rounded-xl px-2 py-1">Log In</a></x-heading>
                </div>
            @endguest
            @auth
                <div class="mt-4">
                    <form action="/logout" method="Post">
                        @csrf
                        <x-heading>
                            <button class="hover:bg-blue-900 rounded-xl px-2 py-1">Log out</button>
                        </x-heading>
                    </form>
                </div>
            @endauth
        </nav>
        <main class="mt-10 max-w-[968px] mx-auto">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
