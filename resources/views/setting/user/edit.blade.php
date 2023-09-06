@extends('layouts.modal')

@section('action', route($routes . '.update', $record->id))

@section('modal-body')
    @method('PATCH')
    <div class="form-group row">
        <label class="col-md-4 col-form-label">{{ __('Nama') }}</label>
        <div class="col-md-8 parent-group">
            <input type="text" name="name" value="{{ $record->name }}" class="form-control"
                placeholder="{{ __('Nama') }}">
        </div>
    </div>
    {{-- <div class="form-group row">
        <label class="col-md-4 col-form-label">{{ __('Alamat') }}</label>
        <div class="col-md-8 parent-group">
            <input type="text" name="alamat" value="{{ $record->alamat }}" class="form-control"
                placeholder="{{ __('Alamat') }}">
        </div>
    </div> --}}
    <div class="form-group row">
        <label class="col-sm-4 col-form-label">{{ __('Email') }}</label>
        <div class="col-sm-8 parent-group">
            <input type="hidden" name="email" value="{{ $record->email }}">
            <input class="form-control" disabled value="{{ $record->email }}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-4 col-form-label">{{ __('Username') }}</label>
        <div class="col-md-8 parent-group">
            <input type="hidden" name="username" value="{{ $record->username }}">
            <input class="form-control" disabled value="{{ $record->username }}">
        </div>
    </div>
    @if ($record->id != 1)
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">{{ __('Tipe Struktur') }}</label>
            <div class="col-sm-8 parent-group">
                <select name="location_id" class="form-control base-plugin--select2" id="structTypeCtrl"
                    placeholder="{{ __('Pilih Tipe Struktur') }}">
                    <option disabled selected value="">{{ __('Pilih Tipe Struktur') }}</option>
                    <option @if ($record->position->location->level == 'bod') selected @endif value="bod">Direksi</option>
                    <option @if ($record->position->location->level == 'division') selected @endif value="division">Divisi</option>
                    <option @if ($record->position->location->level == 'department') selected @endif value="department">Departemen</option>
                    <option @if ($record->position->location->level == 'unit-bisnis') selected @endif value="unit-bisnis">Unit Bisnis</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">{{ __('Struktur') }}</label>
            <div class="col-sm-8 parent-group">
                <select name="location_id" class="form-control base-plugin--select2-ajax" id="structCtrl"
                    data-url="{{ route('ajax.select-struct', [
                        'level' => $record->position->location->level ?? '',
                        'search' => 'parent_position',
                        'has_positions' => 'has_positions',
                    ]) }}"
                    data-url-origin="{{ route('ajax.select-struct', 'all') }}" placeholder="{{ __('Pilih Salah Satu') }}">
                    <option value="">{{ __('Pilih Salah Satu') }}</option>
                    @if ($record->position)
                        <option value="{{ $record->position->location->id }}" selected>
                            {{ $record->position->location->name }}
                        </option>
                    @endif
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">{{ __('Jabatan') }}</label>
            <div class="col-sm-8 parent-group">
                @if ($record->id == 1)
                    <select id="jabatanCtrl" name="position_id" class="form-control base-plugin--select2-ajax"
                        data-url="{{ route('ajax.select-position', 'all') }}"
                        data-placeholder="{{ __('Pilih Salah Satu') }}" disabled>
                        <option value="">{{ __('Pilih Salah Satu') }}</option>
                        @if ($record->position)
                            <option value="{{ $record->position->id }}" selected>{{ $record->position->name }}</option>
                        @endif
                    </select>
                @else
                    <select id="positionCtrl" class="form-control base-plugin--select2-ajax"
                        data-url="{{ route('ajax.select-position', [
                            'search' => 'all',
                            'location_id' => $record->position->location_id,
                        ]) }}"
                        data-url-origin="{{ route('ajax.select-position', 'all') }}" name="position_id"
                        placeholder="{{ __('Pilih Salah Satu') }}">
                        @if ($record->position)
                            <option value="{{ $record->position->id }}" selected>{{ $record->position->name }}</option>
                        @endif
                    </select>
                @endif
            </div>
        </div>
    @endif
    @if ($record->id == 1)
        <input type="hidden" name="status" value="active">
    @else
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">{{ __('Role') }}</label>
            <div class="col-sm-8 parent-group">
                <select name="roles[]" class="form-control base-plugin--select2-ajax"
                    data-url="{{ route('ajax.select-role', 'all') }}" data-placeholder="{{ __('Pilih Salah Satu') }}">
                    <option value="">{{ __('Pilih Salah Satu') }}</option>
                    @foreach ($record->roles as $val)
                        <option value="{{ $val->id }}" selected>{{ $val->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">{{ __('Status') }}</label>
            <div class="col-sm-8 parent-group">
                <select name="status" class="form-control base-plugin--select2"
                    placeholder="{{ __('Pilih Salah Satu') }}">
                    <option value="active" {{ $record->status == 'nonactive' ? '' : 'selected' }}>Active</option>
                    <option value="nonactive" {{ $record->status == 'nonactive' ? 'selected' : '' }}>Non Active</option>
                </select>
            </div>
        </div>
    @endif
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
                    } else {}
                })
                .on('change', '#structCtrl', function() {
                    let location_id = $('#structCtrl').val();
                    console.log(46, location_id);
                    if (location_id) {
                        var positionCtrl = $('#positionCtrl');
                        var urlOrigin = positionCtrl.data('url-origin');
                        var urlParam = $.param({
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
