@extends('layouts.modal')

@section('modal-body')
	<div class="form-group row">
		<label class="col-4 col-form-label">{{ __('Parent') }}</label>
		<div class="col-8 parent-group">
			<input type="text" value="{{ $record->parent->name ?? '' }}" class="form-control" placeholder="{{ __('Parent') }}"  disabled>
			<div class="form-text text-muted">*Parent berupa Direksi</div>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Nama') }}</label>
		<div class="col-sm-8 parent-group">
			<input type="text" value="{{ $record->name }}" class="form-control" placeholder="{{ __('Nama') }}" disabled>
		</div>
	</div>
@endsection

@section('modal-footer')
@endsection
