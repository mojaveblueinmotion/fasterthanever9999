@extends('layouts.modal')

@section('action', route($routes.'.update', $record->id))

@section('modal-body')
	@method('PATCH')
	<div class="form-group row">
		<label class="col-4 col-form-label">{{ __('Nama') }}</label>
		<div class="col-8 parent-group">
			<input type="text" name="name" value="{{ $record->name }}" class="form-control" placeholder="{{ __('Nama') }}">
		</div>
	</div>
    <div class="form-group row">
		<label class="col-4 col-form-label">{{ __('Email') }}</label>
		<div class="col-8 parent-group">
			<input type="email" name="email" value="{{ $record->email }}" class="form-control" placeholder="{{ __('Email') }}">
		</div>
	</div>
    <div class="form-group row">
		<label class="col-4 col-form-label">{{ __('Website') }}</label>
		<div class="col-8 parent-group">
			<input type="website" name="website" value="{{ $record->website }}" class="form-control" placeholder="{{ __('Website') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-4 col-form-label">{{ __('Telepon') }}</label>
		<div class="col-8 parent-group">
			<input type="text" name="phone" value="{{ $record->phone }}" class="form-control" placeholder="{{ __('Telepon') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-4 col-form-label">{{ __('Alamat') }}</label>
		<div class="col-8 parent-group">
			<textarea type="text" name="address" class="form-control" placeholder="{{ __('Address') }}">{{ $record->address }}</textarea>
		</div>
	</div>
    <div class="form-group row">
		<label class="col-4 col-form-label">{{ __('Provinsi') }}</label>
		<div class="col-8 parent-group">
            <select class="form-control base-plugin--select2" id="provinceCtrl" name="province_id">
                <option disabled selected value="">Pilih Provinsi</option>
                @foreach ($PROVINCES as $item)
                    <option @if($record->city->province_id == $item->id) selected @endif
                        value="{{ $item->id }}">
                        {{ $item->name }}
                    </option>
                @endforeach
            </select>
		</div>
	</div>
    <div class="form-group row">
        <label class="col-4 col-form-label">{{ __('Kota') }}</label>
        <div class="col-8 parent-group">
            <select class="form-control base-plugin--select2-ajax"
                data-url="{{ route('ajax.select-city', 'all') }}"
                data-url-origin="{{ route('ajax.select-city', 'all') }}"
                data-placeholder="{{ __('Pilih Kota') }}" id="cityCtrl" name="city_id">
                <option value="{{ $record->city_id }}" selected>{{ $record->city->name }}</option>
            </select>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document)
            .on('change', '#provinceCtrl', function() {
                let province_id = $('#provinceCtrl').val();
                if (province_id) {
                    var cityCtrl = $('#cityCtrl');
                    var urlOrigin = cityCtrl.data('url-origin');
                    var urlParam = $.param({
                        province_id: province_id,
                    });
                    cityCtrl.data('url', decodeURIComponent(decodeURIComponent(urlOrigin + '?' +
                        urlParam)));
                    cityCtrl.val(null).prop('disabled', false);
                    BasePlugin.initSelect2();
                }
            })
    </script>
@endpush
