@extends('layouts.modal')

@section('action', route($routes.'.update', $record->id))

@section('modal-body')
	@method('PATCH')
    <div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Tahun') }}</label>
		<div class="col-sm-8 parent-group text-right">
			<input type="text" value="{{ $record->year }}" name="year" class="form-control base-plugin--datepicker-3 width-100px ml-auto text-right" placeholder="{{ __('Tahun') }}">
		</div>
	</div>
    <div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Merk') }}</label>
		<div class="col-sm-8 parent-group">
			<input type="text" value="{{ $record->merk }}" name="merk" class="form-control" placeholder="{{ __('Merk') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Tipe') }}</label>
		<div class="col-sm-8 parent-group">
			<input type="text" value="{{ $record->type }}" name="type" class="form-control" placeholder="{{ __('Tipe') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label">{{ __('Deskripsi') }}</label>
		<div class="col-md-8 parent-group">
			<textarea name="description" class="form-control" placeholder="{{ __('Deskripsi') }}">{{ $record->description }}</textarea>
		</div>
	</div>
@endsection
