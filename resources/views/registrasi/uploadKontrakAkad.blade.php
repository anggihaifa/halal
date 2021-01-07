	@extends('layouts.default')

@section('title', 'Kontrak Akad Sertifikasi Halal')

@push('css')
	<link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <!-- begin breadcrumb -->
	<ol class="breadcrumb float-xl-right">
		<li class="breadcrumb-item">Registrasi</li>
		<li class="breadcrumb-item active">Kontrak Akad Sertifikasi Halal</li>
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
								@if($data->status_akad ==0 )

									<input id="tgl_akad" name="tgl_akad" type="text" class="form-control"/>
								@else
									<input id="tgl_akad" name="tgl_akad" type="text" class="form-control" value={{ $data->status_akad}} readonly />
								@endif
							</div>

							<label class="col-lg-4 col-form-label">Skala Usaha</label>
							<div class="col-lg-8">
								<input id="skala_usaha" class="form-control"  name="skala_usaha" value={{ $data->skala_usaha }} type="text" readonly/>                              
                            </div>
							
							@if($data->skala_usaha == 'mikro')
							<label class="col-lg-4 col-form-label">Mata Uang</label>
								@if($data->status_akad == 0 || $data->status_akad == 1  )
								<div class="col-lg-8">

									<select id="mata_uang" name="mata_uang" class="form-control selectpicker forSearch" data-size="10" data-live-search="true" data-style="btn-white" value={{$data->mata_uang}}>
	                                    <option value="" >--Pilih Mata Uang--</option>
	                                    <option value="IDR" selected="selected">Indonesia Rupiah</option>
										<option value="USD" >United States Dollars</option>
										<option value="EUR">Euro</option>
										<option value="GBP">United Kingdom Pounds</option>
										<option value="DZD">Algeria Dinars</option>
										<option value="ARP">Argentina Pesos</option>
										<option value="AUD">Australia Dollars</option>
										<option value="ATS">Austria Schillings</option>
										<option value="BSD">Bahamas Dollars</option>
										<option value="BBD">Barbados Dollars</option>
										<option value="BEF">Belgium Francs</option>
										<option value="BMD">Bermuda Dollars</option>
										<option value="BRR">Brazil Real</option>
										<option value="BGL">Bulgaria Lev</option>
										<option value="CAD">Canada Dollars</option>
										<option value="CLP">Chile Pesos</option>
										<option value="CNY">China Yuan Renmimbi</option>
										<option value="CYP">Cyprus Pounds</option>
										<option value="CSK">Czech Republic Koruna</option>
										<option value="DKK">Denmark Kroner</option>
										<option value="NLG">Dutch Guilders</option>
										<option value="XCD">Eastern Caribbean Dollars</option>
										<option value="EGP">Egypt Pounds</option>
										<option value="FJD">Fiji Dollars</option>
										<option value="FIM">Finland Markka</option>
										<option value="FRF">France Francs</option>
										<option value="DEM">Germany Deutsche Marks</option>
										<option value="XAU">Gold Ounces</option>
										<option value="GRD">Greece Drachmas</option>
										<option value="HKD">Hong Kong Dollars</option>
										<option value="HUF">Hungary Forint</option>
										<option value="ISK">Iceland Krona</option>
										<option value="INR">India Rupees</option>
										
										<option value="IEP">Ireland Punt</option>
										<option value="ILS">Israel New Shekels</option>
										<option value="ITL">Italy Lira</option>
										<option value="JMD">Jamaica Dollars</option>
										<option value="JPY">Japan Yen</option>
										<option value="JOD">Jordan Dinar</option>
										<option value="KRW">Korea (South) Won</option>
										<option value="LBP">Lebanon Pounds</option>
										<option value="LUF">Luxembourg Francs</option>
										<option value="MYR">Malaysia Ringgit</option>
										<option value="MXP">Mexico Pesos</option>
										<option value="NLG">Netherlands Guilders</option>
										<option value="NZD">New Zealand Dollars</option>
										<option value="NOK">Norway Kroner</option>
										<option value="PKR">Pakistan Rupees</option>
										<option value="XPD">Palladium Ounces</option>
										<option value="PHP">Philippines Pesos</option>
										<option value="XPT">Platinum Ounces</option>
										<option value="PLZ">Poland Zloty</option>
										<option value="PTE">Portugal Escudo</option>
										<option value="ROL">Romania Leu</option>
										<option value="RUR">Russia Rubles</option>
										<option value="SAR">Saudi Arabia Riyal</option>
										<option value="XAG">Silver Ounces</option>
										<option value="SGD">Singapore Dollars</option>
										<option value="SKK">Slovakia Koruna</option>
										<option value="ZAR">South Africa Rand</option>
										<option value="KRW">South Korea Won</option>
										<option value="ESP">Spain Pesetas</option>
										<option value="XDR">Special Drawing Right (IMF)</option>
										<option value="SDD">Sudan Dinar</option>
										<option value="SEK">Sweden Krona</option>
										<option value="CHF">Switzerland Francs</option>
										<option value="TWD">Taiwan Dollars</option>
										<option value="THB">Thailand Baht</option>
										<option value="TTD">Trinidad and Tobago Dollars</option>
										<option value="TRL">Turkey Lira</option>
										<option value="VEB">Venezuela Bolivar</option>
										<option value="ZMK">Zambia Kwacha</option>
										<option value="EUR">Euro</option>
										<option value="XCD">Eastern Caribbean Dollars</option>
										<option value="XDR">Special Drawing Right (IMF)</option>
										<option value="XAG">Silver Ounces</option>
										<option value="XAU">Gold Ounces</option>
										<option value="XPD">Palladium Ounces</option>
										<option value="XPT">Platinum Ounces</option>
									</select>
								</div>
								@else
								<div class="col-lg-8">
									<input id="mata_uang" name="mata_uang" type="text" class="form-control " readonly  value={{$data->mata_uang}} >
		                        </div>   
								@endif

								<label class="col-lg-4 col-form-label">Total Biaya Sertifikasi</label>
								
									<div class="col-lg-8">
										<input id="total_biaya" name="total_biaya" type="text" class="form-control" value="1,500,000 " readonly />
									</div>
							@elseif($data->skala_usaha == 'kecil')
							<label class="col-lg-4 col-form-label">Mata Uang</label>
								@if($data->status_akad == 0 || $data->status_akad == 1  )
								<div class="col-lg-8">

									<select id="mata_uang" name="mata_uang" class="form-control selectpicker forSearch" data-size="10" data-live-search="true" data-style="btn-white" value={{$data->mata_uang}}>
	                                    <option value="" >--Pilih Mata Uang--</option>
	                                    <option value="IDR" selected="selected">Indonesia Rupiah</option>
										<option value="USD" >United States Dollars</option>
										<option value="EUR">Euro</option>
										<option value="GBP">United Kingdom Pounds</option>
										<option value="DZD">Algeria Dinars</option>
										<option value="ARP">Argentina Pesos</option>
										<option value="AUD">Australia Dollars</option>
										<option value="ATS">Austria Schillings</option>
										<option value="BSD">Bahamas Dollars</option>
										<option value="BBD">Barbados Dollars</option>
										<option value="BEF">Belgium Francs</option>
										<option value="BMD">Bermuda Dollars</option>
										<option value="BRR">Brazil Real</option>
										<option value="BGL">Bulgaria Lev</option>
										<option value="CAD">Canada Dollars</option>
										<option value="CLP">Chile Pesos</option>
										<option value="CNY">China Yuan Renmimbi</option>
										<option value="CYP">Cyprus Pounds</option>
										<option value="CSK">Czech Republic Koruna</option>
										<option value="DKK">Denmark Kroner</option>
										<option value="NLG">Dutch Guilders</option>
										<option value="XCD">Eastern Caribbean Dollars</option>
										<option value="EGP">Egypt Pounds</option>
										<option value="FJD">Fiji Dollars</option>
										<option value="FIM">Finland Markka</option>
										<option value="FRF">France Francs</option>
										<option value="DEM">Germany Deutsche Marks</option>
										<option value="XAU">Gold Ounces</option>
										<option value="GRD">Greece Drachmas</option>
										<option value="HKD">Hong Kong Dollars</option>
										<option value="HUF">Hungary Forint</option>
										<option value="ISK">Iceland Krona</option>
										<option value="INR">India Rupees</option>
										<option value="IDR">Indonesia Rupiah</option>
										<option value="IEP">Ireland Punt</option>
										<option value="ILS">Israel New Shekels</option>
										<option value="ITL">Italy Lira</option>
										<option value="JMD">Jamaica Dollars</option>
										<option value="JPY">Japan Yen</option>
										<option value="JOD">Jordan Dinar</option>
										<option value="KRW">Korea (South) Won</option>
										<option value="LBP">Lebanon Pounds</option>
										<option value="LUF">Luxembourg Francs</option>
										<option value="MYR">Malaysia Ringgit</option>
										<option value="MXP">Mexico Pesos</option>
										<option value="NLG">Netherlands Guilders</option>
										<option value="NZD">New Zealand Dollars</option>
										<option value="NOK">Norway Kroner</option>
										<option value="PKR">Pakistan Rupees</option>
										<option value="XPD">Palladium Ounces</option>
										<option value="PHP">Philippines Pesos</option>
										<option value="XPT">Platinum Ounces</option>
										<option value="PLZ">Poland Zloty</option>
										<option value="PTE">Portugal Escudo</option>
										<option value="ROL">Romania Leu</option>
										<option value="RUR">Russia Rubles</option>
										<option value="SAR">Saudi Arabia Riyal</option>
										<option value="XAG">Silver Ounces</option>
										<option value="SGD">Singapore Dollars</option>
										<option value="SKK">Slovakia Koruna</option>
										<option value="ZAR">South Africa Rand</option>
										<option value="KRW">South Korea Won</option>
										<option value="ESP">Spain Pesetas</option>
										<option value="XDR">Special Drawing Right (IMF)</option>
										<option value="SDD">Sudan Dinar</option>
										<option value="SEK">Sweden Krona</option>
										<option value="CHF">Switzerland Francs</option>
										<option value="TWD">Taiwan Dollars</option>
										<option value="THB">Thailand Baht</option>
										<option value="TTD">Trinidad and Tobago Dollars</option>
										<option value="TRL">Turkey Lira</option>
										<option value="VEB">Venezuela Bolivar</option>
										<option value="ZMK">Zambia Kwacha</option>
										<option value="EUR">Euro</option>
										<option value="XCD">Eastern Caribbean Dollars</option>
										<option value="XDR">Special Drawing Right (IMF)</option>
										<option value="XAG">Silver Ounces</option>
										<option value="XAU">Gold Ounces</option>
										<option value="XPD">Palladium Ounces</option>
										<option value="XPT">Platinum Ounces</option>
									</select>
								</div>
								@else
								<div class="col-lg-8">
									<input id="mata_uang" name="mata_uang" type="text" class="form-control " readonly value={{$data->mata_uang}}  />
		                        </div>       
								@endif

								<label class="col-lg-4 col-form-label">Total Biaya Sertifikasi</label>								
									<div class="col-lg-8">
										<input id="total_biaya" name="total_biaya" type="text" class="form-control" value="3,000,000 " readonly />
									</div>							
							@else
								<label class="col-lg-12 col-form-label">Biaya Sertifikasi</label>
								
								<label class="col-lg-4 col-form-label">Mata Uang</label>
								
								@if($data->status_akad == 0 || $data->status_akad == 1  )
								<div class="col-lg-8">
									<select id="mata_uang" name="mata_uang" class="form-control selectpicker forSearch" data-size="10" data-live-search="true" data-style="btn-white" value={{$data->mata_uang}} >
	                                    <option value="" selected="selected">--Pilih Mata Uang--</option>
	                                    <option value="IDR" >Indonesia Rupiah</option>
										<option value="USD" >United States Dollars</option>
										<option value="EUR">Euro</option>
										<option value="GBP">United Kingdom Pounds</option>
										<option value="DZD">Algeria Dinars</option>
										<option value="ARP">Argentina Pesos</option>
										<option value="AUD">Australia Dollars</option>
										<option value="ATS">Austria Schillings</option>
										<option value="BSD">Bahamas Dollars</option>
										<option value="BBD">Barbados Dollars</option>
										<option value="BEF">Belgium Francs</option>
										<option value="BMD">Bermuda Dollars</option>
										<option value="BRR">Brazil Real</option>
										<option value="BGL">Bulgaria Lev</option>
										<option value="CAD">Canada Dollars</option>
										<option value="CLP">Chile Pesos</option>
										<option value="CNY">China Yuan Renmimbi</option>
										<option value="CYP">Cyprus Pounds</option>
										<option value="CSK">Czech Republic Koruna</option>
										<option value="DKK">Denmark Kroner</option>
										<option value="NLG">Dutch Guilders</option>
										<option value="XCD">Eastern Caribbean Dollars</option>
										<option value="EGP">Egypt Pounds</option>
										<option value="FJD">Fiji Dollars</option>
										<option value="FIM">Finland Markka</option>
										<option value="FRF">France Francs</option>
										<option value="DEM">Germany Deutsche Marks</option>
										<option value="XAU">Gold Ounces</option>
										<option value="GRD">Greece Drachmas</option>
										<option value="HKD">Hong Kong Dollars</option>
										<option value="HUF">Hungary Forint</option>
										<option value="ISK">Iceland Krona</option>
										<option value="INR">India Rupees</option>
										
										<option value="IEP">Ireland Punt</option>
										<option value="ILS">Israel New Shekels</option>
										<option value="ITL">Italy Lira</option>
										<option value="JMD">Jamaica Dollars</option>
										<option value="JPY">Japan Yen</option>
										<option value="JOD">Jordan Dinar</option>
										<option value="KRW">Korea (South) Won</option>
										<option value="LBP">Lebanon Pounds</option>
										<option value="LUF">Luxembourg Francs</option>
										<option value="MYR">Malaysia Ringgit</option>
										<option value="MXP">Mexico Pesos</option>
										<option value="NLG">Netherlands Guilders</option>
										<option value="NZD">New Zealand Dollars</option>
										<option value="NOK">Norway Kroner</option>
										<option value="PKR">Pakistan Rupees</option>
										<option value="XPD">Palladium Ounces</option>
										<option value="PHP">Philippines Pesos</option>
										<option value="XPT">Platinum Ounces</option>
										<option value="PLZ">Poland Zloty</option>
										<option value="PTE">Portugal Escudo</option>
										<option value="ROL">Romania Leu</option>
										<option value="RUR">Russia Rubles</option>
										<option value="SAR">Saudi Arabia Riyal</option>
										<option value="XAG">Silver Ounces</option>
										<option value="SGD">Singapore Dollars</option>
										<option value="SKK">Slovakia Koruna</option>
										<option value="ZAR">South Africa Rand</option>
										<option value="KRW">South Korea Won</option>
										<option value="ESP">Spain Pesetas</option>
										<option value="XDR">Special Drawing Right (IMF)</option>
										<option value="SDD">Sudan Dinar</option>
										<option value="SEK">Sweden Krona</option>
										<option value="CHF">Switzerland Francs</option>
										<option value="TWD">Taiwan Dollars</option>
										<option value="THB">Thailand Baht</option>
										<option value="TTD">Trinidad and Tobago Dollars</option>
										<option value="TRL">Turkey Lira</option>
										<option value="VEB">Venezuela Bolivar</option>
										<option value="ZMK">Zambia Kwacha</option>
										<option value="EUR">Euro</option>
										<option value="XCD">Eastern Caribbean Dollars</option>
										<option value="XDR">Special Drawing Right (IMF)</option>
										<option value="XAG">Silver Ounces</option>
										<option value="XAU">Gold Ounces</option>
										<option value="XPD">Palladium Ounces</option>
										<option value="XPT">Platinum Ounces</option>
									</select>
								@else
								<div class="col-lg-8">
									<input id="mata_uang" name="mata_uang" type="text" class="form-control " readonly value='{{$data->mata_uang}}'  />
		                        </div>   
								@endif
							{{-- </div> --}}

								<label class="col-lg-4 col-form-label">Biaya Pemeriksaan</label>
								<div class="col-lg-8">
									@if ($data->status_akad == 0 || $data->status_akad == 1)
										<input id="biaya_pemeriksaan"  name="biaya_pemeriksaan" type="text" value="" onchange="jml()" class="form-control number-separator"/>
									@else
										<input id="biaya_pemeriksaan"  name="biaya_pemeriksaan" type="text" value="" onchange="jml()" class="form-control number-separator " disabled="" />
									@endif 

									
								</div>
								
								<label class="col-lg-4 col-form-label">Biaya Pengujian</label>
								<div class="col-lg-8">
									@if ($data->status_akad == 0 || $data->status_akad == 1 )
										<input id="biaya_pengujian" name="biaya_pengujian" onchange="jml()"  type="text" class="form-control number-separator" />
									@else
										<input id="biaya_pengujian" name="biaya_pengujian" onchange="jml()"  type="text" class="form-control number-separator" disabled="" />
									@endif
								</div>
								<label class="col-lg-4 col-form-label">Biaya Sidang Fatwa</label>
								<div class="col-lg-8">
									@if ($data->status_akad == 0 || $data->status_akad == 1 )
										<input id="biaya_fatwa" onchange="jml()" name="biaya_fatwa" type="text" class="form-control number-separator" />
									@else
										<input id="biaya_fatwa" onchange="jml()" name="biaya_fatwa" type="text" class="form-control number-separator" disabled="" />
									@endif
								</div>
								<label class="col-lg-4 col-form-label">Total Biaya Sertifikasi</label>
								<div class="col-lg-8">
									<input id="total_biaya" type="text" class="form-control " id="totalrupiah" value='{{number_format($data->total_biaya,0,",",".")}}' readonly />
									<input id="total_biaya2" name="total_biaya" type="text" class="form-control " id="totalrupiah" value='{{number_format($data->total_biaya,0,",",".")}}' readonly hidden/>
								</div>

							@endif
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
									<input type="file"  name="file" id="file" oninvalid="this.setCustomValidity('File kontrak akad masih kosong')" oninput="setCustomValidity('')" accept="application/pdf,application/msword" required   onchange="getValue('file')/>
								</div>
							@elseif($data->status_akad == 0)	
								<!--Auto Download-->
								<label class="col-lg-4 col-form-label">Upload Kontrak Akad</label>
								<div class="col-lg-8">
									<input type="file"  name="file" id="file" oninvalid="this.setCustomValidity('File kontrak akad masih kosong')" oninput="setCustomValidity('')" accept="application/pdf,application/msword" onchange="getValue('file')" required />
								</div>
								
							@else
								

								<label class="col-lg-4 col-form-label">Kontrak Akad</label>
								<div id="sh" class="col-lg-8">
									<div class="form-control" readonly>
										<a href="{{url('') .Storage::url('public/bukti_akad/'.$data->id_user.'/'.$data->file_akad) }}" download>{{$data->file_akad}}</a>
									</div>
								</div>
							@endif

							
								
							
								<div class="col-md-12 offset-md-5">
									
								
										@component('components.buttonback',['href' => route("listakadadmin")])@endcomponent	
										@if($data->status_akad == 1)
											<button type="submit" class="btn btn-sm btn-primary m-r-5">Konfirmasi</button>
											<button  class="btn btn-sm btn-warning m-r-5" disabled>Akad Sedang Diproses</button>
										@elseif($data->status_akad == 2)
											<button type="submit" class="btn btn-sm btn-green m-r-5" disabled>Akad Sedang Diproses</button>
										@elseif($data->status_akad == 3)
											<button type="submit" class="btn btn-sm btn-success m-r-5" disabled>Akad Sudah Dikonfirmasi</button>
										@elseif($data->status_akad == 0)
											<button type="submit" class="btn btn-sm btn-primary m-r-5">Konfirmasi</button>
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
		var rupiah1 = document.getElementById("biaya_pemeriksaan");
		rupiah1.addEventListener('keyup', function(e){									
			rupiah1.value = formatRupiah(this.value, 'Rp. ');			
		});

		var rupiah2 = document.getElementById("biaya_pengujian");
		rupiah2.addEventListener('keyup', function(e){									
			rupiah2.value = formatRupiah(this.value, 'Rp. ');			
		});

		var rupiah3 = document.getElementById("biaya_fatwa");
		rupiah3.addEventListener('keyup', function(e){									
			rupiah3.value = formatRupiah(this.value, 'Rp. ');			
		});
 
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