@extends('layouts.default')

@section('title', 'Master F.A.Q')

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="#">Master</a></li>
        <li class="breadcrumb-item active"><a href="#">F.A.Q</a></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Master F.A.Q  <small></small></h1>
    <!-- end page-header -->
    <!-- begin panel -->
    <div class="panel panel-inverse">
        <!-- begin panel-heading -->        
        <div class="panel-heading">
            <h4 class="panel-title">Master F.A.Q </h4>
            <div class="panel-heading-btn">
                {{-- <a href="{{route('faq.create')}}" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Tambah Data</a> --}}
                <a href="#" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            </div>
        </div>
        <!-- end panel-heading -->
        <!-- begin panel-body -->
        <div class="panel-body table-responsive">
            @if($user['usergroup_id']==1)
            <table id="table" class="table table-striped table-bordered table-td-valign-middle " cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-nowrap valign-middle text-center">No</th>
                        <th class="text-nowrap valign-middle text-center">Pertanyaan</th>
                        <th class="text-nowrap valign-middle text-center">Step</th>
                        <th class="text-nowrap valign-middle text-center">Status</th>
                        <th class="text-nowrap valign-middle text-center">Aksi</th>
                    </tr>
                </thead>
            </table>
            @else            
            <div class="modal-body" style="max-height:415px;overflow:auto;">
                    <div id="accordion" class="accordion">
                        @foreach($dataFaq as $index => $value)
                            <!-- begin card -->
                            <div class="card">
                                <div class="card-header pointer-cursor d-flex align-items-center" data-toggle="collapse" data-target="#collapse{{$value['id']}}" style="cursor: pointer;">
                                    <img class="animated bounceIn " src="{{asset('/assets/img/user/halal-ask-0.png')}}" alt="" style="height: 30px;margin-right: 10px;"> 
                                    <span class="faq-ask">{{ucwords($value['question'])}}</span>
                                </div>
                                <div id="collapse{{$value['id']}}" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <?php echo html_entity_decode($value['answer'])?>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        <!-- end panel-body -->
    </div>
    <!-- end panel -->
@endsection
@push('scripts')
    <script src="{{asset('/assets/js/checkData.js')}}"></script>
    <script>
        $('#table').DataTable({
            columns:[
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {
                        return meta.row + 1;
                    }
                },
                {
                    "data":"question"
                },
                {
                    "data":"step"
                },
                {
                    "data":"status",
                    "render":function (data) {return checkStatusFaq(data);}
                },
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {
                        return `<div class="btn-group m-r-5 show">
                                <a href="#" class="btn btn-info btn-xs">Pilih Aksi</a>
                                <a href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle btn-xs" aria-expanded="true"><b class="ion-ios-arrow-down"></b></a>
                                <div class="dropdown-menu dropdown-menu-right dropdownIcon" x-placement="top-end">

                                    <a href="{{url('faq_detail')}}/`+full.id+`" class="dropdown-item" ><i class="fa fa-eye"></i> Detail</a>

                                    <a href="{{url('master/faq')}}/`+full.id+`/edit" class="dropdown-item" ><i class="fa fa-edit"></i> Edit</a>
                                    
                                    <form class="forDelete dropdown-item" action="{{url('master/faq')}}/${full.id}" method="post" style="padding:0px;">
                                        @csrf
                                        @method('DELETE')
                                            <button type="submit" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk menghapus data??')" style="outline:none;"><i class="ion-ios-trash"></i> Delete</button>
                                        </form>       
                                </div>
                            </div>`    
                    }
                }

            ],
            processing:true,
            serverSide:true,
            ajax:"{{route('master.faq.datatable')}}",
            order:[[0,'asc']],
            'columnDefs': [
                 {
                      "targets": 3,
                      "className": "text-center",
            }],
        });
        $(".fordelete").on("submit",function () {
            return confirm("Apakah anda yakin?");
        });
    </script>
@endpush