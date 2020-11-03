@extends('layouts.default')

@section('title', 'Pembayaran Registrasi')

@push('css')
	<link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <!-- begin breadcrumb -->
	<ol class="breadcrumb float-xl-right">
		<li class="breadcrumb-item">Registrasi</li>
		<li class="breadcrumb-item active">Pembayaran Registrasi</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Pembayaran Registrasi<small></small></h1>
	<!-- end page-header -->
	<!-- begin row -->
	<div class="row">
		<!-- begin col-12 -->
		<div class="col-xl-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-plugins-7">
				<!-- begin panel-heading -->
				<div class="panel-heading">
					<h4 class="panel-title">Pembayaran Registrasi</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
				</div>
				<!-- end panel-heading -->
				<!-- begin panel-body -->
				<div class="panel-body panel-form">
					<form action="{{route('registrasi.konfirmasipembayaran',["id" => $data->id])}}" method="post"  class="form-horizontal form-bordered" enctype="multipart/form-data">
						@csrf
						@method('PUT')
						<div class="form-group row" >
							<label class="col-lg-4 col-form-label">No Registrasi</label>
							<div class="col-lg-8">
								<input type="text" name="id" value="{{$data->id}}" hidden readonly>
								<input type="text" class="form-control" name='no_registrasi' value="{{$data->no_registrasi}}" readonly/>
							</div>
							<label class="col-lg-4 col-form-label">Metode Pembayaran</label>
							<div class="col-lg-8">
								<div class="radio radio-css radio-inline">
									<input type="radio" name="metode_pembayaran" id="metodePembayaran1" value="tunai" {{ $data->metode_pembayaran == "tunai" ? 'checked' : 'disabled'}}  />
									<label for="metodePembayaran1">Tunai</label>
								</div>
								<div class="radio radio-css radio-inline">
									<input type="radio" name="metode_pembayaran" id="metodePembayaran2" value="transfer" {{ $data->metode_pembayaran == "transfer" ? 'checked' : 'disabled'}} />
									<label for="metodePembayaran2">Transfer</label>
								</div>
							</div>
							<label class="col-lg-4 col-form-label">Tanggal Pembayaran</label>
							<div class="col-lg-8">
								<input id="tgl_pembayaran" name="tgl_pembayaran" type="text" class="form-control" {{ $data->status_pembayaran == 1 ? 'disabled' : ''}} />
							</div>
							<label class="col-lg-4 col-form-label">Biaya Registrasi</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" placeholder="Biaya Registrasi" required value="Rp 220,000" disabled/>
							</div>
							@if($data->status_pembayaran == 1)
								<!--Auto Download-->
								<label class="col-lg-4 col-form-label">Bukti Pembayaran</label>
								<div id="sh" class="col-lg-8">
									<div class="form-control" readonly>
										<a href="{{url('') .Storage::url('public/buktipembayaran/'.Auth::user()->id.'/'.$data->bukti_pembayaran) }}" download>{{$data->bukti_pembayaran}}</a>
									</div>
								</div>
								<label class="col-lg-4 col-form-label">Upload Bukti Pembayaran</label>
								<div class="col-lg-8">
									<input type="file"  name="file" oninvalid="this.setCustomValidity('File bukti pembayaran masih kosong')" oninput="setCustomValidity('')" onchange="getValue(this)" accept="image/*" required />
								</div>
							@elseif($data->status_pembayaran == 2)	
								<!--Auto Download-->
								<label class="col-lg-4 col-form-label">Bukti Pembayaran</label>
								<div id="sh" class="col-lg-8">
									<div class="form-control" readonly>
										<a href="{{url('') .Storage::url('public/buktipembayaran/'.Auth::user()->id.'/'.$data->bukti_pembayaran) }}" download>{{$data->bukti_pembayaran}}</a>
									</div>
								</div>
							@else
								<label class="col-lg-4 col-form-label">Upload Bukti Pembayaran</label>
								<div class="col-lg-8">
									<input type="file"  name="file" oninvalid="this.setCustomValidity('File bukti pembayaran masih kosong')" oninput="setCustomValidity('')" onchange="getValue(this)" accept="image/*" required />
								</div>
							@endif

							@if($data->metode_pembayaran == 'tunai')
								<!--Tunai/Transfer Info-->
	                            <label id="ltunai" class="col-lg-4 col-form-label">Cara Pembayaran Tunai</label>
	                            <div id="dtunai" class="col-lg-8">
	                                <div id="accordionTunai" class="accordion">
	                                    @foreach($dataTunai as $index => $value)
	                                        <!-- begin card -->
	                                        <div class="card">
	                                            <div class="card-header pointer-cursor d-flex align-items-center" data-toggle="collapse" data-target="#collapse{{$value['id']}}" style="cursor: pointer; padding: 2px 5px;">
	                                                <img class="animated bounceIn " src="{{asset('/assets/img/user/reg-info.png')}}" alt="" style="height: 30px;margin-right: 10px;"> 
	                                                <span class="faq-ask">{{ucwords($value['question'])}}</span>
	                                            </div>
	                                            <div id="collapse{{$value['id']}}" class="collapse" data-parent="#accordionTunai">
	                                                <div class="card-body">
	                                                    <?php echo html_entity_decode($value['answer'])?>
	                                                </div>
	                                            </div>
	                                        </div>
	                                    @endforeach
	                                </div>
	                            </div>
							@else
								<label id="ltransfer" class="col-lg-4 col-form-label">Cara Pembayaran Transfer</label>
	                            <div id="dtransfer" class="col-lg-8">
	                                <div id="accordionTransfer" class="accordion">
	                                    @foreach($dataTransfer as $index => $value)
	                                        <!-- begin card -->
	                                        <div class="card">
	                                            <div class="card-header pointer-cursor d-flex align-items-center" data-toggle="collapse" data-target="#collapse{{$value['id']}}" style="cursor: pointer; padding: 2px 5px">
	                                                <img class="animated bounceIn " src="{{asset('/assets/img/user/reg-info.png')}}" alt="" style="height: 30px;margin-right: 10px;"> 
	                                                <span class="faq-ask">{{ucwords($value['question'])}}</span>
	                                            </div>
	                                            <div id="collapse{{$value['id']}}" class="collapse" data-parent="#accordionTransfer">
	                                                <div class="card-body">
	                                                    <?php echo html_entity_decode($value['answer'])?>
	                                                </div>
	                                            </div>
	                                        </div>
	                                    @endforeach
	                                </div>
	                            </div>
							@endif
								<div class="col-md-12 offset-md-5">
									
									@if($data->metode_pembayaran == 'tunai')
										@component('components.buttonback',['href' => route("registrasiHalal.index")])@endcomponent
									@else
										@component('components.buttonback',['href' => route("registrasiHalal.index")])@endcomponent	
										@if($data->status_pembayaran == 1)
											<button type="submit" class="btn btn-sm btn-primary m-r-5">Konfirmasi</button>
											<button type="submit" class="btn btn-sm btn-warning m-r-5" disabled>Pembayaran Sedang Diproses</button>
										@elseif($data->status_pembayaran == 2)
											<button type="submit" class="btn btn-sm btn-success m-r-5" disabled>Pembayaran Sudah Dikonfirmasi</button>
										@else
											<button type="submit" class="btn btn-sm btn-primary m-r-5">Konfirmasi</button>
										@endif								
									@endif
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
    	//var date = new Date();
        var today = new Date();
    	$('#tgl_pembayaran').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
        });
        $('#tgl_pembayaran').datepicker('setDate', today);
    </script>

@endpush