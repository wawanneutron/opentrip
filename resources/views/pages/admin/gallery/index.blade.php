@extends('layouts.admin')

@section('content')
    <!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Gallery</h1>
    <a href="{{ route('admin.gallery.create') }}" class="btn btn-sm btn-primary shadow-sm">
      <i class="fas fa-plus fa-sm text-white-50"></i>Tambah Gallery
    </a>
  </div>
  <div class="row">
    <div class="col-lg">
      <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-responsive-sm" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>ID</th>
              <th>Travel</th>
              <th>Gambar</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($items as $item)
            <tr>
              <td> {{ $item->id }} </td>
              <td> {{ $item->travel_package->title }} </td>
              <td>
              <img src="{{ Storage::url($item->image) }}" alt="" style="width: 150px" class="img-thumbnail">
              </td>

              <td>
              <a href="{{ route('admin.gallery.edit', $item->id) }}" class="btn btn-info">
                <i class="fa fa-pencil-alt"></i>
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
                        url: "{{ route('admin.gallery.index') }}/" + id,
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
