@extends('layouts.lists')

@section('filters')
<div class="row">
	<div class="col-12 col-sm-6 col-xl-3 pb-2 pr-1">
		<input type="text" class="form-control filter-control" data-post="id"
			placeholder="{{ __('ID Purchase Order') }}">
	</div>
	<div class="col-12 col-sm-6 col-md-4 pb-2 pl-1 pr-1">
		<div class="input-group">
			<input type="text" data-post="date_start" 
				class="form-control filter-control base-plugin--datepicker date-start" 
				placeholder="{{ __('Mulai') }}"
				data-options='@json([
					"format" => "dd/mm/yyyy",
					"startDate" => "",
					"endDate" => now()->format('d/m/Y')
				])'>
			<div class="input-group-append">
				<span class="input-group-text">
					<i class="la la-ellipsis-h"></i>
				</span>
			</div>
			<input type="text" data-post="date_end" 
				class="form-control filter-control base-plugin--datepicker date-end" 
				placeholder="{{ __('Selesai') }}"
				data-options='@json([
					"format" => "dd/mm/yyyy",
					"startDate" => "",
					"endDate" => now()->format('d/m/Y')
				])' disabled>
		</div>
	</div>
	{{-- <div class="col-12 col-sm-6 col-xl-3 pb-2 pl-1 pr-1">
		<select class="form-control filter-control base-plugin--select2-ajax"
			data-url="{{ route('ajax.selectVendor', 'all') }}"
			data-post="vendor_id"
			data-placeholder="{{ __('Vendor') }}">
		</select>
	</div> --}}
</div>
@endsection

@section('buttons-right')
{{-- @if (auth()->user()->checkPerms($perms.'.create')) --}}
@include('layouts.forms.btnAdd')
{{-- @endif --}}
@endsection

@push('scripts')
	<script>
		$(function () {
			var toTime = function (date) {
				var ds = date.split('/');
				var year = ds[2];
				var month = ds[1];
				var day = ds[0];
				return new Date(year+'-'+month+'-'+day).getTime();
			}

			$('.content-page').on('changeDate', 'input.date-start', function (value) {
				var me = $(this),
					startDate = new Date(value.date.valueOf()),
					date_end = me.closest('.input-group').find('input.date-end');

				if (me.val()) {
					if (toTime(me.val()) > toTime(date_end.val())) {
						date_end.datepicker('update', '')
							.datepicker('setStartDate', startDate)
							.prop('disabled', false);
					}
					else {
						date_end.datepicker('update', date_end.val())
							.datepicker('setStartDate', startDate)
							.prop('disabled', false);
					}
				}
				else {
					date_end.datepicker('update', '')
						.prop('disabled', true);
				}
			});
		});
	</script>
@endpush