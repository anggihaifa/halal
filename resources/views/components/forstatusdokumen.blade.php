<td class="valign-middle text-center">
	@if($value == null)
		<i class="ion-ios-paper fa-lg" style="color:#ababab" title="Belum diperiksa"></i>
	@elseif($value == 1)
		<i class="ion-ios-paper fa-lg" style="color:#2fca2f" title="Sesuai"></i>
	@else
		<i class="ion-ios-paper fa-lg" style="color:#e46464" title="Revisi"></i>
	@endif
</td>