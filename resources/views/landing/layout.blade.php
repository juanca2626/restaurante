<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="https://cdn.tailwindcss.com"></script>
        @vite('resources/css/app.css')
        <title>RestoRapi</title>
    </head>
    <body>
        <div id="app" class="font-sans">
            <main-app v-slot="props" 
                save-order-uri="{{ route('save-order') }}"
                get-customer-data-uri="{{ route('get-customer-data', ['dni' => ':dni']) }}">
                <sidebar-cart :menu="{{ $menu ?? [] }}"></sidebar-cart>
                <div class="main-content py-3 px-10">
                    @yield('content')
                </div> 
            </main-app>
        </div>
         @vite('resources/js/app.js')
    </body>
</html>