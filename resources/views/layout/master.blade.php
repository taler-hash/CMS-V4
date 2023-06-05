<!DOCTYPE html>
<html lang="en">
<head>
    @include('/component/head')
</head>
<body x-data="{showLinks:true}" class="w-full h-screen">
    <nav class="border border-b h-14">
        <div class="w-full h-full flex items-center">

            <p class="font-medium text-gray-700 text-lg pl-3">Create Contract</p>
        </div>
    </nav>
    @yield('content')
</body>
@stack('scripts')
</html>