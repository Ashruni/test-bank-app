<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // After 2 seconds, remove the success message
            setTimeout(function() {
                var successMessage = document.getElementById('success-message');
                if (successMessage) {
                    successMessage.remove();
                }
            }, 5000); // 2000 milliseconds = 2 seconds
        });
    </script>
    <script>
        // Wait for the DOM to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            // After 2 seconds, remove the error message
            setTimeout(function() {
                var errorMessage = document.getElementById('error-message');
                if (errorMessage) {
                    errorMessage.remove();
                }
            }, 5000); // 2000 milliseconds = 2 seconds
        });
    </script>
</head>

<body class="h-full">
    <div class="min-h-full">
    @guest
        @include('components.nav')

        <header class="bg-white shadow">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">ADFC BANK</h1>
            </div>
        </header>
        @endguest
        @auth
        @include('components.nav')
        @if(session('success'))
    <div id="success-message" class="alert alert-success" style="background-color:#98a4d5;">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div id="error-message" class="alert alert-danger" style="background-color:#ff9999">
        {{ session('error') }}
    </div>
    @endif


        <header class="bg-white shadow">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">ADFC BANK</h1>
            </div>
        </header>
        @endauth
    </div>
</body>

</html>
