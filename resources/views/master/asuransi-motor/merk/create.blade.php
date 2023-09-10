@extends('layouts.modal')

@section('action', route($routes.'.store'))

@section('modal-body')
	@method('POST')
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Nama') }}</label>
		<div class="col-sm-8 parent-group">
			<input type="text" name="name" class="form-control" placeholder="{{ __('Nama') }}">
		</div>
	</div>
	<div class="form-group row">
        <label class="col-md-4 col-form-label">{{ __('Status') }}</label>
        <div class="col-md-8 parent-group">
            <select name="status" class="form-control base-plugin--select2-ajax status"
                placeholder="{{ __('Pilih Salah Satu') }}">
                <option value="">{{ __('Pilih Salah Satu') }}</option>
                <option value="populer">{{ __('Populer') }}</option>
                <option selected value="non-populer">{{ __('Non Populer') }}</option>
            </select>
        </div>
    </div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label">{{ __('Deskripsi') }}</label>
		<div class="col-md-8 parent-group">
			<textarea name="description" class="form-control" placeholder="{{ __('Deskripsi') }}"></textarea>
		</div>
	</div>
@endsection
