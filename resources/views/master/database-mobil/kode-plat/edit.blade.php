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
		<label class="col-md-4 col-form-label">{{ __('Daerah') }}</label>
		<div class="col-md-8 parent-group">
			<input value="{{ $record->daerah }}" type="text" name="daerah" class="form-control" placeholder="{{ __('Daerah') }}">
		</div>
	</div>
@endsection
