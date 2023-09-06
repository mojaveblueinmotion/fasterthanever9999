@extends('layouts.lists')

@section('filters')
    <div class="row">
        <div class="col-12 col-sm-6 col-xl-2 px-1 pl-3">
            <input class="form-control filter-control" data-post="name" placeholder="{{ __('Name / Email') }}">
        </div>
        {{-- <div class="col-12 col-sm-6 col-xl-2 pb-2">
			<input type="text" class="form-control filter-control" data-post="name" placeholder="{{ __('Name') }}">
		</div>
		<div class="col-12 col-sm-6 col-xl-2 pb-2">
			<input type="text" class="form-control filter-control" data-post="email" placeholder="{{ __('Email') }}">
		</div> --}}
        {{-- <div class="col-12 col-sm-6 col-xl-2 pb-2">
			<select class="form-control base-plugin--select2-ajax filter-control"
				data-post="position_id"
				data-url="{{ route('ajax.selectPosition', 'all') }}"
				data-placeholder="{{ __('Jabatan') }}">
				<option value="" selected>{{ __('Jabatan') }}</option>
			</select>
		</div> --}}
        <div class="col-12 col-sm-6 col-xl-3 px-1">
            <select class="form-control filter-control base-plugin--select2-ajax"
                data-url="{{ route('ajax.select-struct', 'parent_position') }}" data-post="location_id"
                data-placeholder="{{ __('Unit Kerja') }}">
            </select>
        </div>
        <div class="col-12 col-sm-6 col-xl-3 px-1">
            <select class="form-control base-plugin--select2-ajax filter-control" data-post="role_id"
                data-url="{{ route('ajax.select-role', 'all') }}" data-placeholder="{{ __('Role') }}">
                <option value="" selected>{{ __('Role') }}</option>
            </select>
        </div>
        <div class="col-12 col-sm-6 col-xl-2 px-1">
            <select class="form-control base-plugin--select2-ajax filter-control" data-post="status"
                data-placeholder="{{ __('Status') }}">
                <option value="" selected>{{ __('Status') }}</option>
                <option value="active">Active</option>
                <option value="nonactive">Nonactive</option>
            </select>
        </div>
    </div>
@endsection

@section('buttons-top-right')
    @if (auth()->user()->checkPerms($perms . '.create'))
        @include('layouts.forms.btnAdd', ['modal_size' => 'modal-lg'])
    @endif
@endsection
