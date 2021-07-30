	@extends('layouts.default')

@section('title', 'Kontrak Akad Sertifikasi Halal')

@push('css')
	<link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <!-- begin breadcrumb -->
	<ol class="breadcrumb float-xl-right">
		<li class="breadcrumb-item">Registrasi</li>
		<li class="breadcrumb-item active">Penawaran dan Kontrak Akad Sertifikasi Halal</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Kontrak Akad Sertifikasi Halal<small></small></h1>
	<!-- end page-header -->
	<!-- begin row -->
	<div class="row">
		<!-- begin col-12 -->
		<div class="col-xl-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-plugins-7">
				<!-- begin panel-heading -->
				<div class="panel-heading">
					<h4 class="panel-title">Kontrak Akad Sertifikasi Halal</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
				</div>
				<!-- end panel-heading -->
				<!-- begin panel-body -->
				<div class="panel-body panel-form">
					<form action="{{route('registrasi.uploadfileakadadmin',['id' => $data->id])}}" method="post"  class="form-horizontal form-bordered" enctype="multipart/form-data">
						@csrf
						@method('PUT')
						<div class="form-group row" >
							<label class="col-lg-4 col-form-label">No Registrasi</label>
							<div class="col-lg-8">
								<input type="text" name="id" value="{{$data->id}}" hidden readonly>
								<input type="text" class="form-control" name='no_registrasi' value="{{$data->no_registrasi}}" readonly/>
							</div>
							
							<label class="col-lg-4 col-form-label">Tanggal Akad</label>
							<div class="col-lg-8">
								@if($data->status_akad == 0)
									<input id="tgl_akad" name="tgl_akad" type="text" class="form-control"/>
								@else
									<input id="tgl_akad" name="tgl_akad" type="text" class="form-control" value={{ $data->status_akad}} readonly />
								@endif
							</div>

							
							<label class="col-lg-4 col-form-label">Mata Uang</label>
							
							@if($data->status_akad == 0 || $data->status_akad == 1)
							<div class="col-lg-8">
								<select id="mata_uang" name="mata_uang" class="form-control selectpicker forSearch" data-size="10" data-live-search="true" data-style="btn-white" value={{$data->mata_uang}} >
									<option value="" selected="selected">--Pilih Mata Uang--</option>
									<option value="IDR" >Indonesia Rupiah</option>
									<option value="USD" >United States Dollars</option>
									<option value="EUR">Euro</option>
									<option value="GBP">United Kingdom Pounds</option>								
									<option value="SAR">Saudi Arabia Riyal</option>
									
								</select>
							</div>
							@else
							<div class="col-lg-8">
								<input id="mata_uang" name="mata_uang" type="text" class="form-control " readonly value='{{$data->mata_uang}}'  />
							</div>   
							@endif
							

								<label class="col-lg-4 col-form-label">Biaya Pemeriksaan</label>
								<div class="col-lg-8">
									@if ($data->status_akad == 0 || $data->status_akad == 1)
										<input id="biaya_pemeriksaan"  name="biaya_pemeriksaan" type="text" value="" onchange="jml()" class="form-control number-separator"/>
									@else
										@if (count($dataAkad) > 0)
										<input id="biaya_pemeriksaan"  name="biaya_pemeriksaan" type="text" value="{{number_format($dataAkad[0]->biaya_pemeriksaan,0,",",".")}}" onchange="jml()" class="form-control number-separator " disabled="" />
										@else
										<input id="biaya_pemeriksaan"  name="biaya_pemeriksaan" type="text" onchange="jml()" class="form-control number-separator " disabled="" />
										@endif
									@endif 

									
								</div>
								
								
							
							@if($data->status_akad == 1)
								<!--Auto Download-->
								<label class="col-lg-4 col-form-label">Kontrak Akad</label>
								<div id="sh" class="col-lg-8">
									<div class="form-control" readonly>
										<a href="{{url('') .Storage::url('public/buktiakad/'.$data->id_user.'/'.$data->file_akad) }}" download>{{$data->file_akad}}</a>
									</div>
								</div>
								<label class="col-lg-4 col-form-label">Upload Kontrak Akad</label>
								<div class="col-lg-8">
									<input type="file"  name="file" id="file" oninvalid="this.setCustomValidity('File kontrak akad masih kosong')" oninput="setCustomValidity('')" accept="application/pdf" required   onchange="getValue('file')"/>
								</div>
							@elseif($data->status_akad == 0)
								<label class="col-lg-4 col-form-label">Upload Kontrak Akad</label>
								<div class="col-lg-8">
									<input type="file"  name="file" id="file" oninvalid="this.setCustomValidity('File kontrak akad masih kosong')" oninput="setCustomValidity('')" accept="application/pdf" onchange="getValue('file')" required />
								</div>
								
							@else
								

								<label class="col-lg-4 col-form-label">Kontrak Akad</label>
								<div id="sh" class="col-lg-8">
									<div class="form-control" readonly>
										<a href="{{url('') .Storage::url('public/bukti_akad/'.$data->id_user.'/'.$data->file_akad) }}" download>{{$data->file_akad}}</a>
									</div>
								</div>
							@endif

							<label class="col-lg-4 col-form-label">Jenis Pendanaan</label>
							<div class="col-lg-8">
								<select id="jenis_pendanaan" name="jenis_pendanaan" class="form-control selectpicker forSearch" data-size="10" data-live-search="true" data-style="btn-white" required>
									<option value="" selected="selected">--Pilih Jenis Pendanaan--</option>
									<option value="Mandiri" >Mandiri</option>
									<option value="Fasilitasi" >Fasilitasi</option>
									
									
								</select>
							</div>

							<label class="col-lg-4 col-form-label">Nama Fasilitator</label>
							<div class="col-lg-8">
								@if ($data->status_akad == 0 || $data->status_akad == 1)
									<input id="nama_fasilitator"  name="nama_fasilitator" type="text" value="" class="form-control"/>
								@else
								
									<input id="nama_fasilitator"  name="nama_fasilitator" type="text" value="{{$dataAkad[0]->nama_fasilitator}}" onchange="jml()" class="form-control"/>
									
								@endif 

								
							</div>

							
								
							
								<div class="col-md-12 offset-md-5">									
								
										@component('components.buttonback',['href' => route("listkeuangan")])@endcomponent											
										@if($data->status_akad == 1)
											<button type="submit" class="btn btn-sm btn-primary m-r-5" onclick="confirm('Apakah anda yakin ingin Mengunggah Berkas Kontrak Akad???')">Konfirmasi Ulang</button>
											<br><button type="submit" class="btn btn-sm btn-success m-r-5" disabled>Akad dan Penawaran Sudah Dikirim Kepada Pelaku Usaha</button>
										@elseif($data->status_akad == 0)
											<button type="submit" class="btn btn-sm btn-primary m-r-5" onclick="confirm('Apakah anda yakin ingin Mengunggah Berkas Kontrak Akad???')">Konfirmasi</button>
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
	if(document.getElementById("biaya_pemeriksaan")){
		var rupiah1 = document.getElementById("biaya_pemeriksaan");
		rupiah1.addEventListener('keyup', function(e){									
			rupiah1.value = formatRupiah(this.value, 'Rp. ');			
		});
	}
	
	if(document.getElementById("biaya_pengujian")){
		var rupiah2 = document.getElementById("biaya_pengujian");
		rupiah2.addEventListener('keyup', function(e){									
			rupiah2.value = formatRupiah(this.value, 'Rp. ');			
		});
	}
	
	if(document.getElementById("biaya_fatwa")){
		var rupiah3 = document.getElementById("biaya_fatwa");
		rupiah3.addEventListener('keyup', function(e){									
			rupiah3.value = formatRupiah(this.value, 'Rp. ');			
		});
	}
 
		/* Fungsi formatRupiah */
		function formatRupiah(angka, prefix){	
			var mata_uang = document.getElementById("mata_uang").value;	
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
			return prefix == undefined ? rupiah : (rupiah ? mata_uang + rupiah : '');
		}
		
    	//var date = new Date();
        var today = new Date();
    	$('#tgl_akad').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
        });
        $('#tgl_akad').datepicker('setDate', today);


        function jml(){
    		 
    		 var nominal1 = parseInt(removeCommas(document.getElementById('biaya_pemeriksaan').value));			 
    		 var nominal2 = parseInt(removeCommas(document.getElementById('biaya_pengujian').value));
    		 var nominal3 = parseInt(removeCommas(document.getElementById('biaya_fatwa').value));

			
			if (isNaN(nominal1)){

				nominal1 = parseInt("0");
				if (isNaN(nominal2)){

					nominal2 = parseInt("0");
				}else if (isNaN(nominal3)){

					nominal3 = parseInt("0");

				}

			

			}else if (isNaN(nominal2)){

				nominal2 = parseInt("0");

				if (isNaN(nominal1)){

					nominal1 = parseInt("0");
				}else if (isNaN(nominal3)){

					nominal3 = parseInt("0");

				}

			}else if (isNaN(nominal3)){

				nominal3 = parseInt("0");

				if (isNaN(nominal2)){

					nominal2 = parseInt("0");
				}else if (isNaN(nominal1)){

					nominal1 = parseInt("0");

				}

			}
			var jumlah = nominal1+nominal2+nominal3;
    		
    		//console.log(nominal1);
    		//console.log(nominal2);
    		//console.log(nominal3);
    		//console.log(jumlah);
			const formatRupiah = (money) => {
			return new Intl.NumberFormat('id-ID',
				{ style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }
			).format(money);
			}
			document.getElementById('total_biaya2').value= jumlah;
			document.getElementById('total_biaya').value= formatRupiah(jumlah);			
			// document.getElementById('total_biaya').value= jumlah;
    	}
    	function removeCommas(str) {
			str = str.split('.').join("");
			str2 = str.split('Rp').join("");
		    return str2;
		};
		
	function getValue(y){
    	const x  = document.getElementById(y);

    	// var length = x.files[0];
    	// console.log(length);

        var getSize = x.files[0].size;
        //var maxSize = 5120*1024;
        var maxSize = 2048*1024;
        var values = x.value;
        var ext = values.split('.').pop();
        if(getSize > maxSize){
                alert("File terlalu besar, ukuran file maksimal 2MB");
                x.value = "";
                return false;
        }

          
    }

    </script>
    <!--  <script src="{{asset('/assets/js/cleave.js')}}"></script> -->
    <script src="{{asset('/assets/js/main.js')}}"></script>
    
   

@endpush