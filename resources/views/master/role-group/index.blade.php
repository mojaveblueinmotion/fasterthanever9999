@extends('layouts.lists')

@section('filters')
    <div class="row">
        <div class="col-12 col-sm-6 col-xl-2 px-1 pl-3">
            <input class="form-control filter-control" data-post="name" placeholder="{{ __('Nama') }}">
        </div>
        <div class="col-12 col-sm-6 col-xl-3 px-1">
            <select class="filter-control form-control base-plugin--select2-ajax"
                data-url="{{ route('ajax.select-role', ['search' => 'all', 'id_in' => [2, 3]]) }}"
                data-placeholder="{{ __('Role') }}" data-post="role_id" id="roleFltrCtrl">
            </select>
        </div>
        <div class="col-12 col-sm-6 col-xl-3 px-1">
            <select class="form-control filter-control base-plugin--select2-ajax"
                data-url="{{ route('ajax.select-asset-type', 'all') }}" data-post="asset_type_id"
                data-placeholder="{{ __('Tipe Aset') }}">
            </select>
        </div>
    </div>
@endsection

@section('buttons-top-right')
    @if (auth()->user()->checkPerms($perms . '.create'))
        {{-- @include('layouts.forms.btnAddImport') --}}
        @include('layouts.forms.btnAdd')
    @endif
@endsection
