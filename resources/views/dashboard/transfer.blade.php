<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>transfer</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // After 2 seconds, remove the success message
            setTimeout(function() {
                var successMessage = document.getElementById('success-message');
                if (successMessage) {
                    successMessage.remove();
                }
            }, 2000); // 2000 milliseconds = 2 seconds
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
            }, 4000); // 2000 milliseconds = 2 seconds
        });
    </script>
</head>

<body>

    @include('components.nav')

    <!-- <div id="success-message" class="alert alert-success" style="background-color:#C7CD8C;">

    </div>

    <div id="error-message" class="alert alert-danger" style="background-color:#ff9999" >

    </div> -->
    @auth

    @if(session('success'))
    <div id="success-message" class="alert alert-success" style="background-color:#C7CD8C;">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div id="error-message" class="alert alert-danger" style="background-color:#ff9999">
        {{ session('error') }}
    </div>
    @endif
    <div style="margin-left:450px; margin-top:100px;">
        <h1><label for="price" class="block text-xl font-medium leading-6 text-gray-900">Transfer Money</label></h1><br>
        <div class="relative mt-2 rounded-md shadow-sm">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <span class="text-gray-500 sm:text-sm"></span>
            </div>

            <form action="/transfer" method="POST">
                @csrf
                <label class="block text-xl font-xs leading-6 text-gray-900">Email</label>
                <input style="width:400px;" type="email" name="email" id="email" class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="enter the email" value="{{ old('email') }}">
                @error('email')
                <span class="text-red-500">{{ $message }}</span>
                @enderror<br>

                <label class="block text-xl font-xs leading-6 text-gray-900">Amount</label>
                <input style="width:400px;" type="number" name="transfers" id="transfers" class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="enter the amount" value="{{ old('transfers') }}">
                <span class="text-red-500"></span>
                @error('transfers')
                <span class="text-red-500">{{ $message }}</span>
                @enderror<br>
                <button type="submit" class="custom-button bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ">Submit</button>

        </div>
    </div>
    @endauth
</body>

</html>
