@extends('layouts.modal')

@section('modal-body')
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Nama Workshop') }}</label>
		<div class="col-sm-8 parent-group">
			<input disabled type="text" value="{{ $record->name }}" name="name" class="form-control" placeholder="{{ __('Nama Workshop') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label">{{ __('Provinsi') }}</label>
		<div class="col-md-8 parent-group">
			<select disabled class="form-control base-plugin--select2-ajax province_id"
				data-url="{{ route('ajax.selectProvinceForCity', [
					'search'=>'all'
				]) }}"
				data-url-origin="{{ route('ajax.selectProvinceForCity', [
					'search'=>'all'
				]) }}"
				placeholder="{{ __('Pilih Salah Satu') }}" required>
				<option value="">{{ __('Pilih Salah Satu') }}</option>
				@if (!empty($record->city->province_id))
					<option value="{{ $record->city->province_id }}" selected>{{ $record->city->province->name }}</option>
				@endif
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label">{{ __('Kota') }}</label>
		<div class="col-md-8 parent-group">
			<select disabled name="city_id" class="form-control base-plugin--select2-ajax city_id"
				data-url="{{ route('ajax.cityOptions', ['province_id' => '']) }}"
				data-url-origin="{{ route('ajax.cityOptions') }}"
				placeholder="{{ __('Pilih Salah Satu') }}" disabled required>
				<option value="">{{ __('Pilih Salah Satu') }}</option>
				@if (!empty($record->city_id))
					<option value="{{ $record->city_id }}" selected>{{ $record->city->name }}</option>
				@endif
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Link Google Maps') }}</label>
		<div class="col-sm-8 parent-group">
			<input disabled type="text" value="{{ $record->link_maps }}" name="link_maps" class="form-control" placeholder="{{ __('Link Google Maps') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label">{{ __('Alamat') }}</label>
		<div class="col-md-8 parent-group">
			<textarea disabled name="alamat" class="form-control" placeholder="{{ __('Alamat') }}">{{ $record->alamat }}</textarea>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label">{{ __('Deskripsi') }}</label>
		<div class="col-md-8 parent-group">
			<textarea disabled name="description" class="form-control" placeholder="{{ __('Deskripsi') }}">{{ $record->description }}</textarea>
		</div>
	</div>
@endsection

@section('modal-footer')
@endsection
