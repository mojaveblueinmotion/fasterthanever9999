{{-- {{ dd(json_decode($record)) }} --}}
@extends('layouts.page', ['container' => 'container'])

@section('action', route($routes . '.update', $record->id))

@section('card-body')
    @method('PATCH')
    <div class="row">
        <div class="col-6">
            <div class="form-group row">
                <label class="col-4 col-form-label">{{ __('Tgl Perbaikan') }}</label>
                <div class="col-8 parent-group">
                    <input class="form-control base-plugin--datepicker" data-options='@json([
                        'startDate' => '',
                        'endDate' => now()->format('d/m/Y'),
                    ])'
                        name="time" placeholder="{{ __('Tgl Perbaikan') }}"
                        value="{{ $record->time ? $record->time->format('d/m/Y') : null }}">
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Keterangan') }}</label>
        <div class="col-sm-12 parent-group">
            <textarea class="form-control base-plugin--tinymce" id="descriptionCtrl" name="description"
                placeholder="{{ __('Keterangan') }}">{!! $record->description !!}</textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="form-group row">
                <label class="col-4 col-form-label">{{ __('Lampiran') }}</label>
                <div class="col-8 parent-group">
                    <div class="custom-file">
                        <input type="hidden" name="attachments[uploaded]" class="uploaded" value="0">
                        <input type="file" multiple class="custom-file-input base-form--save-temp-files" data-name="attachments"
                            data-container="parent-group" data-max-size="20024" data-max-file="10" accept="*">
                        <label class="custom-file-label" for="file">Choose File</label>
                    </div>
                    <div class="form-text text-muted">*Maksimal 20MB</div>
                    @foreach ($record->problem->files($module)->where('flag', 'settlement')->get() as $file)
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
        </div>
        <div class="col-6">
            <div class="form-group row">
                <label class="col-4 col-form-label">{{ __('Pelaksana') }}</label>
                <div class="col-8 parent-group">
                    <select class="form-control base-plugin--select2-ajax"
                        data-url="{{ route('ajax.select-user', ['search' => 'technician', 'group_id' => $record->problem->identification->group_id]) }}"
                        data-placeholder="{{ __('Pilih Pelaksana') }}" id="userCtrl" name="user_id">
                        @if (isset($record->user->name))
                            <option value="{{ $record->user_id }}" selected>
                                {{ $record->user->name }} ({{ $record->user->position->name }})
                            </option>
                        @endif
                    </select>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('card-footer')
    <div class="card-footer">
        <div class="d-flex justify-content-between">
            @include('layouts.forms.btnBack')
            @include('layouts.forms.btnDropdownSubmit', ['submit_type' => 'page'])
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        BasePlugin.init();
    </script>
@endpush
