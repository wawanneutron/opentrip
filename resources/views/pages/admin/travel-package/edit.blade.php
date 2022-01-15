@extends('layouts.admin')

@section('content')
    <!-- Begin Page Content -->
<div class="container-fluid">
  
  @if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
        <li> {{ $error }} </li>    
      @endforeach
    </ul>
  </div>  
  @endif
 

  <div class="card shadow">
    <div class="card-header"> 
      <h1 class="h4 mb-0 text-gray-800">Edit Paket Travel</h1>
    </div>
    <div class="card-body">
      <form action="{{ route('admin.travel-package.update', $item->id) }}" method="POST">
        @csrf
        @method('put')
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="title">Judul Opentrip</label>
              <input type="text" class="form-control" name="title" placeholder="Gunung Semeru Indonesia" value="{{ old('title') ?? $item->title }}">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="location">location</label>
              <input type="text" class="form-control" name="location" placeholder="Location" value="{{ old('location') ?? $item->location }}">
            </div>
          </div>
          <div class="col-md-3 mt-2">
            <div class="form-group">
              <label for="quota">Kuota</label>
              <input type="number" class="form-control" name="quota" placeholder="quota" value="{{ old('quota') ?? $item->quota }}">
            </div>
          </div>
          <div class="col-md-3 mt-2">
            <div class="form-group">
              <label for="type">Type</label>
              <input type="text" class="form-control" name="type" placeholder="Open Trip" value="{{ old('type') ?? $item->type }}">
            </div>
          </div>
          <div class="col-md-3 mt-2">
            <div class="form-group">
              <label for="deperture_date">Tanggal Keberangkatan</label>
              <input type="date" class="form-control" name="deperture_date" placeholder="Departure Date" value="{{ old('deperture_date') ?? $item->deperture_date }}">
            </div>
          </div>
          <div class="col-md-3 mt-2">
            <div class="form-group">
              <label for="duration">Lama Perjalanan</label>
              <input type="text" class="form-control" name="duration" placeholder="Duration" value="{{ old('duration') ?? $item->duration }}">
            </div>
          </div>
          <div class="col-md-4 mt-2">
            <div class="form-group">
              <label for="type">Harga</label>
              <input type="number" class="form-control" name="price" placeholder="Price" value="{{ old('price') ?? $item->price }}">
            </div>
          </div>
          <div class="col-md-4 mt-2">
            <div class="form-group">
              <label for="culture">Include Penginapan</label> <br>
              <div class="form-check form-check-inline mt-2 mr-5">
                <input class="form-check-input" type="radio" name="lodging_house" id="penginapanTrue" value="true" {{ $item->lodging_house == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="penginapanTrue">Ya</label>
              </div>
              <div class="form-check form-check-inline mt-2">
                <input class="form-check-input" type="radio" name="lodging_house" id="penginapanFalse" value="false" {{ $item->lodging_house == 0 ? 'checked' : '' }}>
                <label class="form-check-label" for="penginapanFalse">Tidak</label>
              </div>
            </div>
          </div>
          <div class="col-md-4 mt-2">
            <div class="form-group">
              <label for="canton">Include Makan 3x Sehari</label> <br>
              <div class="form-check form-check-inline mt-2 mr-5">
                <input class="form-check-input" type="radio" name="eat" id="makanTrue" value="true" {{ $item->eat == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="makanTrue">Ya</label>
              </div>
              <div class="form-check form-check-inline mt-2">
                <input class="form-check-input" type="radio" name="eat" id="makanFalse" value="false" {{ $item->eat == 0 ? 'checked' : '' }}>
                <label class="form-check-label" for="makanFalse">Tidak</label>
              </div>
            </div>
          </div>
          <div class="col-12 mt-2">
            <div class="form-group">
              <label for="about">About</label>
              <textarea name="about" id="About" rows="10" class="d-block w-100 form-control">{{ old('about') ?? $item->about }}</textarea>
            </div>
          </div>
        </div>
          <button class="btn btn-primary btn-block" type="submit">
            Simpan
          </button>
      </form>
    </div>
  </div>
</div>

@endsection
