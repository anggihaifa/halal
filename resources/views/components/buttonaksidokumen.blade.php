<!-- update_status_has -->
<td>
	<div class="btn-group m-r-5 show">
		<a href="#" class="btn btn-info btn-xs">Aksi</a>
		<a href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle btn-xs" aria-expanded="true"><b class="ion-ios-arrow-down"></b></a>
		<div class="dropdown-menu dropdown-menu-right dropdownIcon" x-placement="top-end">
			<!-- <a href="{{url('master/jenis_registrasi')}}/`+full.id+`/edit" class="dropdown-item" ><i class="fa fa-edit" onclick= "return confirm('Apakah anda yakin untuk menghapus data??')"></i> Approve</a> -->
			<a href="{{url('update_status_has')}}/{{$registrasi}}/{{$id}}/{{$name}}/1" class="dropdown-item" onclick= "return confirm('Apakah dokumen sesuai ??')"><i class="ion-md-checkmark-circle-outline" ></i> Approve</a>
			<a href="{{url('update_status_has')}}/{{$registrasi}}/{{$id}}/{{$name}}/2" class="dropdown-item" onclick= "return confirm('Apakah dokumen sesuai ??')" ><i class="ion-ios-remove-circle-outline"></i> Reject</a>
		</div>
	</div>
</td>