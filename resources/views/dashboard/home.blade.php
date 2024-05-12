<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
@auth

<body>
    @include('components.nav')




    <table class="table-auto" style="margin-left:00px;margin-top:00px;width:500px;">
        <thead>
            <tr>
                <th class="bg-gray-200 border border-gray-400 px-4 py-2" colspan="2">WELCOME BACK</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="border border-gray-400 px-4 py-2">Name</td>
                <td class="border border-gray-400 px-4 py-2">{{auth()->user()->name}}</td>
            </tr>

            <tr>
                <td class="border border-gray-400 px-4 py-2">Current Balance</td>
                <td class="border border-gray-400 px-4 py-2"> {{$totalBalances}} </td>
            </tr>
        </tbody>
    </table>
</body>
@endauth

</html>
