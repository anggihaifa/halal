@extends('layouts.default', ['boxedLayout' => true], ['sidebarLight' => true], ['sidebarWide' => true])

@section('title', 'Edit Pengguna')

@push('css')
    <link href="{{asset('/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item active">Edit Data Pengguna</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Edit Pengguna<small></small></h1>
    <!-- end page-header -->
    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-xl-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-plugins-7">
                <!-- begin panel-heading -->
                <div class="panel-heading">
                    <h4 class="panel-title">Edit Pengguna</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    </div>
                </div>
                <!-- end panel-heading -->
                <!-- begin panel-body -->
                <div class="panel-body panel-form">
                    <form action="{{route('system.user.updateprofile')}}" method="post"  class="form-horizontal form-bordered" enctype="multipart/form-data">
                        <div class="form-group row">
                        @if($data->usergroup_id == 2)

                            @csrf
                            @component('components.inputtext',['name'=> 'username','label' => 'Username','value'=>$data->username])@endcomponent
                            @component('components.inputtext',['name'=> 'name','label' => 'Nama','value'=>$data->name])@endcomponent
                            @component('components.inputemail',['name'=> 'email','label' => 'Email','value'=>$data->email])@endcomponent
                            @component('components.inputtext',['name'=> 'perusahaan','label' => 'Perusahaan','value'=>$data->perusahaan])@endcomponent
                            @component('components.inputtext',['name'=> 'negara','label' => 'Negara','value'=>$data->negara])@endcomponent
                            @component('components.inputtext',['name'=> 'kota','label' => 'Kota','value'=>$data->kota])@endcomponent
                            @component('components.inputtextarea',['name'=> 'alamat','label' => 'Alamat','value'=>$data->alamat])@endcomponent                          
                        
                        
                        @else

                            @csrf
                           
                           
                            @component('components.inputimage',['name'=> 'foto','label' => 'Foto', 'value'=>$data2->foto])@endcomponent
                            
                           
                            @component('components.inputtext',['name'=> 'username','label' => 'Username','value'=>$data->username])@endcomponent
                            @component('components.inputtext',['name'=> 'name','label' => 'Nama','value'=>$data->name])@endcomponent
                            <label for="jenis_kelamin" class="col-lg-4 col-form-label">Jenis Kelamin</label>

                            <div class="col-lg-8">
                                <select id="jenis_kelamin" name="jenis_kelamin" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white" required>
                                    <option value="">--Pilih Jenis Kelamin--</option>
                                    <option value="Laki Laki" {{ $data2->jenis_kelamin == 'Laki Laki' ?  'selected' : ''}}>Laki Laki</option>
                                    <option value="Perempuan" {{ $data2->jenis_kelamin == 'Perempuan' ?  'selected' : ''}}>Perempuan</option>
                                       
                                </select>
                            </div>
                            <label for="status_karyawan" class="col-lg-4 col-form-label">Status Karyawan</label>

                            <div class="col-lg-8">
                                <select id="status_karyawan" name="status_karyawan"  class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white" required >
                                    <option value="">--Pilih Status Karyawan--</option>
                                    
                                    <option value="PT"{{ $data2->status_karyawan == 'PT' ?  'selected' : ''}}>Pegawai Tetap</option>
                                    <option value="PTT" {{ $data2->status_karyawan == 'PTT' ?  'selected' : ''}}>Pegawai Tidak Tetap</option>
                                    <option value="LS" {{ $data2->status_karyawan == 'LS' ?  'selected' : ''}}>LS</option>
                                       
                                </select>
                            </div>
                            <label for="kode_wilayah" class="col-lg-4 col-form-label">Asal Kantor</label>
                            <div class="col-lg-8">
                                <select id="kode_wilayah" name="kode_wilayah" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white" required >
      
                                    @foreach($cabang as $dataCabang =>$value){
                                        <option value="{{$value->ATTRIBUTE2}}" {{$value->ATTRIBUTE2 == $data->kode_wilayah ? 'selected' : ''}}>{{$value->NAME}}</option>
                                        
                                        </option>
                                        
                                    @endforeach

                                </select>
                            </div>
                                        
                            @component('components.inputtext',['name'=> 'telp','label' => 'Telepon/ HP','value'=>$data2->telp, 'placeholder'=>'Telepon/ HP'])@endcomponent
                            @component('components.inputemail',['name'=> 'email','label' => 'Email','value'=>$data->email])@endcomponent
                            @component('components.inputtext',['name'=> 'noreg_bpjph','label' => 'Nomor Registrasi BPJPH','value'=>$data2->noreg_bpjph, 'placeholder'=>'Nomor Registrasi Auditor di SIHALAL BPJPH'] )@endcomponent
                            @component('components.inputtext',['name'=> 'no_sertifikat_diklat','label' => 'Nomor Sertifikat Diklat','value'=>$data2->no_sertifikat_diklat, 'placeholder'=>'Nomor Sertifikat Diklat'] )@endcomponent
                            <label class="col-lg-4 col-form-label">Uji Kompetensi</label>
							<div class="col-lg-8">
                                <table>
                                        <td>
                                            <input id="no_ujikom" name="no_ujikom" type="text" class="form-control " placeholder="Nomor Uji Kompetensi" value={{ $data2->no_ujikom}} >
                                        </td>

                                        <td>
                                            <input id="masaberlaku_ujikom" name="masaberlaku_ujikom" type="text" class="form-control " placeholder="Masa Berlaku Uji Kompetensi" value={{ $data2->masaberlaku_ujikom}} >
                                        </td>
                                </table>
								
                               
							
							</div>
                            @component('components.inputtext',['name'=> 'pendidikan','label' => 'Pendidikan Terakhir','value'=>$data2->pendidikan, 'placeholder'=>'Pendidikan Terakhir'])@endcomponent
                            <label class="col-lg-4 col-form-label">Pelatihan</label>
							<div class="col-lg-8">
                                
                                <input id="pelatihan" name="pelatihan" type="text" class="form-control " placeholder="Pelatihan" multiple="true" value={{ $data2->pelatihan}} >
                              
							</div>
                            @component('components.inputtext',['name'=> 'perusahaan','label' => 'Perusahaan','value'=>$data->perusahaan])@endcomponent
                            @component('components.inputtext',['name'=> 'perusahaan','label' => 'Perusahaan','value'=>$data->perusahaan])@endcomponent
                            @component('components.inputtext',['name'=> 'negara','label' => 'Negara','value'=>$data->negara])@endcomponent
                            @component('components.inputtext',['name'=> 'kota','label' => 'Kota','value'=>$data->kota])@endcomponent
                            @component('components.inputtextarea',['name'=> 'alamat','label' => 'Alamat','value'=>$data->alamat])@endcomponent                          

                        @endif    
                            <div class="col-md-12 offset-md-5">
                                @component('components.buttonback',['href' => route("home.index")])@endcomponent
                                @component('components.buttonsubmit')@endcomponent
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
    <script src="{{asset('/assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/select2/dist/js/select2.min.js')}}"></script>
    <script>

        $('#masaberlaku_ujikom').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
        });
        var loadFile = function(event) {
            var image = document.getElementById('output');
            image.src = URL.createObjectURL(event.target.files[0]);
        };
                           
       $('#email').on('keyup', function () {
            var ev = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;
            var x = document.getElementById("check");
            var y = $('#email').val();
            console.log(y);
            if(!ev.test(y)){
                x.innerHTML	= "Not a valid email";
                x.style.color = "red"
            }else{
                x.innerHTML	= "<i class='fa fa-check'></i>";
                x.style.color = "green"
            }

        });
    </script>
@endpush