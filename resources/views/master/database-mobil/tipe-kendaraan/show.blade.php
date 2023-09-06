@extends('layouts.modal')

@section('modal-body')
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Tipe') }}</label>
		<div class="col-sm-8 parent-group">
			<input disabled type="text" value="{{ $record->type }}" name="type" class="form-control" placeholder="{{ __('Tipe') }}">
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
