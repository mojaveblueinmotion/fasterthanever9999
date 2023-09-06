@extends('layouts.modal')

@section('action', route($routes.'.update', $record->id))

@section('modal-body')
	@method('PATCH')
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Unit Kerja') }}</label>
		<div class="col-sm-12 parent-group">
			<select name="location_id" class="form-control base-plugin--select2-ajax"
				data-url="{{ route('ajax.select-struct', 'parent_position') }}"
				data-placeholder="{{ __('Pilih Salah Satu') }}">
				@if ($record->location)
					<option value="{{ $record->location->id }}" selected>{{ $record->location->name }}</option>
				@endif
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Nama') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" name="name" value="{{ $record->name }}" class="form-control" placeholder="{{ __('Nama') }}">
		</div>
	</div>
@endsection
