@extends('layouts.modal')

@section('modal-body')
<div class="form-group row">
    <label class="col-4 col-form-label">{{ __('Nama') }}</label>
    <div class="col-8 parent-group">
        <input class="form-control" disabled placeholder="{{ __('Nama') }}" value="{{ $record->name }}">
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label">{{ __('Tipe Aset') }}</label>
    <div class="col-8 parent-group">
        <input class="form-control" disabled value="{{ $record->type->name }}">
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label">{{ __('Serial Number') }}</label>
    <div class="col-8 parent-group">
        <input class="form-control" disabled placeholder="{{ __('Serial Number') }}"  value="{{ $record->serial_number }}">
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label">{{ __('Merk') }}</label>
    <div class="col-8 parent-group">
        <input class="form-control" disabled placeholder="{{ __('Merk') }}" value="{{ $record->merk }}">
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label">{{ __('Tgl Registrasi') }}</label>
    <div class="col-8 parent-group">
        <input class="form-control base-plugin--datepicker" disabled name="regist_date" placeholder="{{ __('Tgl Registrasi') }}"  value="{{ $record->regist_date->format('d/m/Y') }}">
    </div>
</div>
@endsection

@section('modal-footer')
@endsection
