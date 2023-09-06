@extends('layouts.modal')

@section('action', route($routes . '.store'))

@section('modal-body')
    @method('POST')
    <div class="form-group row">
        <label class="col-4 col-form-label">{{ __('Nama') }}</label>
        <div class="col-8 parent-group">
            <input name="name" class="form-control" placeholder="{{ __('Nama') }}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-4 col-form-label">{{ __('Tipe Aset') }}</label>
        <div class="col-8 parent-group">
            <select name="asset_type_id" class="form-control base-plugin--select2-ajax"
                data-url="{{ route('ajax.select-asset-type', 'all') }}" data-placeholder="{{ __('Pilih Salah Satu') }}">
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-4 col-form-label">{{ __('Serial Number') }}</label>
        <div class="col-8 parent-group">
            <input name="serial_number" class="form-control" placeholder="{{ __('Serial Number') }}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-4 col-form-label">{{ __('Merk') }}</label>
        <div class="col-8 parent-group">
            <input name="merk" class="form-control" placeholder="{{ __('Merk') }}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-4 col-form-label">{{ __('Tgl Registrasi') }}</label>
        <div class="col-8 parent-group">
            <input class="form-control base-plugin--datepicker" data-options='@json([
                'startDate' => '',
                'endDate' => now()->format('d/m/Y'),
            ])'
                name="regist_date" placeholder="{{ __('Tgl Registrasi') }}">
        </div>
    </div>
@endsection
