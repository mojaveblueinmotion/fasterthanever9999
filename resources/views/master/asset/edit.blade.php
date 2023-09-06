@extends('layouts.modal')

@section('action', route($routes . '.update', $record->id))

@section('modal-body')
    @method('PATCH')
    <div class="form-group row">
        <label class="col-4 col-form-label">{{ __('Nama') }}</label>
        <div class="col-8 parent-group">
            <input name="name" class="form-control" placeholder="{{ __('Nama') }}" value="{{ $record->name }}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-4 col-form-label">{{ __('Tipe Aset') }}</label>
        <div class="col-8 parent-group">
            <select name="asset_type_id" class="form-control base-plugin--select2-ajax"
                data-url="{{ route('ajax.select-asset-type', 'all') }}" data-placeholder="{{ __('Pilih Salah Satu') }}">
                @if ($record->type)
                    <option value="{{ $record->type->id }}" selected>{{ $record->type->name }}</option>
                @endif
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-4 col-form-label">{{ __('Serial Number') }}</label>
        <div class="col-8 parent-group">
            <input name="serial_number" class="form-control" placeholder="{{ __('Serial Number') }}"
                value="{{ $record->serial_number }}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-4 col-form-label">{{ __('Merk') }}</label>
        <div class="col-8 parent-group">
            <input name="merk" class="form-control" placeholder="{{ __('Merk') }}" value="{{ $record->merk }}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-4 col-form-label">{{ __('Tgl Registrasi') }}</label>
        <div class="col-8 parent-group">
            <input class="form-control base-plugin--datepicker" data-options='@json([
                'startDate' => '',
                'endDate' => now()->format('d/m/Y'),
            ])'
                name="regist_date" placeholder="{{ __('Tgl Registrasi') }}"
                value="{{ $record->regist_date->format('d/m/Y') }}">
        </div>
    </div>
@endsection
