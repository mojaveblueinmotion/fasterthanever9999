@extends('layouts.lists')

@section('filters')
    <div class="row">
        <div class="col-12 col-sm-6 col-xl-3 pb-2">
            <input type="text" class="form-control filter-control" data-post="name" placeholder="{{ __('Nama') }}">
        </div>
        <div class="col-12 col-sm-6 col-xl-3 pb-2">
            <select class="filter-control form-control base-plugin--select2-ajax" data-url="{{ route('ajax.select-province', 'all') }}"
                data-placeholder="{{ __('Pilih Provinsi') }}"
                id="provinceCtrl" data-post="province_id">
            </select>
        </div>
    </div>
    </div>
@endsection

@section('buttons-top-right')
    @if (auth()->user()->checkPerms($perms . '.create'))
        {{-- @include('layouts.forms.btnAddImport') --}}
        {{-- @include('layouts.forms.btnAdd') --}}
    @endif
@endsection
