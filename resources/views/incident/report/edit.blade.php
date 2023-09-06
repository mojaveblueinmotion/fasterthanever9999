@extends('layouts.page', ['container' => 'container'])

@section('action', route($routes . '.update', $record->id))

@section('card-body')
    @method('PATCH')
    <div class="row">
        <div class="col-6">
            <div class="form-group row">
                <label class="col-4 col-form-label">{{ __('No Tiket') }}</label>
                <div class="col-8 parent-group">
                    <input class="form-control" disabled name="code" value="{{ $record->code }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-4 col-form-label">{{ __('Unit Kerja') }}</label>
                <div class="col-8 parent-group">
                    <select class="form-control base-plugin--select2-ajax"
                        data-url="{{ route('ajax.select-struct', 'all') }}" data-placeholder="{{ __('Pilih Unit Kerja') }}"
                        id="structCtrl" name="struct_id">
                        <option value="{{ $record->reporter->position->location_id }}">
                            {{ $record->reporter->position->location->name }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-4 col-form-label">{{ __('Tipe Aset') }}</label>
                <div class="col-8 parent-group">
                    <input type="hidden" name="asset_type_id" value="{{ $record->asset->asset_type_id }}">
                    <select class="form-control base-plugin--select2-ajax"
                        data-url="{{ route('ajax.select-asset-type', 'all') }}"
                        data-placeholder="{{ __('Pilih Tipe Aset') }}" disabled id="assetTypeCtrl" name="asset_type_id">
                        <option value="{{ $record->asset->asset_type_id }}" selected>{{ $record->asset->type->name }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-4 col-form-label">{{ __('Aset') }}</label>
                <div class="col-8 parent-group">
                    <input type="hidden" name="asset_id" value="{{ $record->asset_id }}">
                    <select class="form-control base-plugin--select2-ajax"
                        data-url="{{ route('ajax.select-asset', 'all') }}"
                        data-url-origin="{{ route('ajax.select-asset', 'all') }}"
                        data-placeholder="{{ __('Pilih Aset') }}" disabled id="assetCtrl" name="asset_id">
                        <option value="{{ $record->asset_id }}" selected>{{ $record->asset->name }}</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-4 col-form-label">{{ __('Komponen Aset') }}</label>
                <div class="col-8 parent-group">
                    <select class="form-control base-plugin--select2-ajax"
                        data-url="{{ route('ajax.select-asset-detail', [
                            'search' => 'all',
                            'asset_id' => $record->asset_id,
                        ]) }}"
                        data-url-origin="{{ route('ajax.select-asset-detail', 'all') }}"
                        data-placeholder="{{ __('Pilih Komponen Aset') }}" id="assetDetailCtrl" multiple
                        name="asset_detail_ids[]">
                        @foreach ($record->assetDetails as $asset_detail)
                            <option selected value="{{ $asset_detail->id }}">{{ $asset_detail->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group row">
                <label class="col-4 col-form-label">{{ __('Tanggal Insiden') }}</label>
                <div class="col-8 parent-group">
                    <input class="form-control base-plugin--datepicker" data-options='@json([
                        'startDate' => '',
                        'endDate' => now()->format('d/m/Y'),
                    ])'
                        name="date" placeholder="{{ __('Tanggal Insiden') }}"
                        value="{{ $record->date->format('d/m/Y') }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-4 col-form-label">{{ __('Pelapor') }}</label>
                <div class="col-8 parent-group">
                    <select class="form-control base-plugin--select2-ajax"
                        data-url="{{ route('ajax.select-user', 'all') }}"
                        data-url-origin="{{ route('ajax.select-user', 'all') }}"
                        data-placeholder="{{ __('Pilih Pelapor') }}" id="reporterCtrl" name="reporter_id">
                        <option selected value="{{ $record->reporter_id }}">
                            {{ $record->reporter->name }} ({{ $record->reporter->position->name }})
                        </option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-4 col-form-label">{{ __('Insiden Terkait') }}</label>
                <div class="col-8 parent-group">
                    <select class="form-control base-plugin--select2-ajax"
                        data-url="{{ route('ajax.select-incident', [
                            'search' => 'all',
                            'asset_id' => $record->asset_id,
                            'status' => 'closed',
                        ]) }}"
                        data-url-origin="{{ route('ajax.select-incident', ['search' => 'all', 'status' => 'closed']) }}"
                        data-placeholder="{{ __('Pilih Insiden Terkait') }}" id="incidentCtrl" multiple name="ref_ids[]">
                        @foreach ($record->refs as $incident)
                            <option selected value="{{ $incident->id }}">{{ $incident->code }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-4 col-form-label">{{ __('Priority') }}</label>
                <div class="col-8 parent-group">
                    <select class="form-control base-plugin--select2-ajax"
                        data-url="{{ route('ajax.select-priority', 'all') }}"
                        data-placeholder="{{ __('Pilih Priority') }}" id="priorityCtrl" name="priority_id">
                        <option value="{{ $record->priority_id }}" selected>{{ $record->priority->name }}</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-4 col-form-label">{{ __('Severity') }}</label>
                <div class="col-8 parent-group">
                    <select class="form-control base-plugin--select2-ajax"
                        data-url="{{ route('ajax.select-severity', 'all') }}"
                        data-placeholder="{{ __('Pilih Severity') }}" id="severityCtrl" name="severity_id">
                        <option value="{{ $record->severity_id }}" selected>{{ $record->severity->name }}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Laporan') }}</label>
        <div class="col-sm-12 parent-group">
            <textarea class="form-control base-plugin--tinymce" id="reportingNotesCtrl" name="reporting_notes"
                placeholder="{{ __('Laporan') }}">{!! $record->reporting_notes !!}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-2 col-form-label">{{ __('Lampiran') }}</label>
        <div class="col-4 parent-group">
            <div class="custom-file">
                <input type="hidden" name="attachments[uploaded]" class="uploaded" value="0">
                <input type="file" multiple class="custom-file-input base-form--save-temp-files"
                    data-name="attachments" data-container="parent-group" data-max-size="20024" data-max-file="10"
                    accept="*">
                <label class="custom-file-label" for="file">Choose File</label>
            </div>
            <div class="form-text text-muted">*Maksimal 20MB</div>
            @foreach ($record->files($module)->where('flag', 'attachments')->get() as $file)
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
