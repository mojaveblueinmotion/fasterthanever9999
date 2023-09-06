@extends('layouts.modal')

@section('action', route($routes . '.store'))

@section('modal-body')
    @method('POST')
    <div class="form-group row">
        <label class="col-sm-4 col-form-label">{{ __('Nama') }}</label>
        <div class="col-sm-8 parent-group">
            <input type="text" name="name" class="form-control" placeholder="{{ __('Nama') }}">
        </div>
    </div>
    {{-- <div class="form-group row">
        <label class="col-sm-4 col-form-label">{{ __('Alamat') }}</label>
        <div class="col-sm-8 parent-group">
            <input type="text" name="alamat" class="form-control" placeholder="{{ __('Alamat') }}">
        </div>
    </div> --}}
    <div class="form-group row">
        <label class="col-sm-4 col-form-label">{{ __('Email') }}</label>
        <div class="col-sm-8 parent-group">
            <input type="email" name="email" class="form-control" placeholder="{{ __('Email') }}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 col-form-label">{{ __('Username') }}</label>
        <div class="col-sm-8 parent-group">
            <input type="text" name="username" class="form-control" placeholder="{{ __('Username') }}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 col-form-label">{{ __('Tipe Struktur') }}</label>
        <div class="col-sm-8 parent-group">
            <select name="location_id" class="form-control base-plugin--select2" id="structTypeCtrl"
                placeholder="{{ __('Pilih Tipe Struktur') }}">
                <option disabled selected value="">{{ __('Pilih Tipe Struktur') }}</option>
                <option value="bod">Direksi</option>
                <option value="division">Divisi</option>
                <option value="department">Departemen</option>
                <option value="unit-bisnis">Unit Bisnis</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 col-form-label">{{ __('Struktur') }}</label>
        <div class="col-sm-8 parent-group">
            <select class="form-control base-plugin--select2-ajax" disabled id="structCtrl"
                data-url-origin="{{ route('ajax.select-struct', 'all') }}" name="location_id"
                placeholder="{{ __('Pilih Struktur') }}">
                <option value="">{{ __('Pilih Struktur') }}</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 col-form-label">{{ __('Jabatan') }}</label>
        <div class="col-sm-8 parent-group">
            <select id="positionCtrl" class="form-control base-plugin--select2-ajax"
                data-url="{{ route('ajax.select-position', 'all') }}"
                data-url-origin="{{ route('ajax.select-position', 'all') }}" disabled name="position_id"
                placeholder="{{ __('Pilih Salah Satu') }}">
                <option value="">{{ __('Pilih Salah Satu') }}</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 col-form-label">{{ __('Role') }}</label>
        <div class="col-sm-8 parent-group">
            <select name="roles[]" class="form-control base-plugin--select2-ajax"
                data-url="{{ route('ajax.select-role', 'all') }}" placeholder="{{ __('Pilih Salah Satu') }}">
                <option value="">{{ __('Pilih Salah Satu') }}</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 col-form-label">{{ __('Password') }}</label>
        <div class="col-sm-8 parent-group">
            <input type="password" name="password" class="form-control" placeholder="{{ __('Password') }}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 col-form-label">{{ __('Konfirmasi Password') }}</label>
        <div class="col-sm-8 parent-group">
            <input type="password" name="password_confirmation" class="form-control"
                placeholder="{{ __('Konfirmasi Password') }}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 col-form-label">{{ __('Status') }}</label>
        <div class="col-sm-8 parent-group">
            <select name="status" class="form-control base-plugin--select2" placeholder="{{ __('Pilih Salah Satu') }}">
                <option value="active" selected>Active</option>
                <option value="nonactive">Non Active</option>
            </select>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('.content-page')
                .on('change', '#structTypeCtrl', function() {
                    let level = $('#structTypeCtrl').val();
                    let structCtrl = $('#structCtrl');
                    if (level) {
                        let urlOrigin = structCtrl.data('url-origin');
                        let urlParam = $.param({
                            level: level,
                            search: 'parent_position',
                            // has_positions: 'has_positions',
                        });
                        structCtrl.data('url', decodeURIComponent(decodeURIComponent(urlOrigin + '?' +
                            urlParam)));
                        structCtrl.val(null).prop('disabled', false);
                        $('#positionCtrl').val(null).prop('disabled', true);
                        BasePlugin.initSelect2();
                    } else {
                    }
                })
                .on('change', '#structCtrl', function() {
                    let location_id = $('#structCtrl').val();
                    console.log(46, location_id);
                    if (location_id) {
                        let positionCtrl = $('#positionCtrl');
                        let urlOrigin = positionCtrl.data('url-origin');
                        let urlParam = $.param({
                            location_id: location_id,
                        });
                        positionCtrl.data('url', decodeURIComponent(decodeURIComponent(urlOrigin + '?' +
                            urlParam)));
                        positionCtrl.val(null).prop('disabled', false);
                        BasePlugin.initSelect2();
                    }
                });
        });
    </script>
@endpush
