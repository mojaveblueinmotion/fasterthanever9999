@extends('layouts.modal')

@section('modal-body')
    <div class="form-group row">
        <label class="col-4 col-form-label">{{ __('Nama') }}</label>
        <div class="col-8 parent-group">
            <input class="form-control" disabled value="{{ $record->name }}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-4 col-form-label">{{ __('Role') }}</label>
        <div class="col-8 parent-group">
            <select class="form-control base-plugin--select2-ajax"
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
            <select class="form-control base-plugin--select2-ajax" data-url="{{ route('ajax.select-asset-type', 'all') }}"
                data-placeholder="{{ __('Pilih Salah Satu') }}" id="typeCtrl" disabled multiple>
                @foreach ($record->types as $type)
                    <option value="{{ $type->id }}" selected>{{ $type->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-4 col-form-label">{{ __('Member') }}</label>
        <div class="col-8 parent-group">
            <select class="form-control base-plugin--select2-ajax"
                data-url="{{ route('ajax.select-user', ['search' => 'all', 'role_id' => $record->role->id]) }}"
                data-url-origin="{{ route('ajax.select-user', 'all') }}" data-placeholder="{{ __('Pilih Salah Satu') }}"
                disabled id="membersCtrl" multiple>
                @foreach ($record->members as $member)
                    <option value="{{ $member->id }}" selected>{{ $member->name }} ({{ $member->position->name }})
                    </option>
                @endforeach
            </select>
        </div>
    </div>
@endsection

@section('modal-footer')
@endsection
