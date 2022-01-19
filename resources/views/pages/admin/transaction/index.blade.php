@extends('layouts.admin')

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
            @forelse ($items as $index => $item)
              <tr>
                <td>{{ $index +1 }}</td>
                <td> {{ $item->kd_transaction }} </td>
                <td> {{ $item->travel_package->title }} </td>
                <td> {{ $item->user->name }} </td>
                <td> {{ moneyFormat($item->transaction_total) }} </td>
                <td> {{ $item->transaction_status }} </td>
                <td>
                  <a href="{{ route('admin.transaction.show', $item->id) }}" class="btn btn-primary">
                    <i class="fa fa-eye"></i>
                  </a>
                  <button onclick="Delete(this.id)" id="{{ $item->id }}" class="btn btn-danger">
                    <i class="fa fa-trash"></i>
                  </button>
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

@push('addon-script')
    <script>
        //ajax delete switalert
        function Delete(id) {
            var id = id;
            var token = $("meta[name='csrf-token']").attr("content");
            swal({
                title: "Yakin ingin hapus?",
                // text: "Menghapus data ini akan menghapus data yang saling terhubung!",
                icon: "warning",
                buttons: [
                    'TIDAK',
                    'YA'
                ],
                dangerMode: true,
            }).then(function(isConfirm) {
                if (isConfirm) {
                    //ajax delete
                    jQuery.ajax({
                        url: "{{ route('admin.transaction.index') }}/" + id,
                        data: {
                            "id": id,
                            "_token": token
                        },
                        type: 'DELETE',
                        success: function(response) {
                            if (response.status == "success") {
                                swal({
                                    title: 'BERHASIL!',
                                    text: 'DATA BERHASIL DIHAPUS!',
                                    icon: 'success',
                                    timer: 1000,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    buttons: false,
                                }).then(function() {
                                    location.reload();
                                });
                            } else {
                                swal({
                                    title: 'GAGAL!',
                                    text: 'DATA GAGAL DIHAPUS!',
                                    icon: 'error',
                                    timer: 1000,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    buttons: false,
                                }).then(function() {
                                    location.reload();
                                });
                            }
                        }
                    });
                } else {
                    return true;
                }
            })
        }

    </script>
@endpush