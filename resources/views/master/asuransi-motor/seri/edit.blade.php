@extends('layouts.modal')

@section('action', route($routes.'.update', $record->id))

@section('modal-body')
	@method('PATCH')
	<div class="form-group row">
        <label class="col-md-4 col-form-label">{{ __('Merk') }}</label>
        <div class="col-md-8 parent-group">
            <select name="merk_id" class="form-control base-plugin--select2-ajax merk_id"
                data-url="{{ route('ajax.selectMerkMotor', ['search' => 'all']) }}"
                placeholder="{{ __('Pilih Salah Satu') }}">
                <option value="">{{ __('Pilih Salah Satu') }}</option>
				@if (!empty($record->merk_id))
					<option value="{{ $record->merk_id }}" selected>{{ $record->merk->name }}</option>
				@endif
            </select>
        </div>
    </div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Code') }}</label>
		<div class="col-sm-8 parent-group">
			<input type="text" name="code" class="form-control" value="{{ $record->code }}" placeholder="{{ __('Code') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Model') }}</label>
		<div class="col-sm-8 parent-group">
			<input type="text" name="model" class="form-control" value="{{ $record->model }}" placeholder="{{ __('Model') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label">{{ __('Deskripsi') }}</label>
		<div class="col-md-8 parent-group">
			<textarea name="description" class="form-control" placeholder="{{ __('Deskripsi') }}">{{ $record->description }}</textarea>
		</div>
	</div>
@endsection
