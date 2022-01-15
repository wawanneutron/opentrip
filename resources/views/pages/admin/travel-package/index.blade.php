@extends('layouts.admin')

@section('content')
    <!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Paket Travel</h1>
    <a href="{{ route('travel-package.create') }}" class="btn btn-sm btn-primary shadow-sm">
      <i class="fas fa-plus fa-sm text-white-50"></i>Tambah Paket travel
    </a>
  </div>
  <div class="row">
    <div class="col-lg pl-lg-0">
      <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-responsive-sm" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Judul</th>
              <th>Kuota</th>
              <th>Lokasi</th>
              <th>Type</th>
              <th>Tgl Keberangkatan</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($items as $index => $item)
            <tr>
              <td>{{ $index +1 }}</td>
              <td> {{ $item->title }} </td>
              <td> {{ $item->quota }} </td>
              <td> {{ $item->location }} </td>
              <td> {{ $item->type }} </td>
              <td> {{ $item->deperture_date }} </td>
              <td>
                <a href="{{ route('travel-package.edit', $item->id) }}" class="btn btn-info">
                  <i class="fa fa-pencil-alt"></i>
                </a>
                  <form action="{{ route('travel-package.destroy', $item->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('delete')
                    <button class="btn btn-danger">
                      <i class="fa fa-trash"></i>
                    </button>
                  </form>
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
