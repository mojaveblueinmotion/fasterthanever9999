@extends('layouts.modal')

@section('action', route($routes . '.close', $record->id))

@section('modal-body')
    @method('POST')
    <input type="hidden" name="id" value="{{ $record->id }}">
    <div class="form-group row">
        <label class="col-2 col-form-label">{{ __('Tgl Penyelesaian') }}</label>
        <div class="col-4 parent-group">
            <input class="form-control base-plugin--datepicker" data-options='@json([
                'startDate' => '',
                'endDate' => now()->format('d/m/Y'),
            ])' name="closed_time"
                placeholder="{{ __('Tgl Penyelesaian') }}"
                value="{{ $record->closed_time ? $record->closed_time->format('d/m/Y') : null }}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-2 col-form-label">{{ __('Penyelesaian') }}</label>
        <div class="col-10">
            <textarea class="form-control base-plugin--tinymce" name="conclusion_notes">{!! $record->conclusion_notes !!}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-2 col-form-label">{{ __('Lampiran :') }}</label>
        <div class="col-sm-4 parent-group">
            <div class="custom-file">
                <input type="hidden" name="attachments[uploaded]" class="uploaded" value="0">
                <input type="file" multiple class="custom-file-input base-form--save-temp-files" data-name="attachments"
                    data-container="parent-group" data-max-size="20480" data-max-file="10" accept="*">
                <label class="custom-file-label" for="file">Choose File</label>
            </div>
            <div class="form-text text-muted">*Maksimal 20MB</div>
            @foreach ($record->files($module)->whereIn('flag', ['conclusion'])->get() as $file)
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

@section('modal-footer')
    @include('layouts.forms.btnSubmitModal')
@endsection
