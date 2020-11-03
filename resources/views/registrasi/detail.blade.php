@extends('layouts.default')

@section('title', 'Detail Registrasi Halal')

@push('css')
@endpush

@section('content')
    <!-- begin breadcrumb -->
	<ol class="breadcrumb float-xl-right">
		<li class="breadcrumb-item">Registrasi</li>
		<li class="breadcrumb-item">Registrasi Halal</li>
		<li class="breadcrumb-item active">Detail Registrasi Halal</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Detail Registrasi Halal<small></small></h1>
	<!-- end page-header -->
	<!-- begin row -->
	<div class="row">
		<!-- begin col-12 -->
		<div class="col-xl-12">
            <!-- begin panel -->
            @foreach($data as $index => $value)
			<div class="panel panel-inverse" data-sortable-id="form-plugins-7">
				<!-- begin panel-heading -->
				<div class="panel-heading">

					<h4 class="panel-title">Detail Registrasi Halal : {{$value['no_registrasi']}}</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
				</div>
				<!-- end panel-heading -->
				<!-- begin panel-body -->
				<div class="panel-body panel-form">
                    <form class="form-horizontal form-bordered" >
						<div class="form-group row label-detail">
                            
                                @php
                                    $sh = $value['status_halal'] ? $value['status_halal'] : '-';
                                    $shb = $value['sh_berlaku'] ? $value['sh_berlaku'] : '-'; 
                                @endphp

                                @component('components.fordetail',['label' => 'No. Surat Permohonan Sertifikasi','value'=>$value['no_surat']])@endcomponent
                                @component('components.fordetail',['label' => 'No. Registrasi','value'=>$value['no_registrasi']])@endcomponent
                                @component('components.fordetail',['label' => 'Nama','value'=>$value['name']])@endcomponent
                                @component('components.fordetail',['label' => 'Perusahaan','value'=>$value['perusahaan']])@endcomponent
                                @component('components.fordetail',['label' => 'Tanggal Registrasi','value'=>$value['tgl_registrasi']])@endcomponent
                                @component('components.fordetail',['label' => 'Jenis Registrasi','value'=>$value['jenis']])@endcomponent
                                @component('components.fordetail',['label' => 'Status Registrasi','value'=>ucwords($value['status_registrasi'])])@endcomponent
                                @component('components.fordetail',['label' => 'Status Halal Sebelumnya','value'=>$sh])@endcomponent
                                @component('components.fordetail',['label' => 'SH Berlaku s/d','value'=>$shb])@endcomponent
                                <!-- @component('components.fordetail',['label' => 'Status SJPH','value'=>$value['no_surat']])@endcomponent -->
                                @component('components.fordetail',['label' => 'No Sertifikat SJPH','value'=>$value['no_sertifikat']])@endcomponent
                                @component('components.fordetail',['label' => 'SJPH Berlaku s/d','value'=>$value['tgl_sjph']])@endcomponent
                                @component('components.fordetail',['label' => 'Jenis Produk','value'=>$value['jenis_produk']])@endcomponent
                                @component('components.fordetail',['label' => 'Skala Usaha','value'=>ucwords($value['skala_usaha'])])@endcomponent
                                @component('components.fordetail',['label' => 'No. KTP/NPWP','value'=>$value['no_tipe']])@endcomponent
                                @component('components.fordetail',['label' => 'Jenis Izin Usaha','value'=>$value['jenis_izin']])@endcomponent
                                @component('components.fordetail',['label' => 'Jumlah Karyawan','value'=>$value['jumlah_karyawan']])@endcomponent
                                @component('components.fordetail',['label' => 'Kapasitas Produk','value'=>$value['kapasitas_produksi']])@endcomponent
                                @component('components.fordetail',['label' => 'Kelompok Produk','value'=>$value['kelompok']])@endcomponent
                                
                                <!-- @component('components.fordetail',['label' => 'Biaya Registrasi','value'=>$value['biaya_registrasi']])@endcomponent
                                @component('components.fordetail',['label' => 'Metode Pembayaran','value'=>ucwords($value['metode_pembayaran'])])@endcomponent
                                
                                <label class="col-lg-4 col-form-label ">Invoice Registrasi</label>
								<div id="sh" class="col-lg-8">
										<div class="form-control" readonly>
											<a href="{{url('') .Storage::url('public/registrasi/'.$value['inv_registrasi']) }}" download>{{$value['inv_registrasi']}}</a>
										</div>
								</div>

                                @if($value['status_pembayaran'] == '1' || $value['status_pembayaran'] == '2' )
									<label class="col-lg-4 col-form-label">Bukti Pembayaran</label>
									<div id="sh" class="col-lg-8">
										<div class="form-control" readonly>
											<a href="{{url('') .Storage::url('public/buktipembayaran/'.Auth::user()->id.'/'.$value['bukti_pembayaran']) }}" download>{{$value['bukti_pembayaran']}}</a>
										</div>
									</div>
								@endif
								<label class="col-lg-4 col-form-label">Status Pembayaran</label>
								<div id="sh" class="col-lg-8">
									<div class="form-control" readonly>
										@if($value['status_pembayaran'] == 2)
											<span style="color: green;">Sudah Dikonfirmasi</span>
										@elseif($value['status_pembayaran'] == 1)
											<span style="color: orange;">Menunggu Konfirmasi</span>
										@else
											<span style="color: red;">Belum Bayar</span>
										@endif
									</div>
								</div>

								@if($value['inv_pembayaran'] == null)
									<label class="col-lg-4 col-form-label">Invoice Pembayaran</label>
									<div id="sh" class="col-lg-8">
											<div class="form-control" readonly>
												-
											</div>
									</div>
								@else
									<label class="col-lg-4 col-form-label">Invoice Pembayaran</label>
									<div id="sh" class="col-lg-8">
											<div class="form-control" readonly>
												<a href="{{url('') .Storage::url('public/pembayaran/'.$value['inv_pembayaran']) }}" download>{{$value['inv_pembayaran']}}</a>
											</div>
									</div>
								@endif -->
								
							<div class="col-md-12 offset-md-5">
								@if(Auth::user()->usergroup_id == 1 ||  Auth::user()->usergroup_id == 3)
									<button type="button"  onclick="window.history.go(-1);" class="btn btn-default"> <i class="fa fa-arrow-left"></i> Kembali</button>	
								@else
									@component('components.buttonback',['href' => route("registrasiHalal.index")])@endcomponent
								@endif	
							</div>
						</div>
					</form>
				</div>
				<!-- end panel-body -->
            </div>
            @endforeach
			<!-- end panel -->
		</div>
		<!-- end col-12 -->
	</div>
	<!-- end row -->
@endsection

@push('scripts')

    

@endpush