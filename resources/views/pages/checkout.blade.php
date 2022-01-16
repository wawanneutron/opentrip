@extends('layouts.checkout')
@section('title','Checkout')
    
@section('content')
<!-- detaiils -->
<main>
  <section class="section-details-header"></section>
  <section class="section-details-content">
      <div class="container">
        <div class="row ml-1">
          <div class="col p-0">
            <nav>
              <ol class="breadcrumb">
                <li class="breadcrumb-item"> <a href="{{ route('home') }}">Paket Travel</a></li>
              <li class="breadcrumb-item"> <a href="{{ route('details',$item->travel_package->slug) }}">Details</a></li>
                <li class="breadcrumb-item active">Checkout</li>
              </ol>
            </nav>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-8 pl-lg-0">
            <div class="card card-details">

              @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                      <li> {{ $error }} </li>    
                    @endforeach
                  </ul>
              </div>
              @endif

              <h1 style="font-size: 23px">Siapa yang akan kamu ajak pergi?</h1>
                <p>OpenTrip ke <b>{{ ($item->travel_package->title) }}</b>,
                    <b>{{ ($item->travel_package->location) }}</b></p>

            <div class="who-is-going">
              <table class="table table-responsive-sm text-center">
                <thead>
                  <tr>
                    <td>Picture</td>
                    <td>Username</td>
                    <td></td>
                  </tr>
                </thead>

                @forelse ($item->details as $detail)
                  <tbody>
                    <tr>
                      <td>
                        <img src="https://ui-avatars.com/api/?name={{ $detail->username }}" class="rounded-circle"height="60"alt="">
                      </td>
                      <td class="align-middle">
                         {{ $detail->username }}
                      </td>
                      <td class="align-middle">
                        <a href="{{ route('checkout-remove', $detail->id) }}">
                          <i class="fas fa-fw fa-trash"></i>
                        </a>
                      </td>
                     </tr>
                  </tbody>
                @empty
                    <tr>
                      <td class="text-center" colspan="6">No Visitor</td>
                    </tr>
                @endforelse
              </table>
            </div>

                <!-- add member -->
        <div class="member mt-3">
          <h3>Ajak teman untuk bergabung</h3>
            <!-- form input add member -->
            <form action="{{ route('checkout-create', $item->id) }}" method="POST">
              @csrf
                <div class="row">
                  <div class="col-md-8">
                    <label for="username" class="sr-only">Name</label>
                    <input type="text" name="username" class="form-control mb-2 mt-2 mr-2 " id="username"placeholder="Username" required>
                  </div>
                  <div class="col-md-4">
                    <button type="submit" class="btn btn-add-now mb-2 px-4 mt-2">Tambahkan</button>
                  </div>
                </div>
            </form>
            <!-- note -->
            <div class="bg alert-primary">
                <h3 class="mt-4 mb-0 ml-3">Note :</h3>
                <p class="note mb-0 mt-2 m-3">
                    Anda hanya dapat menambahkan anggota yang telah terdaftar di sistem kami
                </p>
                  </div>
              </div>
          </div>
        </div>
              <!-- Right Content - Members are going -->
              <div class="col-lg-4">
                  <div class="card card-details card-right">
                      <h3>Informasi Pembayaran</h3>
                      <table class="trip-informations">
                          <tr>
                              <th width="50%" class="date">Member</th>
                              <td width="50%" class="text-right">{{ $item->details->count() }} orang</td>
                          </tr>
                          <tr>
                              <th width="50%" class="date">Harga Opentrip</th>
                              <td width="50%" class="text-right">{{ moneyFormat($item->travel_package->price) }} / orang</td>
                          </tr>
                          <tr>
                              <th width="50%" class="date">Sub Total</th>
                              <td width="50%" class="text-right"> {{ moneyFormat($item->transaction_total) }} </td>
                          </tr>
                          <tr>
                              <th width="50%" class="date">Harus Dibayar (+Unique)</th>
                              <td width="50%" class="text-right text-total">
                                  <span class="text-blue">{{ moneyFormat($item->transaction_total) }},</span>
                              <span class="text-orange">{{ mt_rand(0,999) }}</span>
                              </td>

                          </tr>
                      </table>
                      <hr>
                      <!-- payments -->
                      <h3>Instruksi Pembayaran</h3>
                      <p class="payment-instructions">
                            Anda akan diarahkan ke halaman lain untuk membayar menggunakan GO-PAY</p>
                    <img src="{{ url('frontend/images/gopay.png') }}" class="w-50" alt="">
                  </div>
                  <!-- CTE -->
                  <div class="join-container">
                      <a href="{{ route('checkout-succses', $item->id) }}" class="btn btn-block btn-join-now mt-3 py-2">Lanjut ke Pembayaran</a>
                  </div>
                  <div class="text-center mt-3">
                      <a href="{{ route('details', $item->travel_package->slug) }}" class="text-muted mt-3 py-2">Batalkan
                          Pembayaran</a>
                  </div>
              </div>
          </div>
      </div>
  </section>
</main>
@endsection

@push('prepend-style')
<link rel="stylesheet" href="{{ url('frontend/libraries/gijgo/css/gijgo.min.css') }}">
@endpush

@push('addon-script')
<script src="{{ url('frontend/libraries/gijgo/js/gijgo.min.js') }}"></script>
<script>
  $(document).ready(function () {
      $('.datepicker').datepicker({
          format: 'yyyy-mm-dd',
          uiLibrary: 'bootstrap4'
          // jika ingin mengcustom icon
          // icons: {
          //     rightIcon: '<img src="/frontend/images/ic_calender.png" />'
          // }
      });
  });
</script>
@endpush