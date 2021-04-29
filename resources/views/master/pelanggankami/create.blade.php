@extends('layouts.landingpage', ['paceTop' => true, 'bodyExtraClass' => 'bg-white'])
{{-- @extends('layouts.landingpage') --}}

@section('title', 'Beranda')

@push('css')
    <link href="{{asset('/assets/css/animate.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/css/customize.css')}}" rel="stylesheet" />
@endpush

@section('content')                                  
    <div class="container-fluid col-lg-12">       
        <div class="row col-lg-11 ml-5 mt-5">
            <!-- begin panel-body -->
            <h3>Pelanggan Kami</h3>
            <div class="panel-body table-responsive">
                @foreach($dataPelanggan as $index => $value)
                    <div class="p-15 bg-white m-5 shadow-sm">
                        <table>
                            <tr>                                
                                <td>
                                    <h4>{{$value['nama_perusahaan']}} ({{$value['no_registrasi']}})</h4>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>Alamat Perusahaan : </p>
                                </td>
                                <td>
                                    <p>{{$value['alamat']}}</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>Tanggal Audit : </p>
                                </td>
                                <td>
                                    <p>{{$value['mulai_audit1']}} <b>s/d</b> {{$value['selesai_audit2']}}</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>Nama Contact Person : </p>
                                </td>
                                <td>
                                    <p>{{$value['nama_pj']}} ({{$value['telepon_pj']}})</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>Jabatan : </p>
                                </td>
                                <td>
                                    <p>{{$value['jabatan_pj']}}</p>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <p>Skema Audit : </p>
                                </td>
                                <td>
                                    <p>JPH</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>Nomor Kontrak/Akad : </p>
                                </td>
                                <td>
                                    <p>-</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>Nomor Sertifikat : </p>
                                </td>
                                <td>
                                    <p>-</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>Tanggal Sertifikat : </p>
                                </td>
                                <td>
                                    <p>-</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>Tanggal Berakhir Sertifikat : </p>
                                </td>
                                <td>
                                    <p>-</p>
                                </td>
                            </tr>
                        </table>                        
                    </div>
                @endforeach                            
            </div>
            <!-- end panel-body -->        
        </div>        
    </div>        
    
@endsection