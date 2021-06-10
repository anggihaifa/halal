@extends('layouts.default')

@section('title', 'Kontrak Akad Sertifikasi Halal')

@push('css')
	<link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/css/animate.css')}}" rel="stylesheet" />
	<link href="{{asset('/assets/css/multistep.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <!-- begin breadcrumb -->
	<ol class="breadcrumb float-xl-right">
		<li class="breadcrumb-item">Registrasi</li>
		<li class="breadcrumb-item active">Monitoring Registrasi</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->    
	<h1 class="page-header">Monitoring Registrasi<small></small></h1>
	<!-- end page-header -->
	<!-- begin row -->
	<div class="row">
		<!-- begin col-12 -->
		<div class="col-xl-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-plugins-7">
				<!-- begin panel-heading -->
				<div class="panel-heading">
					<h4 class="panel-title">Monitoring</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
				</div>
				<!-- end panel-heading -->
				<!-- begin panel-body -->
				<div class="panel-body panel-form ml-5 step widget widget-stats animated zoomIn delay-5s" style="max-height: 630px; overflow-y: scroll;">
                    <h6 style="color: #2d353c; margin-bottom: 30px;">LOG KEGIATAN</h4>			
                        <ul id="progressbar2">
                            @foreach($dataLog as $key => $value)
                                {{-- @if $value->created_at --}}
                                    <li id="logKegiatan"><strong>{{$value['created_at']}} :</strong> <h7>{{$value['nama_user']}} - {{$value['judul_kegiatan']}}</h7></li>
                                {{-- @endif --}}
                            @endforeach
                        </ul>					
				</div>
				<!-- end panel-body -->                
                <div class="col-md-12 offset-md-5 pb-3">
                    @component('components.buttonback',['href' => route("listmonitoringregistrasi")])@endcomponent
                </div>         
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