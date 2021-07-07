@extends('layouts.default', ['boxedLayout' => true], ['sidebarLight' => true], ['sidebarWide' => true])

@section('title', 'Pelanggan')

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
        <li class="breadcrumb-item active"><a href="#">Pelanggan</a></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Pelanggan  <small></small></h1>
    <!-- end page-header -->
    <!-- begin panel -->
    <div class="panel panel-inverse">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <h4 class="panel-title">Pelanggan</h4>
            @if ( auth()->user()->usergroup_id == 3)
                <div class="panel-heading-btn">
                    <a href="{{route('user.create')}}" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Tambah Data</a>
                    <a href="#" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                </div>
            @endif
        </div>
        <!-- end panel-heading -->
        <!-- begin panel-body -->
        <div class="panel-body ">
            <table id="table" class="table table-responsive table-bordered table-td-valign-middle table-sm wrap" cellspacing="0" style="width:100%;">
                <thead>
                <tr>
                    <th class=" valign-middle text-center">No</th>
                    <th class="valign-middle text-center" style="width:10%;word-break:break-all;">Email</th>
                    <th class="valign-middle text-center" style="width:10%;word-break:break-all;">Username</th>
                    <th class="valign-middle text-center" style="width:10%;word-break:break-all;">Name</th>
                    <th class="valign-middle text-center" style="width:10%;word-break:break-all;">Perusahaan</th>
                    <th class="valign-middle text-center">Negara</th>
                    <th class="valign-middle text-center">Kota</th>
                    <th class="valign-middle text-center">Alamat</th>
                    <th class="valign-middle text-center">Password</th>
                    <th class="valign-middle text-center">Status</th>
                    @if ( auth()->user()->usergroup_id == 3)
                         <th class="valign-middle text-center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Aksi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    @endif
                   
                </tr>
                </thead>
            </table>
        </div>
        <!-- end panel-body -->
    </div>

    <div id="modalpassword" class="modal fade" role="dialog">
        <div class="modal-dialog">

           
            <div class="modal-content">
                <div class="modal-header">
                    
                    <h4 class="modal-title">Encripted Password</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>

                <div class = "modal-body">
                    <div >
                        <label id="password" name="password")">password</label>
                     
                    </div>
                </div>
                <div class = "modal-footer">
                    <div >
                        <button class="btn btn-sm btn-success" onclick="copy(password)" >Salin</button>
                     
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- end panel -->
@endsection
@push('scripts')
    <script src="{{asset('/assets/js/checkData.js')}}"></script>
   
    <script>

        var role = {!! json_encode((array)auth()->user()->usergroup_id) !!};

        $('#modalpassword').on('show.bs.modal', function(e) {



            var $this = $(e.relatedTarget);
            var password = $this.data('password');
            var modal = $('#modalpassword');
            
            modal.find('#password').text(password);
            modal.find('#modalpassword').attr('action', function (i,old) {
            return old + '/' + password;
        
            });

        });

        function copy(element){
            // var modal = $('#modalpassword');    
            // var copyText =  modal.find('#password');

            // var copyText = document.querySelector('#password');
            // copyText.select();
            // document.execCommand("copy");
            // /* Alert the copied text */
            // alert("Copied the text: " + copyText.value);
            var range, selection, worked;

            if (document.body.createTextRange) {
                range = document.body.createTextRange();
                range.moveToElementText(element);
                range.select();
            } else if (window.getSelection) {
                selection = window.getSelection();        
                range = document.createRange();
                range.selectNodeContents(element);
                selection.removeAllRanges();
                selection.addRange(range);
            }
            
            try {
                document.execCommand('copy');
                alert('text copied');
            }
            catch (err) {
                alert('unable to copy text');
            }

        }


        //console.log("SHOW");
        if(role == 1){
            $('#table').DataTable({
               
                columns:[
                    {
                        "data":null,
                        "searchable":false,
                        "orderable":false,
                        "render":function (data,type,full,meta) {
                            return meta.row + 1;
                            //console.log(data);
                        }
                    },
                    {"data":"email"},
                    {"data":"username"},
                    {"data":"name"},
                    {"data":"perusahaan"},
                    {"data":"negara"},
                    {"data":"kota"},
                    {"data":"alamat"},
                    {
                        "data":null,
                        "searchable":false,
                        "orderable":false,
                        "render":function (data,type,full,meta) {

                        
                            return `<button class="btn btn-xs btn-primary m-r-5" data-toggle='modal' data-password='`+full.password+`' data-target='#modalpassword' >View</button>`

                        
                        }
                    },
                    {
                    "data":"status",
                    "render":function (data) {return checkStatus(data);}
                    }
                    
                        
                    
                
                ],
                processing:true,
                serverSide:true,
                ajax:"{{route('system.user.datapelanggan')}}",
                order:[[0,'asc']]
            });

        }else if(role==3){
            $('#table').DataTable({
                   
                columns:[
                    {
                        "data":null,
                        "searchable":false,
                        "orderable":false,
                        "render":function (data,type,full,meta) {
                            return meta.row + 1;
                            console.log(data);
                        }
                    },
                    {"data":"email"},
                    {"data":"username"},
                    {"data":"name"},
                    {"data":"perusahaan"},
                    {"data":"negara"},
                    {"data":"kota"},
                    {"data":"alamat"},
                    {
                        "data":null,
                        "searchable":false,
                        "orderable":false,
                        "render":function (data,type,full,meta) {

                        
                            return `<button class="btn btn-xs btn-primary m-r-5" data-toggle='modal' data-password='`+full.password+`' data-target='#modalpassword' >View</button>`

                        
                        }
                    },
                
                    
                    {
                    "data":"status",
                    "render":function (data) {return checkStatus(data);}
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
                                
                                    <a href="{{url('system/user')}}/`+full.id+`/edit" class="dropdown-item" ><i class="fa fa-edit"></i> Edit</a>

                                    <form class="forDelete dropdown-item" action="{{url('system/user')}}/${full.id}" method="post" style="padding:0px;">
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
                ajax:"{{route('system.user.datapelanggan')}}",
                order:[[0,'asc']]
            });
        }
      
        $(".fordelete").on("submit",function () {
            return confirm("Apakah anda yakin?");
        });
    </script>
@endpush