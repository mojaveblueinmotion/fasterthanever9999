@extends('layouts.modal')

@section('action', route($routes.'.store'))

@section('modal-body')
	@method('POST')
	<div class="form-group row">
        <label class="col-md-4 col-form-label">{{ __('Merk') }}</label>
        <div class="col-md-8 parent-group">
            <select name="merk_id" class="form-control base-plugin--select2-ajax merk_id"
                data-url="{{ route('ajax.selectMerkMotor', ['search' => 'all']) }}"
                placeholder="{{ __('Pilih Salah Satu') }}">
                <option value="">{{ __('Pilih Salah Satu') }}</option>
            </select>
        </div>
    </div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label">{{ __('Seri') }}</label>
		<div class="col-md-8 parent-group">
			<select name="seri_id" class="form-control base-plugin--select2-ajax seri_id"
				data-url="{{ route('ajax.seriMotorOptions', ['merk_id' => '']) }}"
				data-url-origin="{{ route('ajax.seriMotorOptions') }}" placeholder="{{ __('Pilih Salah Satu') }}" disabled
				required>
				<option value="">{{ __('Pilih Salah Satu') }}</option>
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
				placeholder="{{ __('Harga') }}">
			</div>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label">{{ __('Deskripsi') }}</label>
		<div class="col-md-8 parent-group">
			<textarea name="description" class="form-control" placeholder="{{ __('Deskripsi') }}"></textarea>
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