{{-- {{ dd(json_decode($record)) }} --}}
@extends('layouts.page', ['container' => 'container'])

@section('action', route($routes . '.update', $record->id))

@section('card-body')
    @method('PATCH')
    <div class="row">
        <div class="col-6">
            <div class="form-group row">
                <label class="col-4 col-form-label">{{ __('Tgl Identifikasi') }}</label>
                <div class="col-8 parent-group">
                    <input class="form-control base-plugin--datepicker" data-options='@json([
                        'startDate' => '',
                        'endDate' => now()->format('d/m/Y'),
                    ])'
                        name="date" placeholder="{{ __('Tgl Identifikasi') }}"
                        value="{{ $record->time ? $record->time->format('d/m/Y') : null }}">
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group row">
                <label class="col-4 col-form-label">{{ __('Jam Identifikasi') }}</label>
                <div class="col-8 parent-group">
                    <input class="form-control base-plugin--timepicker"
                        name="time" placeholder="{{ __('Jam Identifikasi') }}"
                        value="{{ $record->time ? $record->time->format('H:i') : '09:00' }}">
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Penyebab') }}</label>
        <div class="col-sm-12 parent-group">
            <textarea class="form-control base-plugin--tinymce" id="reasonCtrl" name="reason" placeholder="{{ __('Penyebab') }}">{!! $record->reason !!}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Kondisi') }}</label>
        <div class="col-sm-12 parent-group">
            <textarea class="form-control base-plugin--tinymce" id="conditionCtrl" name="condition"
                placeholder="{{ __('Kondisi') }}">{!! $record->condition !!}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Rekomendasi') }}</label>
        <div class="col-sm-12 parent-group">
            <textarea class="form-control base-plugin--tinymce" id="recommendationCtrl" name="recommendation"
                placeholder="{{ __('Rekomendasi') }}">{!! $record->recommendation !!}</textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="form-group row">
                <label class="col-4 col-form-label">{{ __('Tindak Lanjut') }}</label>
                <div class="col-8 parent-group">
                    <select class="form-control base-plugin--select2-ajax"
                        data-placeholder="{{ __('Pilih Tindak Lanjut') }}" name="follow_up">
                        <option value="">Pilih Tindak Lanjut</option>
                        <option @if($record->follow_up == 'withdrawal') selected @endif value="withdrawal">Penarikan</option>
                        <option @if($record->follow_up == 'repair') selected @endif value="repair">Perbaikan</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group row">
                <label class="col-4 col-form-label">{{ __('Pelaksana') }}</label>
                <div class="col-8 parent-group">
                    <select class="form-control base-plugin--select2-ajax"
                        data-url="{{ route('ajax.select-user', ['search' => 'technician', 'group_id' => $record->group_id]) }}"
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
    <div class="form-group row">
        <label class="col-2 col-form-label">{{ __('Lampiran') }}</label>
        <div class="col-4 parent-group">
            <div class="custom-file">
                <input type="hidden" name="attachments[uploaded]" class="uploaded" value="0">
                <input type="file" multiple class="custom-file-input base-form--save-temp-files" data-name="attachments"
                    data-container="parent-group" data-max-size="20024" data-max-file="10" accept="*">
                <label class="custom-file-label" for="file">Choose File</label>
            </div>
            <div class="form-text text-muted">*Maksimal 20MB</div>
            @foreach ($record->change->files($module)->where('flag', 'analysis')->get() as $file)
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
        $('.content-page')
            .on('change', '#structCtrl', function() {
                let struct_id = $('#structCtrl').val();
                console.log(80, struct_id);
                if (struct_id) {
                    var reporterCtrl = $('#reporterCtrl');
                    var urlOrigin = reporterCtrl.data('url-origin');
                    var urlParam = $.param({
                        struct_id: struct_id,
                    });
                    reporterCtrl.data('url', decodeURIComponent(decodeURIComponent(urlOrigin + '?' + urlParam)));
                    reporterCtrl
                        .val(null)
                        .prop('disabled', false);
                    BasePlugin.initSelect2();
                }
            })
            .on('change', '#assetTypeCtrl', function() {
                let asset_type_id = $('#assetTypeCtrl').val();
                if (asset_type_id) {
                    var assetCtrl = $('#assetCtrl');
                    var urlOrigin = assetCtrl.data('url-origin');
                    var urlParam = $.param({
                        asset_type_id: asset_type_id,
                    });
                    assetCtrl.data('url', decodeURIComponent(decodeURIComponent(urlOrigin + '?' +
                        urlParam)));
                    assetCtrl
                        .val(null)
                        .prop('disabled', false);
                    BasePlugin.initSelect2();
                }
            })
            .on('change', '#assetCtrl', function() {
                let asset_id = $('#assetCtrl').val();
                if (asset_id) {
                    var assetDetailCtrl = $('#assetDetailCtrl');
                    var urlOrigin = assetDetailCtrl.data('url-origin');
                    var urlParam = $.param({
                        asset_id: asset_id,
                    });
                    assetDetailCtrl.data('url', decodeURIComponent(decodeURIComponent(urlOrigin + '?' + urlParam)));
                    assetDetailCtrl.val(null).prop('disabled', false);

                    var incidentCtrl = $('#incidentCtrl');
                    var urlOrigin = incidentCtrl.data('url-origin');
                    var urlParam = $.param({
                        asset_id: asset_id,
                    });
                    incidentCtrl.data('url', decodeURIComponent(decodeURIComponent(urlOrigin + '?' + urlParam)));
                    incidentCtrl.val(null).prop('disabled', false);
                    BasePlugin.initSelect2();
                }
            });
    </script>
@endpush
