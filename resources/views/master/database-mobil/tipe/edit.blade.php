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
				@if (!empty($record->tahun_id))
					<option value="{{ $record->tahun_id }}" selected>{{ $record->tahun->merk->name }}</option>
				@endif
            </select>
        </div>
    </div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label">{{ __('Tahun') }}</label>
		<div class="col-md-8 parent-group">
			<input type="hidden" name="tahun_id" value="{{ $record->tahun_id }}">
			<select name="tahun_id" class="form-control base-plugin--select2-ajax tahun_id"
				data-url="{{ route('ajax.tahunOptions', ['merk_id' => '']) }}"
				data-url-origin="{{ route('ajax.tahunOptions') }}" placeholder="{{ __('Pilih Salah Satu') }}" disabled
				required>
				<option value="">{{ __('Pilih Salah Satu') }}</option>
				@if (!empty($record->tahun_id))
					<option value="{{ $record->tahun_id }}" selected>{{ $record->tahun->tahun }}</option>
				@endif
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Nama') }}</label>
		<div class="col-sm-8 parent-group">
			<input type="text" value="{{ $record->name }}" name="name" class="form-control" placeholder="{{ __('Nama') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label">{{ __('Deskripsi') }}</label>
		<div class="col-md-8 parent-group">
			<textarea name="description" class="form-control" placeholder="{{ __('Deskripsi') }}">{{ $record->description }}</textarea>
		</div>
	</div>
@endsection
