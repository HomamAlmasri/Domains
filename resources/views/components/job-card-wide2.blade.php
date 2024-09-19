@props(['result'])

<x-panal class="flex gap-x-6">
    <div class="flex-1 flex flex-col">

            <h2 class="font-bold text-white-600 text-xl mt-2 group-hover:text-gray-800 transition-color duration-300">
            {{ $result['name'] }}

        @if ($result['code'] != 200)

                @if(str_contains($result['error_message'], "SSL certificate problem"))
                    <h3 class="font-bold text-yellow-300 text-xl mt-2 group-hover:text-red-800 transition-color duration-300">
                    {{ $result['domain'] }}

                <p class="text-sm text-yellow-600 mt-auto">{{ $result['code'] }}</p>
                @else

                    <h3 class="font-bold text-red-600 text-xl mt-2 group-hover:text-red-800 transition-color duration-300">
                    {{ $result['domain'] }}
                    </h3>
                    <p class="text-sm text-red-600 mt-auto">{{ $result['code'] }}</p>

                @endif

            @if (isset($result['error_message']))
                @if(str_contains($result['error_message'], "SSL certificate problem"))
                    <p class="text-sm text-yellow-600 mt-auto">{{ $result['error_message'] }}</p>
                @else
                    <p class="text-sm text-red-600 mt-auto">{{ $result['error_message'] }}</p>
                @endif
            @endif
        @else

                <h3 class="font-bold text-green-400 text-xl mt-2 group-hover:text-green-800 transition-color duration-300">
                {{ $result['domain'] }}
                </h3>
              <p class="text-sm text-green-400-400 mt-auto">{{ $result['code'] }}</p>

        @endif
    </div>
</x-panal>
