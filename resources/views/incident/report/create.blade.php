@extends('layouts.page', ['container' => 'container'])

@section('action', route($routes . '.store'))

@section('card-body')
    @method('POST')
    <div class="row">
        <div class="col-6">
            <div class="form-group row">
                <label class="col-4 col-form-label">{{ __('No Tiket') }}</label>
                <div class="col-8 parent-group">
                    <input class="form-control" disabled name="code" placeholder="Auto Generated">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-4 col-form-label">{{ __('Unit Kerja') }}</label>
                <div class="col-8 parent-group">
                    <select class="form-control base-plugin--select2-ajax"
                        data-url="{{ route('ajax.select-struct', 'all') }}" data-placeholder="{{ __('Pilih Unit Kerja') }}"
                        id="structCtrl" name="struct_id">
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-4 col-form-label">{{ __('Tipe Aset') }}</label>
                <div class="col-8 parent-group">
                    <select class="form-control base-plugin--select2-ajax"
                        data-url="{{ route('ajax.select-asset-type', 'all') }}"
                        data-placeholder="{{ __('Pilih Tipe Aset') }}" id="assetTypeCtrl" name="asset_type_id">
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-4 col-form-label">{{ __('Aset') }}</label>
                <div class="col-8 parent-group">
                    <select class="form-control base-plugin--select2-ajax"
                        data-url="{{ route('ajax.select-asset', 'all') }}"
                        data-url-origin="{{ route('ajax.select-asset', 'all') }}" data-placeholder="{{ __('Pilih Aset') }}"
                        disabled id="assetCtrl" name="asset_id">
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-4 col-form-label">{{ __('Komponen Aset') }}</label>
                <div class="col-8 parent-group">
                    <select class="form-control base-plugin--select2-ajax"
                        data-url="{{ route('ajax.select-asset-detail', 'all') }}"
                        data-url-origin="{{ route('ajax.select-asset-detail', 'all') }}"
                        data-placeholder="{{ __('Pilih Komponen Aset') }}" disabled id="assetDetailCtrl" multiple
                        name="asset_detail_ids[]">
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
                        name="date" placeholder="{{ __('Tanggal Insiden') }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-4 col-form-label">{{ __('Pelapor') }}</label>
                <div class="col-8 parent-group">
                    <select class="form-control base-plugin--select2-ajax"
                        data-url="{{ route('ajax.select-user', 'all') }}"
                        data-url-origin="{{ route('ajax.select-user', 'all') }}"
                        data-placeholder="{{ __('Pilih Pelapor') }}" disabled id="reporterCtrl" name="reporter_id">
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-4 col-form-label">{{ __('Insiden Terkait') }}</label>
                <div class="col-8 parent-group">
                    <select class="form-control base-plugin--select2-ajax"
                        data-url="{{ route('ajax.select-incident', ['search' => 'all']) }}"
                        data-url-origin="{{ route('ajax.select-incident', ['search' => 'all']) }}"
                        data-placeholder="{{ __('Pilih Insiden Terkait') }}" disabled id="incidentCtrl" multiple
                        name="ref_ids[]">
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-4 col-form-label">{{ __('Priority') }}</label>
                <div class="col-8 parent-group">
                    <select class="form-control base-plugin--select2-ajax"
                        data-url="{{ route('ajax.select-priority', 'all') }}"
                        data-placeholder="{{ __('Pilih Priority') }}" id="priorityCtrl" name="priority_id">
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-4 col-form-label">{{ __('Severity') }}</label>
                <div class="col-8 parent-group">
                    <select class="form-control base-plugin--select2-ajax"
                        data-url="{{ route('ajax.select-severity', 'all') }}"
                        data-placeholder="{{ __('Pilih Severity') }}" id="severityCtrl" name="severity_id">
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Laporan') }}</label>
        <div class="col-sm-12 parent-group">
            <textarea class="form-control base-plugin--tinymce" id="reportingNotesCtrl" name="reporting_notes"
                placeholder="{{ __('Laporan') }}"></textarea>
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
                    var reporterCtrl    = $('#reporterCtrl');
                    var urlOrigin       = reporterCtrl.data('url-origin');
                    var urlParam        = $.param({
                        struct_id: struct_id,
                    });
                    reporterCtrl.data('url', decodeURIComponent(decodeURIComponent(urlOrigin + '?' +urlParam)));
                    reporterCtrl
                        .val(null)
                        .prop('disabled', false);
                    BasePlugin.initSelect2();
                }
            })
            .on('change', '#assetTypeCtrl', function() {
                let asset_type_id = $('#assetTypeCtrl').val();
                console.log(80, asset_type_id);
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
                        status: 'closed',
                    });
                    incidentCtrl.data('url', decodeURIComponent(decodeURIComponent(urlOrigin + '?' + urlParam)));
                    incidentCtrl.val(null).prop('disabled', false);

                    BasePlugin.initSelect2();
                }
            });
    </script>
@endpush
