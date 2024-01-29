<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waiting for Approval</title>
    @vite('resources/css/app.css')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Roboto:wght@400;500;700&display=swap"
          rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="flex flex-col justify-center items-center h-screen">.
    <img src="{{asset('graphic/logo.png')}}" class="w-1/3" alt="logo">
    <div class="text-center p-6 bg-white shadow-md rounded">
        <h1 class="text-2xl font-semibold mb-3">Account Pending Approval</h1>
        <p class="mb-6">Your account is currently awaiting approval. Please check back later or contact support if you have any questions.</p>
        <a href="{{ url('/') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Go to Home</a>
    </div>
</div>

</body>
</html>
