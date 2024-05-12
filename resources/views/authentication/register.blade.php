<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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


  
    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        @if(session('error'))
        {{session('error')}}
        @endif
        <form class="space-y-6" action="/register" method="POST">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                <div class="mt-2">
                    <input id="name" name="name" type="text" autocomplete="name" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    @error('name')
                    <span class="text-red-500">{{ $message }}</span>
                    @enderror

                </div>

            </div>
            <div>
                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                <div class="mt-2">
                    <input id="email" name="email" type="email" autocomplete="email" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    @error('email')
                    <span class="text-red-500">{{ $message }}</span>
                    @enderror

                </div>

            </div>

            <div>
                <div class="flex items-center justify-between">
                    <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                    <div class="text-sm">
                        <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500"></a>
                        @error('password')
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                <div class="mt-2">
                    <input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>

            <div>
                <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign in</button>
            </div>
        </form>

        <p class="mt-10 text-center text-sm text-gray-500">

            <a href="/login" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Already have an account</a>
        </p>
    </div>
    </div>

</body>

</html>
