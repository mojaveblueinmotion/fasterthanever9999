@extends('layouts.modal')

@section('action', route($routes . '.update', $record->id))

@section('modal-body')
    @method('PATCH')
    <input type="hidden" name="id" value="{{ $record->id }}">
    <div class="form-group row">
        <label class="col-4 col-form-label">{{ __('Nama') }}</label>
        <div class="col-8 parent-group">
            <input type="text" name="name" value="{{ $record->name }}" class="form-control"
                placeholder="{{ __('Nama') }}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-4 col-form-label">{{ __('Role') }}</label>
        <div class="col-8 parent-group">
            <input type="hidden" name="role_id" value="{{ $record->role->id }}">
            <select name="role_id" class="form-control base-plugin--select2-ajax"
                data-url="{{ route('ajax.select-role', ['search' => 'all', 'id_in' => [2, 3]]) }}"
                data-placeholder="{{ __('Pilih Salah Satu') }}" id="roleCtrl" disabled>
                @if ($record->role)
                    <option value="{{ $record->role->id }}" selected>{{ $record->role->name }}</option>
                @endif
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-4 col-form-label">{{ __('Tipe Aset') }}</label>
        <div class="col-8 parent-group">
            {{-- @foreach ($record->types as $type)
                <input type="hidden" name="asset_type_ids[]" value="{{ $type->id }}">
            @endforeach --}}
            <select name="asset_type_ids[]" class="form-control base-plugin--select2-ajax"
                data-url="{{ route('ajax.select-asset-type', 'all') }}" data-placeholder="{{ __('Pilih Salah Satu') }}"
                id="typeCtrl" multiple>
                @foreach ($record->types as $type)
                    <option value="{{ $type->id }}" selected>{{ $type->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-4 col-form-label">{{ __('Member') }}</label>
        <div class="col-8 parent-group">
            <select name="member_ids[]" class="form-control base-plugin--select2-ajax"
                data-url="{{ route('ajax.select-user', ['search' => 'all', 'role_id' => $record->role->id]) }}"
                data-url-origin="{{ route('ajax.select-user', 'all') }}" data-placeholder="{{ __('Pilih Salah Satu') }}"
                id="membersCtrl" multiple>
                @foreach ($record->members as $member)
                    <option value="{{ $member->id }}" selected>{{ $member->name }} ({{ $member->position->name }})
                    </option>
                @endforeach
            </select>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).on('change', '#roleCtrl', function() {
            console.log(29);
            let role_id = $('#roleCtrl').val();
            let type_id = $('#typeCtrl').val();
            if (role_id) {
                var membersCtrl = $('#membersCtrl');
                var urlOrigin = membersCtrl.data('url-origin');
                var urlParam = $.param({
                    role_id: role_id,
                    // type_id: type_id,
                });
                membersCtrl.data('url', decodeURIComponent(decodeURIComponent(urlOrigin + '?' +
                    urlParam)));
                membersCtrl
                    .val(null)
                    .prop('disabled', false);
                BasePlugin.initSelect2();
            }
        });
    </script>
@endpush
