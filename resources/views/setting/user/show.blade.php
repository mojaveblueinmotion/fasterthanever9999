{{-- {{ dd(json_decode($record->groups()->with('types')->get()->pluck('types')->flatten()->pluck('name')->unique())) }} --}}
@extends('layouts.modal')

@section('action', route($routes . '.update', $record->id))

@section('modal-body')
    @method('PATCH')
    <div class="form-group row">
        <label class="col-md-4 col-form-label">{{ __('Nama') }}</label>
        <div class="col-md-8 parent-group">
            <input type="text" value="{{ $record->name }}" class="form-control" disabled>
        </div>
    </div>
    {{-- <div class="form-group row">
		<label class="col-md-4 col-form-label">{{ __('Alamat') }}</label>
		<div class="col-md-8 parent-group">
			<input type="text" value="{{ $record->alamat }}" class="form-control" disabled>
		</div>
	</div> --}}
    <div class="form-group row">
        <label class="col-sm-4 col-form-label">{{ __('Email') }}</label>
        <div class="col-sm-8 parent-group">
            <input type="email" value="{{ $record->email }}" class="form-control" disabled>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 col-form-label">{{ __('Username') }}</label>
        <div class="col-sm-8 parent-group">
            <input type="text" value="{{ $record->username }}" class="form-control" disabled>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 col-form-label">{{ __('Tipe Struktur') }}</label>
        <div class="col-sm-8 parent-group">
            <input type="text" value="{{ $record->position->location->show_level ?? '' }}" class="form-control" disabled>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 col-form-label">{{ __('Struktur') }}</label>
        <div class="col-sm-8 parent-group">
            <input type="text" value="{{ $record->position->location->name ?? '' }}" class="form-control" disabled>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 col-form-label">{{ __('Jabatan') }}</label>
        <div class="col-sm-8 parent-group">
            <input type="text" value="{{ $record->position->name ?? '' }}" class="form-control" disabled>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 col-form-label">{{ __('Role') }}</label>
        <div class="col-sm-8 parent-group">
            <input type="text" value="{{ implode(', ',$record->roles()->pluck('name')->toArray()) }}"
                class="form-control" disabled>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 col-form-label">{{ __('Status') }}</label>
        <div class="col-sm-8 col-form-label">
            {!! $record->labelStatus() !!}
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4">{{ __('Grup') }}</label>
        <div class="col-sm-8 parent-group">
            @forelse ($record->groups()->pluck('name')->unique() as $item)
                {{ $loop->iteration }}. {{ $item }} <br>
            @empty
                <span class="italic text-muted">Tidak ada data</span>
            @endforelse
            {{-- <input type="text" value="{{ implode(', ', $record->groups()->pluck('name')->toArray()) }}" class="form-control" disabled> --}}
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4">{{ __('Keahlian') }}</label>
        <div class="col-sm-8 parent-group">
            @forelse ($record->groups()->with('types')->get()->pluck('types')->flatten()->pluck('name')->unique() as $item)
                {{ $loop->iteration }}. {{ $item }} <br>
            @empty
                <span class="italic text-muted">Tidak ada data</span>
            @endforelse
            {{-- <input type="text" value="{{ implode(', ', $record->groups()->with('types')->get()->pluck('types')->flatten()->pluck('name')->unique()->toArray()) }}" class="form-control" disabled> --}}
        </div>
    </div>
@endsection

@section('modal-footer')
@endsection
