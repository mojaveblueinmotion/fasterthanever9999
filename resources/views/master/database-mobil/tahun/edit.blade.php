@extends('layouts.modal')

@section('action', route($routes.'.update', $record->id))

@section('modal-body')
	@method('PATCH')
	<div class="form-group row">
        <label class="col-md-4 col-form-label">{{ __('Merk') }}</label>
        <div class="col-md-8 parent-group">
            <select name="merk_id" class="form-control base-plugin--select2-ajax merk_id"
                data-url="{{ route('ajax.selectMerk', ['search' => 'all']) }}"
                placeholder="{{ __('Pilih Salah Satu') }}">
                <option value="">{{ __('Pilih Salah Satu') }}</option>
				@if (!empty($record->seri_id))
					<option value="{{ $record->seri->merk_id }}" selected>{{ $record->seri->merk->name }}</option>
				@endif
            </select>
        </div>
    </div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label">{{ __('Seri') }}</label>
		<div class="col-md-8 parent-group">
			<input type="hidden" name="seri_id" value="{{ $record->seri_id }}">
			<select name="seri_id" class="form-control base-plugin--select2-ajax seri_id"
				data-url="{{ route('ajax.seriOptions', ['merk_id' => '']) }}"
				data-url-origin="{{ route('ajax.seriOptions') }}" placeholder="{{ __('Pilih Salah Satu') }}" disabled
				required>
				<option value="">{{ __('Pilih Salah Satu') }}</option>
				@if (!empty($record->seri_id))
					<option value="{{ $record->seri_id }}" selected>{{ $record->seri->code }} ({{ $record->seri->model }})</option>
				@endif
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label">{{ __('Tahun') }}</label>
		<div class="col-md-8 parent-group">
			<input type="text" name="tahun"
				class="form-control base-plugin--datepicker-3"
				data-options='@json([
					"startDate" => "",
					"endStart" => ""
				])'
				value="{{ $record->tahun }}"
				placeholder="{{ __('Tahun') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label">{{ __('Harga') }}</label>
		<div class="col-md-8 parent-group">
			<div class="input-group">
				<div class="input-group-prepend"><span
						class="input-group-text font-weight-bolder">Rp.</span></div>
				<input class="form-control base-plugin--inputmask_currency harga" id="harga" name="harga" inputmode="numeric"
				placeholder="{{ __('Harga') }}" value="{{ $record->harga }}">
			</div>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label">{{ __('Deskripsi') }}</label>
		<div class="col-md-8 parent-group">
			<textarea name="description" class="form-control" placeholder="{{ __('Deskripsi') }}">{{ $record->description }}</textarea>
		</div>
	</div>
@endsection

@push('scripts')
<script>
	$(function () {
			$('.content-page').on('change', 'select.merk_id', function (e) {
				var me = $(this);
				if (me.val()) {
					var objectId = $('select.seri_id');
					var urlOrigin = objectId.data('url-origin');
					var urlParam = $.param({merk_id: me.val()});
					objectId.data('url', decodeURIComponent(decodeURIComponent(urlOrigin+'?'+urlParam)));
					objectId.val(null).prop('disabled', false);
				}
				BasePlugin.initSelect2();
			});
		});
</script>
@endpush