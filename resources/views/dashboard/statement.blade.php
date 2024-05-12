<!DOCTYPE html>
<html>
<head>
<script src="https://cdn.tailwindcss.com"></script>
<style>

table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>
    @include('components.nav')
@auth
<!-- <h1>BANK STATEMENT</h1> -->

<table>
  <tr>
    <th>Date</th>
    <th>Deposits</th>
    <th>Withdrawals</th>
    <th>Transfers</th>
    <!-- <th>Wihdrawals</th> -->
  </tr>
  @foreach($details as $detail)
  <tr>
    <td>{{$detail->created_at->diffForHumans()}}</td>
    <td>{{$detail->deposits}}</td>
    <td>{{$detail->withdrawal}}</td>
    <td>{{$detail->transfers}}</td>
  </tr>
  @endforeach

</table>
<div class="my-8">

{{ $details->links() }}

</div>
@endauth
</body>

</html>

