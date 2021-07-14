@extends('layouts.default')

@section('title', 'Tambah Registrasi Halal')

@push('css')
    <link href="{{asset('/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/css/customize.css')}}" rel="stylesheet" />
    {{-- <link href="{{asset('/assets/css/multistep.css')}}" rel="stylesheet" /> --}}    
    <link rel="stylesheet" >            
@endpush

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="#">Registrasi</a></li>
        <li class="breadcrumb-item">Registrasi Halal</li>
        <li class="breadcrumb-item active">Edit Registrasi Halal</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Edit Registrasi Halal<small></small></h1>
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
                    <form action="{{route('updateregistrasi')}}" method="post" name="registerForm" class="form-horizontal form-bordered" enctype="multipart/form-data" id="msform">

                        <ul id="progressbar">
                            <li class="active text-center" id="umum"><strong>Data Registrasi</strong></li>
                            <li id="kantor" class="text-center"><strong>Data Perusahaan</strong></li>
                            <li id="pabrik" class="text-center"><strong>Data KTP dan NPWP</strong></li>
                            <li id="pemilik" class="text-center"><strong>Data Produk</strong></li>                            
                        </ul> <!-- fieldsets -->

                        <div class="form-group row">
                        {{-- @foreach ($data as $valData) --}}
                            <fieldset>
                            <div class="form-card row">
                                @csrf                            
                                <div class="wrapper col-lg-12">
                                    <div class="row">
                                        <label class="col-12"><h4>Data Registrasi</h4></label>
                                    </div>
                                </div>
                                                                
                                <div class="col-lg-8" style="display: none">
                                    <input type="text" id="id_registrasi" name="id_registrasi" class="form-control " value="{{$data['id']}}" readonly/>
                                    <input type="text" id="no_registrasi" name="no_registrasi" class="form-control " value="{{$data['no_registrasi']}}" readonly/>
                                </div>

                                <label class="col-lg-4 col-form-label">Tanggal Input Data</label>
                                <div class="col-lg-8">
                                    <input type="text" id="tgl_registrasi" name="tgl_registrasi" class="form-control " value="{{$data['tgl_registrasi']}}" readonly/>
                                </div>

                                <div class="wrapper col-lg-12">
                                    <div class="row">
                                        <label class="col-lg-4 col-form-label">Jenis Pengajuan</label>
                                        <div class="col-lg-8">
                                            <div style="margin-bottom:7px;">
                                                <div class="radio radio-css radio-inline">
                                                    @if($data['status_registrasi'] == 'baru')
                                                        <input type="radio" name="status_registrasi" id="statusRegistrasi1" value="baru" checked />
                                                        <label for="statusRegistrasi1" class="text-dark"><b>Baru</b></label>
                                                    @else
                                                        <input type="radio" name="status_registrasi" id="statusRegistrasi1" value="baru"/>
                                                        <label for="statusRegistrasi1" class="text-dark"><b>Baru</b></label>
                                                    @endif
                                                </div>
                                                <div class="radio radio-css radio-inline">
                                                    @if($data['status_registrasi'] == 'perpanjangan')
                                                        <input type="radio" name="status_registrasi" id="statusRegistrasi2"  value="perpanjangan" checked/>
                                                        <label for="statusRegistrasi2" class="text-dark"><b>Perpanjangan</b></label>
                                                    @else
                                                        <input type="radio" name="status_registrasi" id="statusRegistrasi2"  value="perpanjangan" />
                                                        <label for="statusRegistrasi2" class="text-dark"><b>Perpanjangan</b></label>
                                                    @endif
                                                </div>
                                                <div class="radio radio-css radio-inline">
                                                    @if($data['status_registrasi'] == 'perubahan')
                                                        <input type="radio" name="status_registrasi" id="statusRegistrasi3"  value="perubahan" checked/>
                                                        <label for="statusRegistrasi3" class="text-dark"><b>Perubahan</b></label>
                                                    @else
                                                        <input type="radio" name="status_registrasi" id="statusRegistrasi3"  value="perubahan" />
                                                        <label for="statusRegistrasi3" class="text-dark"><b>Perubahan</b></label>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="wrapper col-lg-12">
                                    <div class="row">
                                        <label class="col-lg-4 col-form-label">Jenis Layanan</label>
                                        <div class="col-lg-8">
                                            <select id="id_jenis_reg" onchange="getSelectedValue();"  name="id_ruang_lingkup" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
                                                @php                                                                                                
                                                foreach ($jenisRegistrasi as $jenis) {                                                                                                        
                                                    if($data['id_ruang_lingkup'] == $jenis->id){
                                                        echo "<option selected='selected' value='$jenis->id'>$jenis->ruang_lingkup</option>";
                                                    }else{                                                        
                                                        echo "<option value='$jenis->id'>$jenis->ruang_lingkup</option>";
                                                    }
                                                }                                                                                    
                                                @endphp                             
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                                                
                                <div class="wrapper col-lg-12">
                                <div class="row">
                                    @component('components.inputtext',['name'=> 'no_registrasi_bpjph','id' => 'no_registrasi_bpjph','label' => 'No. Pendaftaran BPJPH *','required'=>true,'placeholder'=>'No. Pendaftaran BPJPH', 'value'=>$data['no_registrasi_bpjph']])@endcomponent
                                    <p style="margin-left: 35%;">Contoh: 00-0-0000-0000 / SH2021-0-000000</p>
                                </div>
                                </div>                                
                                                                
                            </div>
                            <div class="text-center"><input type="button" name="next" class="next action-button" value="Lanjut"/></div>
                            </fieldset>
                            <fieldset>
                                <div class="form-card row">
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label class="col-12"><h4>Data Perusahaan</h4></label>
                                        </div>
                                    </div>

                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'nama_perusahaan','label' => 'Nama Perusahaan *','required'=>true,'placeholder'=>'Nama Perusahaan','value'=>$data['nama_perusahaan']])@endcomponent
                                        </div>
                                        </div>
        
                                        <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtextarea',['name'=> 'alamat_perusahaan','label' => 'Alamat Perusahaan *','required'=>true,'placeholder'=>'Alamat Perusahaan','id'=>'alamatPerusahaan','value'=>$data['alamat_perusahaan']])@endcomponent
                                        </div>
                                        </div>
        
                                        <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'telepon_perusahaan','label' => 'Telepon Perusahaan *','required'=>true,'placeholder'=>'Telepon Perusahaan','id'=>'teleponPerusahaan','value'=>$data['telepon_perusahaan']])@endcomponent
                                        </div>
                                        </div>
        
                                        <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtextarea',['name'=> 'alamat_pabrik','label' => 'Alamat Pabrik *','required'=>true,'placeholder'=>'Alamat Pabrik','id'=>'alamatPabrik','value'=>$data['alamat_pabrik']])@endcomponent
                                        </div>
                                        </div>
        
                                        <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'telepon_pabrik','label' => 'Telepon Pabrik *','required'=>true,'placeholder'=>'Telepon Pabrik','id'=>'teleponPabrik','value'=>$data['telepon_pabrik']])@endcomponent
                                        </div>
                                        </div>                                        

                                        <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'nama_contact_person','label' => 'Nama Contact Person *','required'=>true,'placeholder'=>'Nama Contact Person','id'=>'namacontactPerson','value'=>$data['sistem_pemasaran']])@endcomponent
                                        </div>
                                        </div>
        
                                        <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'contact_person','label' => 'No Telp Contact Person *','required'=>true,'placeholder'=>'No Telp Contact Person','id'=>'nocontactPerson','value'=>$data['contact_person']])@endcomponent
                                        </div>
                                        </div>
        
                                        <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputemail',['name'=> 'email','label' => 'Email Contact Person*','required'=>true,'placeholder'=>'Email Contact Person','id'=>'emailCP','value'=>$data['email']])@endcomponent
                                        </div>
                                    </div>   
                                </div>    
                                
                                <div class="text-center">
                                    <input type="button" name="previous" class="previous action-button-previous" value="Kembali" /> <input type="button" name="next" class="next action-button" value="Lanjut" />
                                </div>
    
                                    {{-- <div class="text-center">                                                                                                    
                                        <button type="submit" class="action-button">Kirim</button>
                                    </div> --}}
                            </fieldset>
                            <fieldset>                                
                                <div class="form-card row">
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label class="col-12"><h4>Data KTP & NPWP (Lewati jika tidak akan diubah)</h4></label>
                                        </div>
                                    </div>                                    

                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label class="col-4 col-form-label">KTP Pelaku Usaha*</label>
                                            <div class="col-lg-8"><div>                                            
                                                <img src="{{url('') .Storage::url('ktp/'.$data['id_user'].'/'.$data['ktp']) }}" style="width: 30%">
                                            </div></div>
                                        </div>
                                    </div>

                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label class="col-4 col-form-label"></label>
                                            <div class="col-lg-8"><div>                                            
                                                <input type="file" name="ktp" accept="image/*" onChange="getValue('ktp')" id="ktp">                                                
                                            </div></div>
                                        </div>
                                    </div>
    
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label class="col-4 col-form-label">NPWP Pelaku Usaha*</label>
                                            <div class="col-lg-8"><div>                                            
                                                <img src="{{url('') .Storage::url('npwp/'.$data['id_user'].'/'.$data['npwp']) }}" style="width: 30%">
                                            </div></div>
                                        </div>
                                    </div>
                                    
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label class="col-4 col-form-label"></label>
                                            <div class="col-lg-8"><div>                                            
                                                <input type="file" name="npwp" accept="image/*" onChange="getValue('npwp')" id="npwp">
                                            </div></div>
                                        </div>
                                    </div>                                                                    
                                </div>
                                
                                <div class="text-center">
                                    <input type="button" name="previous" class="previous action-button-previous" value="Kembali" /> <input type="button" name="next" class="next action-button" value="Lanjut" />
                                </div>
                                    {{-- <div class="text-center">                                                                                                    
                                        <button type="submit" class="action-button">Kirim</button>
                                    </div> --}}
                            </fieldset>
                            <fieldset>                                
                                <div class="form-card row">
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label class="col-12"><h4>Data Produk</h4></label>
                                        </div>
                                    </div>                                                                        
    
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label for="kelompok" class="col-lg-4 col-form-label">Jenis Produk*</label>
    
                                            <div class="col-lg-8">
                                                <select id="id_kelompok_produk" name="id_kelompok_produk" class="form-control selectpicker forKelompok" data-size="10" data-live-search="true" data-style="btn-white" required>
                                                    <option value="">--Pilih Jenis Produk--</option>
                                                        @if(isset($kelompokProduk))
                                                            @foreach($kelompokProduk as $index => $value)
                                                                @if($data['jenis_produk'] == $value['id'])
                                                                    <option selected="selected" value="{{$value['id']}}"> - {{$value['kelompok_produk']}}</i></option>
                                                                @else
                                                                    <option value="{{$value['id']}}"> - {{$value['kelompok_produk']}}</i></option>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                </select>                                
                                            </div>   
                                        </div>
                                    </div>

                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label for="kelompok" class="col-lg-4 col-form-label">Rincian Jenis Produk (harap pilih kembali data rincian jenis produk)*</label>
    
                                            <div class="col-lg-8">
                                                @php
                                                    $rjp = explode(",",$data['rincian_jenis_produk']);
                                                @endphp
                                                <p style="color: black; font-weight: bold">Data Sebelumnya:</p>
                                                @for ($x=0; $x< count($rjp); $x++)
                                                    <p style="color: black;font-weight: bold">{{$x+1}}) {{$rjp[$x]}} </p>
                                                @endfor                                                
                                            </div>   
                                        </div>
                                    </div>

                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label for="kelompok" class="col-lg-4 col-form-label"></label>
    
                                            <div class="col-lg-8">
                                                <select id="id_rincian_kelompok_produk1" name="id_rincian_kelompok_produk[]" class="form-control selectpicker" data-size="30" data-live-search="true" data-style="btn-white" required>
                                                {{-- <select multiple="multiple" id="id_rincian_kelompok_produk" name="id_rincian_kelompok_produk[]" data-size="30"> --}}
                                                    <option value="">--Pilih Jenis Produk--</option>
                                                </select>
                                            </div>   
                                        </div>
                                    </div>

                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                                
                                            <div class="detail_datarincian" id="detail_datarincian" style="width: 100%; margin-left:-3px"></div>
                                            <div class="col-md-12">
                                                <a id="tam_data_rincian" class="tam_data_rincian btn btn-sm btn-primary m-r-5" style="color:white">Tambah Data Rincian Jenis Produk</a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div id="wrapperdataproduk" class="wrapper col-lg-12 row">                                        
                                            <div class="wrapper col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Merk/Brand (harap isi kembali data merk)*</label>
                                                    <div class="col-lg-8"><div>
                                                        @php
                                                            $nmp = explode(",",$data['nama_merk_produk']);
                                                        @endphp
                                                        <p style="color: black;font-weight: bold">Data Sebelumnya:</p>
                                                        @for ($x=0; $x< count($nmp); $x++)
                                                            <p style="color: black;font-weight: bold">{{$x+1}}) {{$nmp[$x]}} </p>
                                                        @endfor                                                
                                                    </div></div>
                                                </div>
                                            </div>
                                            <div class="wrapper col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label"></label><div class="col-lg-8"><div><input class="form-control" id="merk" name="merk[]" type="text" label="Merk/Brand" placeholder="Merk/Brand" required></div></div>
                                                </div>
                                            </div>
                                            <div class="wrapper col-lg-12">
                                                <div class="row">                                                
                                                    <div class="detail_dataproduk" id="detail_dataproduk" style="width: 100%; margin-left:-3px"></div>
                                                    <div class="col-md-12">
                                                        <a id="tam_data_produk" class="tam_data_produk btn btn-sm btn-primary m-r-5" style="color:white">Tambah Data Merk/Brand</a>
                                                    </div>
                                                </div>
                                            </div>
                                        {{-- </div> --}}
                                    </div> 
    
                                    <div class="wrapper col-lg-12">
                                    <div class="row">
                                        <!--skala usaha-->
                                        <label class="col-lg-4 col-form-label">Daerah Pemasaran*</label>
                                        <div class="col-lg-8">
                                            <div class="radio radio-css radio-inline">
                                                @if ($data['daerah_pemasaran'] == 'Provinsi')
                                                    <input type="radio" name="daerah_pemasaran" id="daerahPemasaran1" value="Provinsi" checked />
                                                    <label for="daerahPemasaran1" class="text-dark"><b>Provinsi (Maks 3 Provinsi)</b></label>
                                                @else
                                                    <input type="radio" name="daerah_pemasaran" id="daerahPemasaran1" value="Provinsi"/>
                                                    <label for="daerahPemasaran1" class="text-dark"><b>Provinsi (Maks 3 Provinsi)</b></label>
                                                @endif
                                            </div>
                                            <div class="radio radio-css radio-inline">
                                                @if ($data['daerah_pemasaran'] == 'Nasional')
                                                    <input type="radio" name="daerah_pemasaran" id="daerahPemasaran2" value="Nasional" checked/>
                                                    <label for="daerahPemasaran2" class="text-dark"><b>Nasional (Lebih dari 3 Provinsi)</b></label>
                                                @else
                                                    <input type="radio" name="daerah_pemasaran" id="daerahPemasaran2" value="Nasional"/>
                                                    <label for="daerahPemasaran2" class="text-dark"><b>Nasional (Lebih dari 3 Provinsi)</b></label>
                                                @endif
                                            </div>
                                            <div class="radio radio-css radio-inline">
                                                @if ($data['daerah_pemasaran'] == 'Internasional')
                                                    <input type="radio" name="daerah_pemasaran" id="daerahPemasaran3" value="Internasional" checked/>
                                                    <label for="daerahPemasaran3" class="text-dark"><b>Internasional</b></label>
                                                @else
                                                    <input type="radio" name="daerah_pemasaran" id="daerahPemasaran3" value="Internasional" />
                                                    <label for="daerahPemasaran3" class="text-dark"><b>Internasional</b></label>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    </div>                                        
                                </div>
                                
                                <div class="text-center">
                                    <input type="button" name="previous" class="previous action-button-previous" value="Kembali" /> <button type="submit" class="action-button">Perbarui</button>
                                </div>                            
                            </fieldset>
                        {{-- @endforeach --}}
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
    <script src="{{asset('/assets/js/demo/form-plugins.demo.js')}}"></script>
    <script src="{{asset('/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>    
    <script>                    
        var jumlah=0;
        var jumlah2=0;
        var jumlahdataproduk=0;                        
        var jumlahdatarincian=1;

        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        var d = date.getDate();
        var month = date.getMonth()+1;
        var y = date.getFullYear();
        if(d < 10 ){ d = '0'+ d;}
        if(month < 10){ month = '0'+ month; }
        var todayFormat = y+"-"+month+"-"+d ;        

        // $('#tgl_registrasi').val(todayFormat);
        
        var merk;
        var rincian;
        var detaildataproduk = document.getElementById('detail_dataproduk');
        var detaildatarincian = document.getElementById('detail_datarincian');
        detaildataproduk.style.display = 'block';
        detaildatarincian.style.display = 'block';        
        

        $('#tam_data_produk').on('click', function(){             
            merk = $('#merk').val();             

            detaildataproduk.style.display = 'block';

            adddataproduk();       
        });        

        $('#tam_data_rincian').on('click', function(){
            // alert("disini");
            detaildatarincian.style.display = 'block';

            adddatarincian();       
        });        

        function adddataproduk(){
            var data_produk = '<div> <div class="wrapper col-lg-12"><div class="row"><label class="col-4 col-form-label"></label><div class="col-lg-7"><input class="form-control" id="merk" name="merk[]" type="text" label="Merk/Brand" placeholder="Merk/Brand" required></div> <div class="col-lg-1"><a id="hapus_dataproduk" class="btn btn-sm btn-danger m-r-5" style="color:white">X</a></div> </div> </div> </div>';
            // var data_produk = '<div>q</div>';
            $('.detail_dataproduk').append(data_produk);
            jumlahdataproduk+=1;            
        }

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });            
                
        $.ajax({
            url: '{{ route('dependent_dropdown_rincian.store') }}',
            method: 'POST',
            data: {id: $id = document.getElementById("id_kelompok_produk").value},
            success: function (response) {                                                
                $('#id_rincian_kelompok_produk'+jumlahdatarincian).empty();                           
                $.each(response, function (rincian_kelompok_produk, kode_klasifikasi) {                            
                    $("#id_rincian_kelompok_produk1").append(new Option(kode_klasifikasi+' | '+rincian_kelompok_produk, kode_klasifikasi+'. '+rincian_kelompok_produk))
                })
                $('#id_rincian_kelompok_produk1').selectpicker('refresh');
            }                   
        });                       

        function adddatarincian(){
            var data_rincian = '<div id="rincian'+(jumlahdatarincian+1)+'"><div class="wrapper col-lg-12"><div class="row"><label for="kelompok" class="col-lg-4 col-form-label"></label><div class="col-lg-7"><select id="id_rincian_kelompok_produk'+(jumlahdatarincian+1)+'" name="id_rincian_kelompok_produk[]" class="form-control selectpicker" data-size="30" data-live-search="true" data-style="btn-white"><option value="">--Pilih Jenis Produk--</option></select></div> <div class="col-lg-1"><a onClick="hapusRincian('+(jumlahdatarincian+1)+')" class="btn btn-sm btn-danger m-r-5" style="color:white">X</a></div>   </div></div> </div>';
            $('#detail_datarincian').append(data_rincian);    
            
                $.ajaxSetup({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });            
                
                    $.ajax({
                        url: '{{ route('dependent_dropdown_rincian.store') }}',
                        method: 'POST',
                        data: {id: $id = document.getElementById("id_kelompok_produk").value},
                        success: function (response) {                                                
                            $('#id_rincian_kelompok_produk'+jumlahdatarincian).empty();                           
                            $.each(response, function (rincian_kelompok_produk, kode_klasifikasi) {                            
                                $("#id_rincian_kelompok_produk"+jumlahdatarincian).append(new Option(kode_klasifikasi+' | '+rincian_kelompok_produk, kode_klasifikasi+'. '+rincian_kelompok_produk))
                            })
                            $('#id_rincian_kelompok_produk'+jumlahdatarincian).selectpicker('refresh');
                        }                   
                    });                
                                    
            jumlahdatarincian+=1;            
        }

        function hapusRincian($id){
            // alert($id);            
            // var select1 = document.getElementById('detail_datarincian');
            var detaildatarincian = document.getElementById('detail_datarincian');
            var select2 = document.getElementById('rincian'+$id);
            detaildatarincian.removeChild(select2);
            // $('.detail_datarincian').removeChild(select2);            
        }

        // $(document).on('click','#hapus_datarincian', function(){                        
            // $(this).parent().parent().parent().remove();
        //     jumlahdataproduk-=1;

        //     if(jumlahdataproduk == 0){
        //         detaildataproduk.style.display = 'none';
        //     }            
        // });

        $(document).on('click','#hapus_dataproduk', function(){                        
            $(this).parent().parent().parent().remove();
            jumlahdataproduk-=1;

            if(jumlahdataproduk == 0){
                detaildataproduk.style.display = 'none';
            }            
        });                         

        $(function () {
                $.ajaxSetup({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });                                

            $('#id_kelompok_produk').on('change', function () {                                        
                $.ajax({
                    url: '{{ route('dependent_dropdown_rincian.store') }}',
                    method: 'POST',
                    data: {id: $(this).val()},
                    success: function (response) {                                                
                        $('#id_rincian_kelompok_produk1').empty();                           
                        $.each(response, function (rincian_kelompok_produk, kode_klasifikasi) {                            
                            $("#id_rincian_kelompok_produk1").append(new Option(kode_klasifikasi+' | '+rincian_kelompok_produk, kode_klasifikasi+'. '+rincian_kelompok_produk))
                        })
                        $('#id_rincian_kelompok_produk1').selectpicker('refresh');
                    }                   
                })
            });
        });

    </script> 

    <script>
    $(document).ready(function(){

        var current_fs, next_fs, previous_fs; //fieldsets
        var opacity;                        

        var jml = 1;

        $(".next").click(function(){              

            if(jml == 1){
                if(document.getElementById('no_registrasi_bpjph').value == null || document.getElementById('no_registrasi_bpjph').value == ""){
                    alert("Dimohon harap data diisi dengan benar.");
                }else{
                    jml++;
                    current_fs = $(this).parent().parent();
                    next_fs = $(this).parent().parent().next();        

                    //Add Class Active
                    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

                    //show the next fieldset
                    next_fs.show();
                    //hide the current fieldset with style
                    current_fs.animate({opacity: 0}, {
                    step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                    });
                    next_fs.css({'opacity': opacity});
                    },
                    duration: 600
                    });
                }
            }else if(jml == 2){
                if(document.getElementById('nama_perusahaan').value == "" || document.getElementById('alamat_perusahaan').value == "" || document.getElementById('telepon_perusahaan').value == "" || document.getElementById('alamat_pabrik').value == "" || document.getElementById('telepon_pabrik').value == "" || document.getElementById('nama_contact_person').value == "" || document.getElementById('contact_person').value == "" || document.getElementById('email').value == ""){
                    alert("Dimohon harap data diisi dengan benar.");
                }else{
                    jml++;
                    current_fs = $(this).parent().parent();
                    next_fs = $(this).parent().parent().next();        

                    //Add Class Active
                    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

                    //show the next fieldset
                    next_fs.show();
                    //hide the current fieldset with style
                    current_fs.animate({opacity: 0}, {
                    step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                    });
                    next_fs.css({'opacity': opacity});
                    },
                    duration: 600
                    });
                }
            }else if(jml == 3){                
                    jml++;
                    current_fs = $(this).parent().parent();
                    next_fs = $(this).parent().parent().next();        

                    //Add Class Active
                    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

                    //show the next fieldset
                    next_fs.show();
                    //hide the current fieldset with style
                    current_fs.animate({opacity: 0}, {
                    step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                    });
                    next_fs.css({'opacity': opacity});
                    },
                    duration: 600
                    });                
            }else if(jml == 4){
                if(document.getElementById('merk').value == ""){
                    alert("Dimohon harap data diisi dengan benar.");
                }else{
                    jml++;
                    current_fs = $(this).parent().parent();
                    next_fs = $(this).parent().parent().next();        

                    //Add Class Active
                    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

                    //show the next fieldset
                    next_fs.show();
                    //hide the current fieldset with style
                    current_fs.animate({opacity: 0}, {
                    step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                    });
                    next_fs.css({'opacity': opacity});
                    },
                    duration: 600
                    });
                }
            }
        });

        $(".previous").click(function(){
        jml--;

        current_fs = $(this).parent().parent();
        previous_fs = $(this).parent().parent().prev();

        //Remove class active
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

        //show the previous fieldset
        previous_fs.show();

        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
        step: function(now) {
        // for making fielset appear animation
        opacity = 1 - now;

        current_fs.css({
        'display': 'none',
        'position': 'relative'
        });
        previous_fs.css({'opacity': opacity});
        },
        duration: 600
        });
        });

        $('.radio-group .radio').click(function(){
        $(this).parent().find('.radio').removeClass('selected');
        $(this).addClass('selected');
        });

        $(".submit").click(function(){
        return false;
        })

        });   

        function getValue(y){
        	const x  = document.getElementById(y);        	

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

    <script src="{{asset('/assets/js/cleave.js')}}"></script>
    {{-- <script src="{{asset('/assets/js/main.js')}}"></script>     --}}
                    
@endpush