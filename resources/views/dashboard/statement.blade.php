<!DOCTYPE html>
<html>
<head>
<script src="https://cdn.tailwindcss.com"></script>
<style>

table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 75%;
  margin: 0 auto;
  margin-top: 40px;
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
<div class="text-2xl text-center mt-10">BANK STATEMENT</div>

<table>
  <tr>
  <th>Date</th>
    <th>Time</th>

    <th>Deposits</th>
    <th>Withdrawals</th>
    <th>Transferred to</th>
    <th>Transferred Amount</th>

    <!-- <th>Wihdrawals</th> -->
  </tr>
  @foreach($details as $detail)
  <tr>
  <td>{{ $detail->created_at->format('d-m-Y')}}</td>
    <td>{{$detail->created_at->diffForHumans()}}</td>

    <td>{{$detail->deposits}}</td>
    <td>{{$detail->withdrawals}}</td>
    <td>{{$detail->email}}</td>
    <td>{{$detail->transfers}}</td>
  </tr>
  @endforeach
  <tr>
  <th>Current Balance</th>
  <td>{{$currentTransactions}}</td>
  </tr>


</table>
<div class="my-8 flex justify-center">

{{ $details->links() }}

</div>

@endauth
</body>

</html>

