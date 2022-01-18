@extends('layouts.user')

@section('content')
    <!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-center mb-5">
  <h1 class="h3 mb-0 text-gray-800 ">Details Transactions {{ $item->user->name }}</h1>
  </div>
  
  @if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
        <li> {{ $error }} </li>    
      @endforeach
    </ul>
  </div>  
  @endif
 
<div class="row">
  <div class="col-lg-12 justify-content-center d-flex">
    <div class="card shadow">
      <div class="card-body">
        <table class="table-bordered table-responsive-sm">
            <tr>
               <th>Kode Transaksi</th>
               <td>{{ $item->kd_transaction }}</td>
            </tr>
            <tr>
              <th>Paket Travel</th>
              <td>{{ $item->travel_package->title }}</td>
            </tr>
            <tr>
              <th>Pembeli</th>
              <td>{{ $item->user->name }}</td>
            </tr>
            <tr>
              <th>Total Transaksi</th>
              <td>{{ moneyFormat($item->transaction_total )}}</td>
            </tr>
            <tr>
              <th>Status Transaction</th>
              <td>{{ $item->transaction_status }}</td>
            </tr>
            <tr>
                <th>Pembelian</th>
                <td>
                    <table class="table table-bordered">
                        <tr>
                          @if ($item->transaction_status == 'IN_CART' || $item->transaction_status == 'PENDING')
                            <th>User ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                          @else
                            <th>User ID</th>
                            <th>No Tiket</th>
                            <th>Nama</th>
                            <th>Email</th>
                          @endif
                          </tr>
                        @foreach ($item->details as $detail)
                            <tr>
                              @if ($item->transaction_status == 'IN_CART' || $item->transaction_status == 'PENDING')
                                <td>{{ $detail->user->userid }}</td>
                                <td>{{ $detail->user->username }}</td>
                                <td>{{ $detail->user->email }}</td>
                              @else
                                <td>{{ $detail->user->userid }}</td>
                                <td>{{ $detail->no_ticket }}</td>
                                <td>{{ $detail->user->username }}</td>
                                <td>{{ $detail->user->email }}</td>
                              @endif
                            </tr>
                        @endforeach
                    </table>
                    @if ($item->transaction_status == 'IN_CART')
                      <a href="{{ route('checkout', $item->id) }}" class="btn btn-block btn-primary">Lanjutkan checkout</a>
                    @endif
                </td>
            </tr>
        </table>
      </div>
  </div>
  </div>
</div>
  


</div>

@endsection
