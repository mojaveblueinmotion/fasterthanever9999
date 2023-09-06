@extends('layouts.modal')

@section('action', route($routes . '.store'))

@section('modal-body')
    @method('POST')
    <div class="form-group row">
        <label class="col-4 col-form-label">{{ __('Nama') }}</label>
        <div class="col-8 parent-group">
            <input type="text" name="name" class="form-control" placeholder="{{ __('Nama') }}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-4 col-form-label">{{ __('Role') }}</label>
        <div class="col-8 parent-group">
            <select name="role_id" class="form-control base-plugin--select2-ajax"
                data-url="{{ route('ajax.select-role', ['search' => 'all', 'id_in' => [2, 3]]) }}"
                data-placeholder="{{ __('Pilih Salah Satu') }}" id="roleCtrl">
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-4 col-form-label">{{ __('Tipe Aset') }}</label>
        <div class="col-8 parent-group">
            <select class="form-control base-plugin--select2-ajax" data-url="{{ route('ajax.select-asset-type', 'all') }}"
                data-placeholder="{{ __('Pilih Salah Satu') }}" id="typeCtrl" multiple name="asset_type_ids[]">
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-4 col-form-label">{{ __('Member') }}</label>
        <div class="col-8 parent-group">
            <select name="member_ids[]" class="form-control base-plugin--select2-ajax"
                data-url="{{ route('ajax.select-user', 'all') }}" data-url-origin="{{ route('ajax.select-user', 'all') }}"
                data-placeholder="{{ __('Pilih Salah Satu') }}" disabled id="membersCtrl" multiple>
            </select>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).on('change', '#roleCtrl', function() {
            let role_id = $('#roleCtrl').val();
            console.log(46, role_id);
            if (role_id) {
                var membersCtrl = $('#membersCtrl');
                var urlOrigin = membersCtrl.data('url-origin');
                var urlParam = $.param({
                    role_id: role_id,
                });
                membersCtrl.data('url', decodeURIComponent(decodeURIComponent(urlOrigin + '?' + urlParam)));
                membersCtrl.val(null).prop('disabled', false);
                BasePlugin.initSelect2();
            }
        });
    </script>
@endpush
