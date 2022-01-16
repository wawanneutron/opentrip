@extends('layouts.app', ['title' => $item->title . ' - ' . $item->location])
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
                                <li class="breadcrumb-item">
                                <a href="{{ route('home') }}">Paket Travel</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Details
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 pl-lg-0">
                        <div class="card card-details">
                            <h1>{{ $item->title }}</h1>
                            <p>{{ $item->location }}</p>
                            @if($item->galleries->count())
                                <!-- galery using xzoom -->
                                <div class="galery">
                                    <div class="xzoom-container">
                                        <img src="{{ Storage::url($item->galleries->first()->image) }}" alt="" class="xzoom"
                                            id="xzoom-default" xoriginal="{{ Storage::url($item->galleries->first()->image) }}">
                                    </div>
                                    <!-- thumbnail -->
                                    <div class="xzoom-thumbs row">
                                        @foreach ($item->galleries as $gallery)
                                            <div class="col-6 col-md-3">
                                                    <a href="{{ Storage::url($gallery->image) }}">
                                                    <img src="{{ Storage::url($gallery->image) }}" alt="" class="xzoom-galery img-thumbnail"
                                                         xpreview="{{ Storage::url($gallery->image) }}">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <div class="about-travel">
                                <h2>Sekilas tentang {{ $item->title }} </h2> <br>
                                <p>{!!  $item->about !!}</p>
                            </div>
                        </div>
                    </div>
                    <!-- Right Content - Members are going -->
                    <div class="col-lg-4">
                        <div class="card card-details card-right">
                            <h3>Member yang bergabung</h3>
                            <div class="members my-2">
                                <img src="{{ url('frontend/images/user-join/user1.png') }}" alt="" class="member-image">
                                <img src="{{ url('frontend/images/user-join/user2.png')}}" alt="" class="member-image">
                                <img src="{{ url('frontend/images/user-join/user3.png')}}" alt="" class="member-image">
                                <img src="{{ url('frontend/images/user-join/user4.png')}}" alt="" class="member-image">
                                <img src="{{ url('frontend/images/user-join/user5.png')}}" alt="" class="member-image">
                            </div>
                            <hr>
                            <h3>Informasi Perjalanan</h3>
                            <table class="trip-informations">
                                <tr>
                                    <th width="50%" class="date">Keberangkatan</th>
                                <td width="50%" class="text-right">{{ \Carbon\Carbon::create($item->deperture_date)->format('F n, Y') }}</td>
                                </tr>
                                <tr>
                                    <th width="50%" class="date">Durasi</th>
                                    <td width="50%" class="text-right">{{ $item->duration }}</td>
                                </tr>
                                <tr>
                                    <th width="50%" class="date">Jenis</th>
                                    <td width="50%" class="text-right">{{ $item->type }}</td>
                                </tr>
                                <tr>
                                    <th width="50%" class="date">Sisa Kuota</th>
                                    <td width="50%" class="text-right">{{ $item->quota }} orang</td>
                                </tr>
                                <tr>
                                    <th width="50%" class="date">Harga</th>
                                    <td width="50%" class="text-right">{{ moneyFormat($item->price) }} / orang </td>
                                </tr>
                            </table>
                            <div class="benefit mt-2">
                                @switch($item->eat or $item->lodging_house)
                                    @case(false)
                                        @break
                                    @case(true)
                                        <hr>    
                                        <h3 style="font-size: 18px">Benefits</h3>
                                    @break
                                    @default
                                @endswitch
                                @switch($item->lodging_house)
                                    @case(true)
                                        <ul style="padding-left: 0;" class="list-unstyled">
                                            <li>👉 Free Penginapan selama opentrip</li>
                                        </ul>
                                        @break
                                    @default
                                @endswitch
                                 @switch($item->eat)
                                    @case(true)
                                        <ul style="padding-left: 0;" class="list-unstyled">
                                            <li style="padding-bottom: 10px;">👉 Free Makan Selama 3x sehari</li>
                                        </ul>
                                        @break
                                    @default
                                @endswitch
                            </div>
                            <hr>
                            <div class="include mt-2">
                                <h3 style="font-size: 18px">Includes</h3>
                                <p style="color: #071c4dc4;">
                                    {!! $item->includes !!}
                                </p>
                            </div>
                            <hr>
                            <div class="exclude mt-2">
                                <h3 style="font-size: 18px">Exclude</h3>
                                <p style="font-size: 16px; color: #071c4dc4; font-weight: 600;">
                                    ❌ yang tidak disebutkan    
                                </p>
                            </div>
                        </div>
                        <!-- CTE -->
                        <div class="join-container">
                            @auth
                            <form action="{{ route('checkout-process', $item->id) }}" method="POST">
                            @csrf
                                    <button class="btn btn-block btn-join-now mt-3 py-2" type="submit">Join Open Trip</button>
                            </form>
                            @endauth
                            @guest
                                <a href="{{ route('login') }}" class="btn btn-block btn-join-now mt-3 py-2">login / register dulu yuk</a>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>          
@endsection

{{-- xzom --}}

@push('prepend-style')
<link rel="stylesheet" href="{{ url('/frontend/libraries/xzoom/xzoom.css') }}">
    
@endpush

@push('addon-script')
<script src="{{ url('frontend/libraries/xzoom/xzoom.min.js') }}"></script>
<script>
  $(document).ready(function () {
      $('.xzoom, .xzoom-galery').xzoom({
          zoomWidth: 500,
          title: false,
          tint: '#333',
          Xoffset: 15,
      });
  });
</script>
@endpush