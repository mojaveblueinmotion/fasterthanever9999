@extends('layouts.modal')

@section('action', route($routes . '.dispose', $record->id))

@section('modal-body')
    @method('POST')
    <input type="hidden" name="id" value="{{ $record->id }}">
    <div class="form-group row">
        <label class="col-4 col-form-label">{{ __('Grup Teknisi') }}</label>
        <div class="col-8 parent-group">
            <select class="form-control base-plugin--select2-ajax" data-url="{{ route('ajax.select-technician', 'all') }}"
                data-placeholder="{{ __('Pilih Grup Teknisi') }}" id="technicianGroupCtrl" name="group_id">
                @if (isset($record->identification->group->name))
                    <option value="{{ $record->identification->group_id }}" selected>
                        {{ $record->identification->group->name }}
                    </option>
                @endif
            </select>
        </div>
    </div>
@endsection

@section('modal-footer')
    @include('layouts.forms.btnSubmitModal')
@endsection
