@extends('layouts.modal')

@section('action', route($routes . '.detail.update', $detail->id))

@section('modal-body')
    @method('PATCH')
    <input type="hidden" name="id" value="{{ $detail->id }}">
    <input type="hidden" name="asset_id" value="{{ $detail->asset_id }}">
    <div class="form-group row">
        <label class="col-2 col-form-label">{{ __('Nama') }}</label>
        <div class="col-10 parent-group">
            <input class="form-control" name="name" placeholder="{{ __('Nama') }}" value="{{ $detail->name }}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-2 col-form-label">{{ __('Keterangan') }}</label>
        <div class="col-10 parent-group">
            <textarea class="form-control " id="descriptionCtrl" name="description"
                placeholder="{{ __('Keterangan') }}">{!! $detail->description !!}</textarea>
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
            @foreach ($detail->files($module.'.detail')->where('flag', 'attachments')->get() as $file)
                <div class="progress-container w-100" data-uid="{{ $file->id }}">
                    <div class="alert alert-custom alert-light fade show py-2 px-4 mb-0 mt-2 success-uploaded"
                        role="alert">
                        <div class="alert-icon">
                            <i class="{{ $file->file_icon }}"></i>
                        </div>
                        <div class="alert-text text-left">
                            <input type="hidden" name="attachments[files_ids][]" value="{{ $file->id }}">
                            <div>Lampiran :</div>
                            <a href="{{ $file->file_url }}" target="_blank" class="text-primary">
                                {{ $file->file_name }}
                            </a>
                        </div>
                        <div class="alert-close">
                            <button type="button" class="close base-form--remove-temp-files" data-toggle="tooltip"
                                data-original-title="Remove">
                                <span aria-hidden="true">
                                    <i class="ki ki-close"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('scripts')
    @include($views . '.includes.scripts')
@endpush
