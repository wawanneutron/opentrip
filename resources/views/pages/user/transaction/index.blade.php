@extends('layouts.user')

@section('content')
    <!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Transactions</h1>
  </div>
  <div class="row">
    <div class="col-lg">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-responsive-sm" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode Transaksi</th>
                <th>Open Trip</th>
                <th>Member / User</th>
                <th>Harga Open Trip</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            @forelse ($histories as $index => $item)
              <tr>
                <td>{{ $index +1 }}</td>
                <td> {{ $item->kd_transaction }} </td>
                <td> {{ $item->travel_package->title }} </td>
                <td> {{ $item->user->name }} </td>
                <td> {{ moneyFormat($item->transaction_total )}} </td>
                <td> {{ $item->transaction_status }} </td>
                <td>
                  <a href="{{ route('user.detail-transaction', $item->id) }}" class="btn btn-primary">
                    <i class="fa fa-eye"></i>
                  </a>
                </td>
              </tr>
              @empty
                  <tr>
                    <td colspan="7" class="text-center">
                      Data Kosong
                    </td>
                  </tr>
            @endforelse
            </tbody>
          </table>
        </div>
    </div>
    </div>
    
  </div>


</div>

@endsection
