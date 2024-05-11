<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
@auth
<body>
    @include('components.nav')

<table class="table-auto" style="margin-left:00px;margin-top:00px;width:500px;">
  <thead>
    <tr>
      <th class="bg-gray-200 border border-gray-400 px-4 py-2" colspan="2">WELCOME </th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="border border-gray-400 px-4 py-2">Name</td>
      <td class="border border-gray-400 px-4 py-2">{{auth()->user()->name}}</td>
    </tr>

    <tr>
        <td class="border border-gray-400 px-4 py-2">Current Balance</td>
        <td class="border border-gray-400 px-4 py-2"> kkk </td>
    </tr>
  </tbody>
</table>
</body>
@endauth
</html>
