@extends('layouts.default')

@section('title', 'Tambah Registrasi Halal')

@push('css')
    <link href="{{asset('/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
	  <link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <!-- begin breadcrumb -->
	<ol class="breadcrumb float-xl-right">
		<li class="breadcrumb-item"><a href="#">Registrasi</a></li>
		<li class="breadcrumb-item">Registrasi Halal</li>
		<li class="breadcrumb-item active">Tambah Registrasi Halal</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Tambah Registrasi Halal<small></small></h1>
	<!-- end page-header -->
	<!-- begin row -->
	<div class="row">
		<!-- begin col-12 -->
		<div class="col-xl-12">
			<!-- begin panel -->
			<div class="panel panel-inverse" data-sortable-id="form-plugins-7">
				<!-- begin panel-heading -->
				<div class="panel-heading">
					<h4 class="panel-title">Tambah Registrasi Halal</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
				</div>
				<!-- end panel-heading -->
				<!-- begin panel-body -->
				<div class="panel-body panel-form">
                    <form action="{{route('registrasiHalal.store')}}" method="post" name="registerForm" class="form-horizontal form-bordered" enctype="multipart/form-data">
						<div class="form-group row">
                            @csrf

                            <label class="col-lg-4 col-form-label">Tanggal Registrasi</label>
                            <div class="col-lg-8">
                                <input type="text" id="tgl_registrasi" name="tgl_registrasi" class="form-control " readonly/>
                            </div>

                            @component('components.inputselect',['name'=>'id_jenis_registrasi','label'=>'Jenis Registrasi','options'=>$jenisRegistrasi,'labelKey'=>'jenis_registrasi','required'=>true])@endcomponent

                            <label class="col-lg-4 col-form-label">Status Registrasi</label>
                            <div class="col-lg-8">
                                <div style="margin-bottom:7px;">
                                    <div class="radio radio-css radio-inline">
                                        <input type="radio" name="status_registrasi" id="statusRegistrasi1" value="baru" checked />
                                        <label for="statusRegistrasi1">Baru</label>
                                    </div>
                                    <div class="radio radio-css radio-inline">
                                        <input type="radio" name="status_registrasi" id="statusRegistrasi2"  value="perpanjangan" />
                                        <label for="statusRegistrasi2">*Perpanjangan</label>
                                    </div>
                                    <div class="radio radio-css radio-inline">
                                        <input type="radio" name="status_registrasi" id="statusRegistrasi3"  value="pengembangan" />
                                        <label for="statusRegistrasi3">*Pengembangan</label>
                                    </div>
                                </div>
                            </div>

							@component('components.inputtext',['name'=> 'no_surat','label' => 'No. Surat Permohonan Sertifikasi','required'=>true,'placeholder'=>'No. Surat Permohonan Sertifikasi'])@endcomponent

                            <label id="lsh" class="col-lg-4 col-form-label">*Status Halal Sebelumnya</label>
							<div id="sh" class="col-lg-8">
								<input type="text" name="status_halal" class="form-control" placeholder="Status Halal Sebelumnuya"  />
                            </div>

							<label id="lshb" class="col-lg-4 col-form-label">*SH Berlaku s/d</label>
							<div id="shb" class="col-lg-8">
                                <!--<input type="text" id="sh_berlaku" name="sh_berlaku" class="form-control" placeholder="SH Berlaku s/d" value="" />-->
                                <div class="input-group date">
                                    <input type="text" id="sh_berlaku" name="sh_berlaku" class="form-control" placeholder="SH Berlaku s/d" value="" data-date-start-date="Date.default" />
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
                            </div>

                            <!-- <label class="col-lg-4 col-form-label">Status SJPH</label>
							<div class="col-lg-8">
								<select id="status_sjph" name="status_sjph" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
									<option value="A" selected>A</option>
									<option value="B">B</option>
                                    <option value="Belum Ada">Belum Ada</option>
								</select>
                            </div> -->

                            {{--@component('components.inputtext',['name'=> 'no_sertifikat','label' => 'No. Sertifikat SJPH','required'=>true,'placeholder'=>'No Sertifikat SJPH'])@endcomponent--}}

                            <label id="lsjph0" class="col-lg-4 col-form-label">No. Sertifikat SJPH</label>
                            <div id="dsjph0" class="col-lg-8">
                                <input type="text" name="no_sertifikat" class="form-control" placeholder="No. Sertifikat SJPH"  />
                            </div>

							<label id="lsjph" class="col-lg-4 col-form-label">SJPH Berlaku s/d</label>
							<div id="dsjph" class="col-lg-8">
								<div class="input-group date">
									<input id="tgl_sjph" name="tgl_sjph" type="text" class="form-control" placeholder="SJPH Berlaku s/d"  data-date-start-date="Date.default" />
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
							</div>

                            <label class="col-lg-4 col-form-label">Jenis Produk</label>
							<div class="col-lg-8">
								<div class="radio radio-css radio-inline">
									<input type="radio" name="jenis_produk" id="jenisProduk1" value="Retail" checked />
									<label for="jenisProduk1">Retail</label>
								</div>
								<div class="radio radio-css radio-inline">
									<input type="radio" name="jenis_produk" id="jenisProduk2" value="Non Retail" />
									<label for="jenisProduk2">Non Retail</label>
								</div>
								<div class="radio radio-css radio-inline">
									<input type="radio" name="jenis_produk" id="jenisProduk3" value="Retail & Non Retail" />
									<label for="jenisProduk3">Retail & Non Retail</label>
								</div>
							</div>

                            <label class="col-lg-4 col-form-label">Skala Usaha</label>
							<div class="col-lg-8">
								<div class="radio radio-css radio-inline">
									<input type="radio" name="skala_usaha" id="skalaUsaha1" value="mikro" checked />
									<label for="skalaUsaha1">Mikro</label>
								</div>
								<div class="radio radio-css radio-inline">
									<input type="radio" name="skala_usaha" id="skalaUsaha2" value="kecil" />
									<label for="skalaUsaha2">Kecil</label>
								</div>
								<div class="radio radio-css radio-inline">
									<input type="radio" name="skala_usaha" id="skalaUsaha3" value="menengah" />
									<label for="skalaUsaha3">Menengah</label>
								</div>
								<div class="radio radio-css radio-inline">
									<input type="radio" name="skala_usaha" id="skalaUsaha4" value="besar" />
									<label for="skalaUsaha4">Besar</label>
								</div></br>
								<small class="f-s-12 text-grey-darker m-t-5">Jika nilai "Skala Usaha" adalah "Usaha Kecil" maka Registrasi bisa menggunakan NPWP atau KTP</small>
							</div>

                            <label class="col-lg-4 col-form-label">NPWP/KTP</label>
							<div class="col-lg-8">
                                <div style="margin-bottom:10px;">
                                    <div class="radio radio-css radio-inline">
                                        <input type="radio" name="tipe" id="tipe1" value="ktp" checked />
                                        <label for="tipe1">KTP</label>
                                    </div>
                                    <div class="radio radio-css radio-inline">
                                        <input type="radio" name="tipe" id="tipe2" value="npwp" />
                                        <label for="tipe2">NPWP</label>
                                    </div>
                                </div>
								<input id="no_tipe" name="no_tipe" type="text" class="form-control"  required />
							</div>

                            @component('components.inputtext',['name'=> 'jenis_izin','label' => 'Jenis Izin Usaha','required'=>true,'placeholder'=>'MD/ML/PIRT/TR/TI/DKL/SD/SI/CD/CL/CA//ITUP/ISUP/NKV/HC/CFS'])@endcomponent


                            @component('components.inputtext',['id'=>'jumlah_karyawan','name'=> 'jumlah_karyawan','label' => 'Jumlah Karyawan','required'=>true,'placeholder'=>'Jumlah Karyawan'])@endcomponent

                            @component('components.inputtext',['name'=> 'kapasitas_produksi','label' => 'Kapasitas Produksi','required'=>true,'placeholder'=>'Contoh: 1000 Ton / Tahun'])@endcomponent

                            <label for="kelompok" class="col-lg-4 col-form-label">Kelompok Produk</label>

                            <div class="col-lg-8">
                                <select id="id_kelompok_produk" name="id_kelompok_produk" class="form-control selectpicker forKelompok" data-size="10" data-live-search="true" data-style="btn-white">
                                    <option value="">--Pilih Kelompok Produk--</option>
                                        @if(isset($kelompokProduk))
                                            @foreach($kelompokProduk as $index => $value)
                                                <option value="{{$value['id']}}"> - {{$value['kelompok_produk']}}</i></option>
                                                @endforeach
                                        @endif
                                </select>
                            </div>


							<!-- <label class="col-lg-4 col-form-label">Biaya Registrasi</label>
							<div class="col-lg-8">
								<input name="biaya_registrasi" type="text" class="form-control" placeholder="" value="Rp 220,000" readonly />
								<small class="f-s-12 text-grey-darker m-t-5">Sudah Termasuk PPN 10%</small>
							</div>

							<label class="col-lg-4 col-form-label">Metode Pembayaran</label>
							<div class="col-lg-8">
								<div class="radio radio-css radio-inline">
									<input type="radio" name="metode_pembayaran" id="metodePembayaran1" value="tunai" checked />
									<label for="metodePembayaran1">Tunai</label>
								</div>
								<div class="radio radio-css radio-inline">
									<input type="radio" name="metode_pembayaran" id="metodePembayaran2" value="transfer" />
									<label for="metodePembayaran2">Transfer</label>
								</div>
							</div>

                            <label id="ltunai" class="col-lg-4 col-form-label">Cara Pembayaran Tunai</label>
                            <div id="dtunai" class="col-lg-8">
                                <div id="accordionTunai" class="accordion">
                                    @foreach($dataTunai as $index => $value)
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

                            <label id="ltransfer" class="col-lg-4 col-form-label">Cara Pembayaran Transfer</label>
                            <div id="dtransfer" class="col-lg-8">
                                <div id="accordionTransfer" class="accordion">
                                    @foreach($dataTransfer as $index => $value)
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
                            </div> -->

							<div class="col-md-12 offset-md-5">
								<button type="submit" class="btn btn-sm btn-primary m-r-5">Kirim</button>
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
    <script src="{{asset('/assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/select2/dist/js/select2.min.js')}}"></script>
    <!--<script src="{{asset('/assets/js/demo/form-plugins.demo.js')}}"></script>-->
    <script src="{{asset('/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
    <script>
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        var d = date.getDate();
        var month = date.getMonth()+1;
        var y = date.getFullYear();
        if(d < 10 ){ d = '0'+ d;}
        if(month < 10){ month = '0'+ month; }
        var todayFormat = y+"-"+month+"-"+d ;
        /*$('#tgl_registrasi').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
            beforeShow: function(i) { if ($(i).attr('readonly')) { return false; } }
        });*/
        $('#tgl_registrasi').val(todayFormat);
        $('#sh_berlaku').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
        });
        $('#tgl_sjph').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
        });

        var reg = document.registerForm.status_registrasi;
        var tipe = document.registerForm.tipe;
        var lsh = document.getElementById('lsh');
        var sh = document.getElementById('sh');
        var lshb = document.getElementById('lshb');
        var shb = document.getElementById('shb');

        //cara pembayaran
        // var metode = document.registerForm.metode_pembayaran;
        // var ltunai = document.getElementById('ltunai');
        // var dtunai = document.getElementById('dtunai');
        // var ltransfer = document.getElementById('ltransfer');
        // var dtransfer = document.getElementById('dtransfer');


        lsh.style.display = 'none';
        sh.style.display = 'none';
        lshb.style.display = 'none';
        shb.style.display = 'none';

        // ltunai.style.display = 'block';
        // dtunai.style.display = 'block';
        // ltransfer.style.display = 'none';
        // dtransfer.style.display = 'none';

        //dokumen sjph
        // var sjph = document.getElementById('status_sjph');
        // var ljph0 = document.getElementById('lsjph0');
        // var djph0 = document.getElementById('dsjph0');
        // var ljph = document.getElementById('lsjph');
        // var djph = document.getElementById('dsjph');

        // ljph0.style.display = 'block';
        // djph0.style.display = 'block';
        // ljph.style.display = 'block';
        // djph.style.display = 'block';

        // document.getElementById("status_sjph").addEventListener("change", mySjph);

        // function mySjph(){
        //     if(sjph.value == "Belum Ada"){
        //         ljph0.style.display = 'none';
        //         djph0.style.display = 'none';
        //         ljph.style.display = 'none';
        //         djph.style.display = 'none';
        //     }else{
        //         ljph0.style.display = 'block';
        //         djph0.style.display = 'block';
        //         ljph.style.display = 'block';
        //         djph.style.display = 'block';
        //    }
        // }



        for (var i = 0; i < reg.length; i++) {
            reg[i].addEventListener('change', function() {
                if (this.value == 'baru') {
                    lsh.style.display = 'none';
                    sh.style.display = 'none';
                    lshb.style.display = 'none';
                    shb.style.display = 'none';
                }else{
                    lsh.style.display = 'block';
                    sh.style.display = 'block';
                    lshb.style.display = 'block';
                    shb.style.display = 'block';
                }
            });
        }

        //metode pembayaran
        // for (var i = 0; i < metode.length; i++) {
        //     metode[i].addEventListener('change', function() {
        //         if (this.value == 'tunai') {
        //             ltunai.style.display = 'block';
        //             dtunai.style.display = 'block';
        //             ltransfer.style.display = 'none';
        //             dtransfer.style.display = 'none';
        //         }else{
        //             ltunai.style.display = 'none';
        //             dtunai.style.display = 'none';
        //             ltransfer.style.display = 'block';
        //             dtransfer.style.display = 'block';
        //         }
        //     });
        // }


        $('#no_tipe').attr('placeholder','No. KTP');

        for (var i = 0; i < tipe.length; i++) {
            tipe[i].addEventListener('change', function() {
                if (this.value == 'ktp') {
                    $('#no_tipe').attr('placeholder','No. KTP');
                }else{
                    $('#no_tipe').attr('placeholder','No. NPWP');
                }
            });
        }

        function setInputFilter(textbox, inputFilter) {
            ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
                textbox.addEventListener(event, function() {
                if (inputFilter(this.value)) {
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                    this.value = this.oldValue;
                    this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                } else {
                    this.value = "";
                }
                });
            });
        }
        setInputFilter(document.getElementById("jumlah_karyawan"), function(value) {
            return /^\d*\.?\d*$/.test(value);
        });

    </script>

@endpush
