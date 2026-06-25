<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Monitor</title>
    <link rel="icon" type="image/x-icon" href="/images/icon.ico">
    <link rel="stylesheet" href="{{ asset('css/custom_classes.css') }}">
    <!-- Include Tailwind CSS -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.x.x/dist/alpine.min.js" defer></script>

</head>
<body class="text-white bg-black min-h-screen min-w-screen flex flex-col">
<header class="bg-gray-800 p-2">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-white text-2xl">Manual Product Control Sheet</h1>
            <h1 class="text-white text-lg">Created by Caimen Jackson</h1>
            <div id="liveDate" class="bg-red-700 text-white text-xl font-mono"></div>
            <div id="liveClock" class="bg-red-700 text-white text-xl font-mono"></div>
        </div>
    </header>
<main class="flex-grow p-4">
            {{$slot}}
        </main>

        <script>
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const formattedTime = `${hours}:${minutes}:${seconds}`;
            document.getElementById('liveClock').textContent = formattedTime;
        }

        function updateDate() {
            const now = new Date();

            // get the current date and time as a string
            const currentDateTime = now.toLocaleString();
            document.getElementById('liveDate').textContent = currentDateTime;
        }

        function autoRefresh() {
        window.location = window.location.href;
        }
    

        // Update the clock every second
        setInterval(updateClock, 1000);
        setInterval(updateDate, 1000);

        // Initial call to display clock immediately
        updateClock();
        updateDate();
    </script>

</body>
</html>