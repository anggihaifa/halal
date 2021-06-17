<td class="valign-middle text-center">
	@if($value == null || $value == '0')
	 	<a style="background-color:black; color:white">Belum Diperiksa</a>
		
	@elseif($value == 2)
		<a style="background-color:red ; color:white">Perbaikan</a>
		
		
	@else
		<a style="background-color:green ; color:white">Sesuai</a>

	
		
	@endif
</td>