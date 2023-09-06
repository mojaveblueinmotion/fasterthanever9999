@extends('layouts.modal')

@section('action', route($routes . '.store'))

@section('modal-body')
    @method('POST')
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Tipe Aset') }}</label>
        <div class="col-sm-12 parent-group">
            <select class="form-control base-plugin--select2-ajax" data-url="{{ route('ajax.select-asset-type', 'all') }}"
                data-placeholder="{{ __('Pilih Salah Satu') }}" id="assetTypeCtrl" name="asset_type_id">
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Aset') }}</label>
        <div class="col-sm-12 parent-group">
            <select class="form-control base-plugin--select2-ajax" data-url="{{ route('ajax.select-asset', 'all') }}"
                data-url-origin="{{ route('ajax.select-asset', 'all') }}" data-placeholder="{{ __('Pilih Salah Satu') }}"
                disabled id="assetCtrl" name="asset_id">
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Incidents') }}</label>
        <div class="col-sm-12 parent-group">
            <select class="form-control base-plugin--select2-ajax" data-url="{{ route('ajax.select-incident', 'all') }}"
                data-url-origin="{{ route('ajax.select-incident', 'all') }}" data-placeholder="{{ __('Pilih Salah Satu') }}"
                disabled id="incidentCtrl" multiple name="incident_ids[]">
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Problems') }}</label>
        <div class="col-sm-12 parent-group">
            <select class="form-control base-plugin--select2-ajax" data-url="{{ route('ajax.select-problem', 'all') }}"
                data-url-origin="{{ route('ajax.select-problem', 'all') }}" data-placeholder="{{ __('Pilih Salah Satu') }}"
                disabled id="problemCtrl" multiple name="problem_ids[]">
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Priority') }}</label>
        <div class="col-sm-12 parent-group">
            <select class="form-control base-plugin--select2-ajax" data-url="{{ route('ajax.select-priority', 'all') }}"
                data-placeholder="{{ __('Pilih Salah Satu') }}" id="priorityCtrl" name="priority_id">
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Severity') }}</label>
        <div class="col-sm-12 parent-group">
            <select class="form-control base-plugin--select2-ajax" data-url="{{ route('ajax.select-severity', 'all') }}"
                data-placeholder="{{ __('Pilih Salah Satu') }}" id="severityCtrl" name="severity_id">
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Laporan') }}</label>
        <div class="col-sm-12 parent-group">
            <textarea name="reporting_notes" class="form-control base-plugin--tinymce" placeholder="{{ __('Laporan') }}"></textarea>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group row">
            <label class="col-sm-12 col-form-label">{{ __('Lampiran :') }}</label>
            <div class="col-sm-12 parent-group">
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
    </div>
@endsection
@section('modal-footer')
    @include('layouts.forms.btnDropdownSubmit', ['submit_type' => 'modal'])
@endsection

@push('scripts')
    <script>
        $(document)
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
                    var incidentCtrl = $('#incidentCtrl');
                    var urlOrigin = incidentCtrl.data('url-origin');
                    var urlParam = $.param({
                        asset_id: asset_id,
                    });
                    incidentCtrl.data('url', decodeURIComponent(decodeURIComponent(urlOrigin + '?' +urlParam)));
                    incidentCtrl.val(null).prop('disabled', false);

                    var problemCtrl = $('#problemCtrl');
                    var urlOrigin = problemCtrl.data('url-origin');
                    var urlParam = $.param({
                        asset_id: asset_id,
                    });
                    problemCtrl.data('url', decodeURIComponent(decodeURIComponent(urlOrigin + '?' +urlParam)));
                    problemCtrl.val(null).prop('disabled', false);
                    BasePlugin.initSelect2();
                }
            });
    </script>
@endpush
