@extends('layouts.modal')

@section('action', route($routes.'.update', $record->id))

@section('modal-body')
	@method('PATCH')
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Nama') }}</label>
		<div class="col-sm-8 parent-group">
			<input type="text" value="{{ $record->name }}" name="name" class="form-control" placeholder="{{ __('Nama') }}">
		</div>
	</div>
	<div class="form-group row">
        <label class="col-md-4 col-form-label">{{ __('Status') }}</label>
        <div class="col-md-8 parent-group">
            <select name="status" class="form-control base-plugin--select2-ajax status"
                placeholder="{{ __('Pilih Salah Satu') }}">
                <option value="">{{ __('Pilih Salah Satu') }}</option>
                <option @if($record->status == 'populer') selected @endif value="populer">{{ __('Populer') }}</option>
                <option @if($record->status == 'non-populer') selected @endif value="non-populer">{{ __('Non Populer') }}</option>
            </select>
        </div>
    </div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label">{{ __('Deskripsi') }}</label>
		<div class="col-md-8 parent-group">
			<textarea name="description" class="form-control" placeholder="{{ __('Deskripsi') }}">{{ $record->description }}</textarea>
		</div>
	</div>
@endsection
