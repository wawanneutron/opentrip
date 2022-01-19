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
                    <td>User ID</td>
                    <td>Picture</td>
                    <td>Username</td>
                    <td></td>
                  </tr>
                </thead>

                @forelse ($item->details as $detail)
                  <tbody>
                    <tr>
                      <td class="align-middle">{{ $detail->user->userid }}</td>
                      <td class="align-middle">
                        <img src="https://ui-avatars.com/api/?name={{ $detail->user->username }}" class="rounded-circle"height="60"alt="">
                      </td>
                      <td class="align-middle">
                         {{ $detail->user->username }}
                      </td>
                      <td class="align-middle">
                        @if ($detail->user->id == Auth::user()->id)
                        @else
                            <a onclick="Delete(this.id)" id="{{ $detail->id }}" title="hapus" style="cursor: pointer">
                              <i class="fas fa-fw fa-trash text-danger"></i>
                            </a>
                        @endif
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
        <div class="member mt-5">
          <h3>Ayo ajak temanmu untuk bergabung</h3>
            <!-- form input add member -->
            <form action="{{ route('serch-freand', $item->id) }}" method="POST">
              @csrf
                <div class="row text-center">
                  <div class="col-md-8">
                    <label for="username" class="sr-only">Name</label>
                    <input type="text" name="username" class="form-control mb-2 mt-2" id="username"placeholder="Cari berdasarkan username / userid" required>
                  </div>
                  <div class="col-md-4">
                    <button type="submit" class="btn btn-add-now mb-2 px-5 mt-2">Cari Teman Saya</button>
                  </div>
                </div>
            </form>
            {{-- result serach --}}
            @if (!empty($users))
              <form action="{{ route('checkout-add-friend', $item->id) }}" method="post">
              @csrf
                <div class="who-is-going">
                    <table class="table table-responsive-sm text-center">
                      <thead>
                        <tr>
                          <td>User ID</td>
                          <td>Picture</td>
                          <td>Username</td>
                          <td></td>
                        </tr>
                      </thead>

                      @forelse ($users as $user)
                        <tbody>
                          <tr>
                            <td class="align-middle">{{ $user->userid }}</td>
                            <td class="align-middle">
                              <img src="https://ui-avatars.com/api/?name={{ $user->username }}" class="rounded-circle"height="60"alt="">
                            </td>
                            <td class="align-middle">
                              {{ $user->username }}
                            </td>
                            <td class="align-middle">
                              <input type="hidden" name="users_id" value="{{ $user->id }}">
                              <button type="submit" class="btn btn-sm btn-add-now mb-2"><i class="fas fa-plus" title="tambahkan"></i></button>
                            </td>
                          </tr>
                        </tbody>
                      @empty
                          <tr>
                            <td class="text-center" colspan="6">Teman mu tidak ada disitem kami, <br> segera melakukan registrasi terlebih dahulu agar terdaftar disitem kami</td>
                          </tr>
                      @endforelse
                    </table>
                </div>
              </form>
            @endif
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
                              <span class="text-orange">{{ mt_rand(0,99) }}</span>
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
                  @if ($cek_member > $cek_kuota)
                    <!-- CTE -->
                    <div class="join-container">
                        <a href="{{ route('checkout-succses', $item->id) }}" class="btn btn-block btn-join-now mt-3 py-2">Kuota Tidak Cukup</a>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('details', $item->travel_package->slug) }}" class="text-muted mt-3 py-2">Batalkan
                            Pembayaran</a>
                    </div>
                  @elseif ($cek_kuota == 0)
                     <!-- CTE -->
                    <div class="join-container">
                        <a href="{{ route('checkout-succses', $item->id) }}" class="btn btn-block btn-join-now mt-3 py-2">Kuota Sudah Habis</a>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('details', $item->travel_package->slug) }}" class="text-muted mt-3 py-2">Batalkan
                            Pembayaran</a>
                    </div>
                  @else
                    <!-- CTE -->
                    <div class="join-container">
                        <a href="{{ route('checkout-succses', $item->id) }}" class="btn btn-block btn-join-now mt-3 py-2">Lanjut ke Pembayaran</a>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('details', $item->travel_package->slug) }}" class="text-muted mt-3 py-2">Batalkan
                            Pembayaran</a>
                    </div>
                  @endif
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

@push('prepend-script')
    <script>
        //ajax delete switalert
        function Delete(id) {
            var id = id;
            var token = $("meta[name='csrf-token']").attr("content");
            swal({
                title: "Ingin batal mengajak teman?",
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
                        url: "{{ url('checkout/remove') }}/" + id,
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