@extends('layouts.default')

@section('title', 'Pelunasan Sertifikasi Halal')

@push('css')
	<link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <!-- begin breadcrumb -->
	<ol class="breadcrumb float-xl-right">
		<li class="breadcrumb-item">Pelunasan</li>
		<li class="breadcrumb-item active">Pembayaran Sertifikasi Halal</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Pembayaran Sertifikasi Halal<small></small></h1>
	<!-- end page-header -->
	<!-- begin row -->
	<div class="row">
		<!-- begin col-12 -->
		<div class="col-xl-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-plugins-7">
				<!-- begin panel-heading -->
				<div class="panel-heading">
					<h4 class="panel-title">Pembayaran Sertifikasi Halal</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
				</div>
				<!-- end panel-heading -->
				<!-- begin panel-body -->
				<div class="panel-body panel-form">
					<form action="{{route('registrasi.konfirmasipelunasanuser',["id" => $data->id])}}" method="post"  class="form-horizontal form-bordered" enctype="multipart/form-data">
						@csrf
						@method('PUT')
						<div class="form-group row" >
							<label class="col-lg-4 col-form-label">No Registrasi</label>
							<div class="col-lg-8">
								<input type="text" name="id" value="{{$data->id}}" hidden readonly>
								<input type="text" class="form-control" name='no_registrasi' value="{{$data->no_registrasi}}" readonly/>
							</div>
							<!-- <label class="col-lg-4 col-form-label">Metode Pembayaran</label> -->
							<!-- <div class="col-lg-8">
								<div class="radio radio-css radio-inline">
									<input type="radio" name="metode_pembayaran" id="metodePembayaran1" value="tunai" {{ $data->metode_pembayaran == "tunai" ? 'checked' : 'disabled'}}  />
									<label for="metodePembayaran1">Tunai</label>
								</div>
								 <div class="radio radio-css radio-inline">
									<input type="radio" name="metode_pembayaran" id="metodePembayaran2" value="transfer" {{ $data->metode_pembayaran == "transfer" ? 'checked' : 'disabled'}} />
									<label for="metodePembayaran2">Transfer</label>
								</div> 
							</div> -->
							<label class="col-lg-4 col-form-label">Tanggal Pembayaran Tahap 1</label>
							<div class="col-lg-8">
								<input id="tanggal_tahap1" name="tanggal_tahap1" type="text" class="form-control"  value="{{ $dataP->tanggal_tahap1}} " readonly />
							</div>
							<label class="col-lg-4 col-form-label">Nominal Tahap 1</label>
							
							<div class="col-lg-8">
								<input type="text" class="form-control" value="Rp. {{ $dataP->nominal_tahap1}} " disabled/>
							</div>
							<label class="col-lg-4 col-form-label">Bukti Pembayaran Tahap 1</label>
							<div id="sh" class="col-lg-8">
								<div class="form-control" readonly>
									<a href="{{url('') .Storage::url('public/buktipembayaran/'.Auth::user()->id.'/'.$dataP->bb_tahap1) }}" download>{{$dataP->bb_tahap1}}</a>
								</div>
							</div>
							<label class="col-lg-4 col-form-label">Tanggal Pembayaran Tahap 2</label>
							<div class="col-lg-8">
								<input id="tanggal_tahap2" name="tanggal_tahap3" type="text" class="form-control"  value="{{ $dataP->tanggal_tahap2}} " readonly />
							</div>
							<label class="col-lg-4 col-form-label">Nominal Tahap 2</label>
							
							<div class="col-lg-8">
								<input type="text" class="form-control" value="Rp. {{ $dataP->nominal_tahap2}} " disabled/>

							</div>
							<label class="col-lg-4 col-form-label">Bukti Pembayaran Tahap 2</label>
							<div id="sh" class="col-lg-8">
								<div class="form-control" readonly>
									<a href="{{url('') .Storage::url('public/buktipembayaran/'.Auth::user()->id.'/'.$dataP->bb_tahap2) }}" download>{{$dataP->bb_tahap2}}</a>
								</div>
							</div>
							<label class="col-lg-4 col-form-label">Tanggal Pelunasan</label>
							<div class="col-lg-8">
								<input id="tanggal_tahap3" name="tanggal_tahap3" type="text" class="form-control"  value="{{ $dataP->tanggal_tahap3}} " readonly />
							</div>
							
							<label class="col-lg-4 col-form-label">Nominal Tahap 3</label>
							
							<div class="col-lg-8">
								<input type="text" class="form-control" value="Rp. {{ $dataP->nominal_tahap3}} " disabled/>
							</div>
							<label class="col-lg-4 col-form-label">Bukti Pelunasan</label>
							<div id="sh" class="col-lg-8">
								<div class="form-control" readonly>
									<a href="{{url('') .Storage::url('public/buktipembayaran/'.Auth::user()->id.'/'.$dataP->bb_tahap3) }}" download>{{$dataP->bb_tahap3}}</a>
								</div>
							</div>
							
						
							<label class="col-lg-4 col-form-label">Invoice Pelunasan</label>
							<div id="sh" class="col-lg-8">
								<div class="form-control" readonly>
										<a href="{{url('') .Storage::url('public/INV/'.$data->inv_pembayaran) }}" download>{{$data->inv_pembayaran}}</a>
								</div>
							</div>

							<div class="col-md-12 offset-md-5">
									
									
								@component('components.buttonback',['href' => route("registrasiHalal.index")])@endcomponent	
										
									
							</div>								
							
						</div>
					</form>
				</div>
				<!-- end panel-body -->
			</div>
			<!-- end panel -->
		</div>
		<!-- end col-12 -->
	</div>
	<!-- end row -->
@endsection

@push('scripts')
	<script src="{{asset('/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
    <script type="text/javascript">
    	
    </script>

@endpush