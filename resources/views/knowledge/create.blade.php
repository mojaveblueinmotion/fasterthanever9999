@extends('layouts.page', ['container' => 'container'])

@section('action', route($routes . '.store'))

@section('card-body')
    @method('POST')
    <div class="row">
        <div class="col-6">
            <div class="form-group row">
                <label class="col-sm-12 col-form-label">{{ __('Judul') }}</label>
                <div class="col-sm-12 parent-group">
                    <input name="title" class="form-control" placeholder="{{ __('Judul') }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-form-label">{{ __('Tipe Aset') }}</label>
                <div class="col-sm-12 parent-group">
                    <select class="form-control base-plugin--select2-ajax"
                        data-url="{{ route('ajax.select-asset-type', 'all') }}"
                        data-placeholder="{{ __('Pilih Salah Satu') }}" id="assetTypeCtrl" name="asset_type_id">
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-form-label">{{ __('Aset') }}</label>
                <div class="col-sm-12 parent-group">
                    <select class="form-control base-plugin--select2-ajax"
                        data-url="{{ route('ajax.select-asset', 'all') }}"
                        data-url-origin="{{ route('ajax.select-asset', 'all') }}"
                        data-placeholder="{{ __('Pilih Salah Satu') }}" disabled id="assetCtrl" name="asset_id">
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-form-label">{{ __('Komponen Aset') }}</label>
                <div class="col-sm-12 parent-group">
                    <select class="form-control base-plugin--select2-ajax"
                        data-url="{{ route('ajax.select-asset-detail', 'all') }}"
                        data-url-origin="{{ route('ajax.select-asset-detail', 'all') }}"
                        data-placeholder="{{ __('Pilih Salah Satu') }}" disabled id="assetDetailCtrl" multiple
                        name="asset_detail_ids[]">
                    </select>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group row">
                <label class="col-sm-12 col-form-label">{{ __('Insiden Terkait') }}</label>
                <div class="col-sm-12 parent-group">
                    <select class="form-control base-plugin--select2-ajax"
                        data-url="{{ route('ajax.select-incident', 'all') }}"
                        data-url-origin="{{ route('ajax.select-incident', 'all') }}"
                        data-placeholder="{{ __('Pilih Salah Satu') }}" disabled id="incidentCtrl" multiple
                        name="incident_ids[]">
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-form-label">{{ __('Problem Terkait') }}</label>
                <div class="col-sm-12 parent-group">
                    <select class="form-control base-plugin--select2-ajax"
                        data-url="{{ route('ajax.select-problem', ['search' => 'all']) }}"
                        data-url-origin="{{ route('ajax.select-problem', ['search' => 'all']) }}"
                        data-placeholder="{{ __('Pilih Salah Satu') }}" disabled id="problemCtrl" multiple
                        name="problem_ids[]">
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-form-label">{{ __('Change Terkait') }}</label>
                <div class="col-sm-12 parent-group">
                    <select class="form-control base-plugin--select2-ajax"
                        data-url="{{ route('ajax.select-change', ['search' => 'all']) }}"
                        data-url-origin="{{ route('ajax.select-change', ['search' => 'all']) }}"
                        data-placeholder="{{ __('Pilih Salah Satu') }}" disabled id="changeCtrl" multiple
                        name="change_ids[]">
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-form-label">{{ __('Knowledge Terkait') }}</label>
                <div class="col-sm-12 parent-group">
                    <select class="form-control base-plugin--select2-ajax"
                        data-url="{{ route('ajax.select-knowledge', ['search' => 'all']) }}"
                        data-url-origin="{{ route('ajax.select-knowledge', ['search' => 'all']) }}"
                        data-placeholder="{{ __('Pilih Salah Satu') }}" disabled id="knowledgeCtrl" multiple
                        name="ref_ids[]">
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Uraian Knowledge') }}</label>
        <div class="col-sm-12 parent-group">
            <textarea name="text" class="form-control base-plugin--tinymce" placeholder="{{ __('Uraian Knowledge') }}"></textarea>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Lampiran :') }}</label>
        <div class="col-sm-12 parent-group">
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
        $('.content-page')
            .on('change', '#assetTypeCtrl', function() {
                let asset_type_id = $('#assetTypeCtrl').val();
                if (asset_type_id) {
                    var assetCtrl = $('#assetCtrl');
                    var urlOrigin = assetCtrl.data('url-origin');
                    var urlParam = $.param({
                        asset_type_id: asset_type_id,
                    });
                    assetCtrl.data('url', decodeURIComponent(decodeURIComponent(urlOrigin + '?' + urlParam)));
                    assetCtrl.val(null).prop('disabled', false);
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

                    var problemCtrl = $('#problemCtrl');
                    var urlOrigin = problemCtrl.data('url-origin');
                    var urlParam = $.param({
                        asset_id: asset_id,
                        status: 'closed',
                    });
                    problemCtrl.data('url', decodeURIComponent(decodeURIComponent(urlOrigin + '?' + urlParam)));
                    problemCtrl.val(null).prop('disabled', false);

                    var changeCtrl = $('#changeCtrl');
                    var urlOrigin = changeCtrl.data('url-origin');
                    var urlParam = $.param({
                        asset_id: asset_id,
                        status: 'closed',
                    });
                    changeCtrl.data('url', decodeURIComponent(decodeURIComponent(urlOrigin + '?' + urlParam)));
                    changeCtrl.val(null).prop('disabled', false);

                    var knowledgeCtrl = $('#knowledgeCtrl');
                    var urlOrigin = knowledgeCtrl.data('url-origin');
                    var urlParam = $.param({
                        asset_id: asset_id,
                        status: 'closed',
                    });
                    knowledgeCtrl.data('url', decodeURIComponent(decodeURIComponent(urlOrigin + '?' + urlParam)));
                    knowledgeCtrl.val(null).prop('disabled', false);

                    BasePlugin.initSelect2();
                }
            });
    </script>
@endpush
