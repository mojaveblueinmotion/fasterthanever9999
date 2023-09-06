@extends('layouts.modal')

@section('action', route($routes.'.store'))

@section('modal-body')
	@method('POST')
	<div class="form-group row">
        <label class="col-md-4 col-form-label">{{ __('Merk') }}</label>
        <div class="col-md-8 parent-group">
            <select name="merk_id" class="form-control base-plugin--select2-ajax merk_id"
                data-url="{{ route('ajax.selectMerk', ['search' => 'all']) }}"
                placeholder="{{ __('Pilih Salah Satu') }}">
                <option value="">{{ __('Pilih Salah Satu') }}</option>
            </select>
        </div>
    </div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label">{{ __('Tahun') }}</label>
		<div class="col-md-8 parent-group">
			<select name="tahun_id" class="form-control base-plugin--select2-ajax tahun_id"
				data-url="{{ route('ajax.tahunOptions', ['merk_id' => '']) }}"
				data-url-origin="{{ route('ajax.tahunOptions') }}" placeholder="{{ __('Pilih Salah Satu') }}" disabled
				required>
				<option value="">{{ __('Pilih Salah Satu') }}</option>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Nama') }}</label>
		<div class="col-sm-8 parent-group">
			<input type="text" name="name" class="form-control" placeholder="{{ __('Nama') }}">
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
					var objectId = $('select.tahun_id');
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