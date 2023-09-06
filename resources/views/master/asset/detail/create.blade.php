@extends('layouts.modal')

@section('action', route($routes.'.detail.store', $record->id))

@section('modal-body')
	@method('POST')
	<input type="hidden" name="id" value="">
    <input type="hidden" name="asset_id" value="{{ $record->id }}">
	<div class="form-group row">
		<label class="col-2 col-form-label">{{ __('Nama') }}</label>
		<div class="col-10 parent-group">
			<input name="name" class="form-control" placeholder="{{ __('Nama') }}">
		</div>
	</div>
    <div class="form-group row">
        <label class="col-2 col-form-label">{{ __('Keterangan') }}</label>
        <div class="col-10 parent-group">
            <textarea class="form-control" id="descriptionCtrl" name="description"
                placeholder="{{ __('Keterangan') }}"></textarea>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-2 col-form-label">{{ __('Lampiran :') }}</label>
        <div class="col-10 parent-group">
            <div class="custom-file">
                <input type="hidden" name="attachments[uploaded]" class="uploaded" value="0">
                <input type="file" multiple class="custom-file-input base-form--save-temp-files" data-name="attachments"
                    data-container="parent-group" data-max-size="20024" data-max-file="10" accept="*">
                <label class="custom-file-label" for="file">Choose File</label>
            </div>
            <div class="form-text text-muted">*Maksimal 20MB</div>
        </div>
    </div>
@endsection

@push('scripts')
	@include($views.'.includes.scripts')
@endpush
