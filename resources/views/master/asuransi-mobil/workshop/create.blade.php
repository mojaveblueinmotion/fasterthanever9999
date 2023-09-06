@extends('layouts.modal')

@section('action', route($routes.'.store'))

@section('modal-body')
	@method('POST')
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Nama Workshop') }}</label>
		<div class="col-sm-8 parent-group">
			<input type="text" name="name" class="form-control" placeholder="{{ __('Nama Workshop') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label">{{ __('Provinsi') }}</label>
		<div class="col-md-8 parent-group">
			<select name="province_id" class="form-control base-plugin--select2-ajax province_id"
				data-url="{{ route('ajax.selectProvinceForCity', [
					'search'=>'all'
				]) }}"
				data-url-origin="{{ route('ajax.selectProvinceForCity', [
					'search'=>'all'
				]) }}"
				placeholder="{{ __('Pilih Salah Satu') }}">
				<option value="">{{ __('Pilih Salah Satu') }}</option>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label">{{ __('Kota') }}</label>
		<div class="col-md-8 parent-group">
			<select name="city_id" class="form-control base-plugin--select2-ajax city_id"
				data-url="{{ route('ajax.cityOptions', ['province_id' => '']) }}"
				data-url-origin="{{ route('ajax.cityOptions') }}"
				placeholder="{{ __('Pilih Salah Satu') }}" disabled>
				<option value="">{{ __('Pilih Salah Satu') }}</option>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Link Google Maps') }}</label>
		<div class="col-sm-8 parent-group">
			<input type="text" name="link_maps" class="form-control" placeholder="{{ __('Link Google Maps') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label">{{ __('Alamat') }}</label>
		<div class="col-md-8 parent-group">
			<textarea name="alamat" class="form-control" placeholder="{{ __('Alamat') }}"></textarea>
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
			$('.content-page').on('change', 'select.province_id', function (e) {
				var me = $(this);
				if (me.val()) {
					var objectId = $('select.city_id');
					var urlOrigin = objectId.data('url-origin');
					var urlParam = $.param({province_id: me.val()});
					objectId.data('url', decodeURIComponent(decodeURIComponent(urlOrigin+'?'+urlParam)));
					objectId.val(null).prop('disabled', false);
				}
				BasePlugin.initSelect2();
			});
		});
	</script>
@endpush