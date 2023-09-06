@extends('layouts.modal')

@section('action', route($routes . '.update', $record->id))

@section('modal-body')
    @method('PATCH')
    <div class="form-group row">
        <label class="col-4 col-form-label">{{ __('Nama') }}</label>
        <div class="col-8 parent-group">
            <input type="text" name="name" value="{{ $record->name }}" class="form-control"
                placeholder="{{ __('Nama') }}" disabled>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-4 col-form-label">{{ __('Email') }}</label>
        <div class="col-8 parent-group">
            <input type="text" name="email" value="{{ $record->email }}" class="form-control"
                placeholder="{{ __('Email') }}" disabled>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-4 col-form-label">{{ __('Website') }}</label>
        <div class="col-8 parent-group">
            <input type="text" name="website" value="{{ $record->website }}" class="form-control"
                placeholder="{{ __('Website') }}" disabled>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-4 col-form-label">{{ __('Telepon') }}</label>
        <div class="col-8 parent-group">
            <input type="text" name="phone" value="{{ $record->phone }}" class="form-control"
                placeholder="{{ __('Telepon') }}" disabled>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-4 col-form-label">{{ __('Alamat') }}</label>
        <div class="col-8 parent-group">
            <textarea type="text" name="address" class="form-control" placeholder="{{ __('Address') }}" disabled>{{ $record->address }}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-4 col-form-label">{{ __('Provinsi') }}</label>
        <div class="col-8 parent-group">
            <input name="province_id" value="{{ $record->city->province->name }}" class="form-control"
                placeholder="{{ __('Provinsi') }}" disabled>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-4 col-form-label">{{ __('Kota') }}</label>
        <div class="col-8 parent-group">
            <input name="city_id" value="{{ $record->city->name }}" class="form-control"
                placeholder="{{ __('Kota') }}" disabled>
        </div>
    </div>
@endsection

@section('modal-footer')
@endsection
