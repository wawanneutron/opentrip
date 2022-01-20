@extends('layouts.succses')
@section('title','Succses Checkout')
    
<!-- succses checkout -->
@section('succses-content')
<main>
  <div class="section-succes d-flex align-items-center">
      <div class="col text-center">
          <div class="animasi-succses">
              <img src="{{ url('frontend/images/ic-succsess.png') }}" alt="" class="mb-2">
              <h1>Yay! Berhasil</h1>
              <p>
                  Kami telah mengirimkan email e-tiket opentrip
                  <br>
                  silahkan cek email masuk
              </p>
          </div>
          <div class="animasi-btn">
              <a href="{{ route('home') }}" class="btn btn-home-page mt-3 px-5">Home Page</a>
          </div>
      </div>
  </div>
</main>
@endsection
