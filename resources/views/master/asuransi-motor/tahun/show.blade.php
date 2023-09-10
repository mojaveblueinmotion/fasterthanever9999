@extends('layouts.modal')

@section('modal-body')
<div class="form-group row">
	<label class="col-md-4 col-form-label">{{ __('Merk') }}</label>
	<div class="col-md-8 parent-group">
		<select disabled name="merk_id" class="form-control base-plugin--select2-ajax merk_id"
			data-url="{{ route('ajax.selectMerkMotor', ['search' => 'all']) }}"
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
		<select disabled name="seri_id" class="form-control base-plugin--select2-ajax seri_id"
			data-url="{{ route('ajax.seriMotorOptions', ['merk_id' => '']) }}"
			data-url-origin="{{ route('ajax.seriMotorOptions') }}" placeholder="{{ __('Pilih Salah Satu') }}" disabled
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
		<input type="text" disabled name="tahun"
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
			<input class="form-control base-plugin--inputmask_currency harga" id="harga" disabled name="harga" inputmode="numeric"
			placeholder="{{ __('Harga') }}" value="{{ $record->harga }}">
		</div>
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
