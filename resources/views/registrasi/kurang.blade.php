	@extends('layouts.default')

@section('title', 'Kontrak Akad Sertifikasi Halal')

@push('css')
	<link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <!-- begin breadcrumb -->
	<ol class="breadcrumb float-xl-right">
		<li class="breadcrumb-item">Registrasi</li>
		<li class="breadcrumb-item active">Pembayaran Registrasi Halal</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Pembayaran Registrasi Halal<small></small></h1>
	<!-- end page-header -->
	<!-- begin row -->
	<div class="row">
		<!-- begin col-12 -->
		<div class="col-xl-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-plugins-7">
				<!-- begin panel-heading -->
				<div class="panel-heading">
					<h4 class="panel-title">Pembayaran Registrasi Halal</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
				</div>
				<!-- end panel-heading -->
				<!-- begin panel-body -->
				<div class="panel-body panel-form">
					<form action="{{route('registrasi.uploadkurang',['id' => $data->id])}}" method="post"  class="form-horizontal form-bordered" enctype="multipart/form-data">
						@csrf
						@method('PUT')
						<div class="form-group row" >
							<label class="col-lg-4 col-form-label">No Registrasi</label>
							<div class="col-lg-8">
								<input type="text" name="id" value="{{$data->id}}" hidden readonly>
								<input type="text" class="form-control" name='no_registrasi' value="{{$data->no_registrasi}}" readonly/>
							</div>
							@if($tahap == 1)
								<label class="col-lg-4 col-form-label">Nominal Pembayaran Tahap 1</label>
								<div class="col-lg-8">
									<input type="text" name="status" value="10" hidden readonly>
									<input type="text" class="form-control" name='nominal_tahap1' value="{{number_format($dataP->nominal_tahap1,0,",",".")}}" readonly/>
								</div>

							@elseif($tahap == 2)
								<label class="col-lg-4 col-form-label">Nominal Pembayaran Tahap 2</label>
								<div class="col-lg-8">
									
									<input type="text" name="status" value="h" hidden readonly>
									<input type="text" class="form-control" name='nominal_tahap2' value="{{number_format($dataP->nominal_tahap2,0,",",".")}}" readonly/>
								</div>

							@elseif($tahap == 3)
								<label class="col-lg-4 col-form-label">Nominal Pembayaran Tahap 3</label>
								<div class="col-lg-8">
									<input type="text" name="status" value="22" hidden readonly>
									<input type="text" class="form-control" name='nominal_tahap3' value="{{number_format($dataP->nominal_tahap3,0,",",".")}}" readonly/>
								</div>

							@endif


							@if($tahap == 1)
								<label class="col-lg-4 col-form-label">Nominal Kurang</label>
								<div class="col-lg-8">
								
									<input type="text" class="form-control" name="kurang_tahap1" id="nominal_kurang1" required/>
								</div>

							@elseif($tahap == 2)
								<label class="col-lg-4 col-form-label">Nominal Kurang</label>
								<div class="col-lg-8">
								
									<input type="text" class="form-control" name="kurang_tahap2" id="nominal_kurang2" required/>
								</div>

							@elseif($tahap == 3)
								<label class="col-lg-4 col-form-label">Nominal Kurang</label>
								<div class="col-lg-8">
								
									<input type="text" class="form-control" name="kurang_tahap3" id="nominal_kurang3" required/>
								</div>

							@endif
							
							
							
							<div class="col-md-12 offset-md-5">
								
							
								@component('components.buttonback',['href' => url()->previous()])@endcomponent	
								
								<button type="submit" class="btn btn-sm btn-success m-r-5" >Submit</button>
																
								
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
		if(document.getElementById("nominal_kurang1")){
			var rupiah1 = document.getElementById("nominal_kurang1");
			rupiah1.addEventListener('keyup', function(e){									
				rupiah1.value = formatRupiah(this.value, 'Rp. ');			
			});
		}else if(document.getElementById("nominal_kurang2")){
			var rupiah2 = document.getElementById("nominal_kurang2");	
			rupiah2.addEventListener('keyup', function(e){			
				rupiah2.value = formatRupiah(this.value, 'Rp. ');			
			});
		}else if(document.getElementById("nominal_kurang3")){
			var rupiah3 = document.getElementById("nominal_kurang3");
			rupiah3.addEventListener('keyup', function(e){									
				rupiah3.value = formatRupiah(this.value, 'Rp. ');			
			});
		}		

		/* Fungsi formatRupiah */
		function formatRupiah(angka, prefix){	
			var number_string = angka.replace(/[^,\d]/g, '').toString(),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			rupiah     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if(ribuan){
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}
 
			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? 'Rp.' + rupiah : '');
		}
	</script>

	<script src="{{asset('/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>

    <script src="{{asset('/assets/js/main.js')}}"></script>
    

@endpush