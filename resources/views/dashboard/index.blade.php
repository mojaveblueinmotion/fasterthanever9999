{{-- {{ dd(session('remember_username')) }} --}}
@extends('layouts.page')

@section('page')
    <div class="row">
        {{-- @include($views . '._card-progress') --}}
    </div>
    <div class="row">
        {{-- @include($views . '._chart-insiden-tahunan')
        @include($views . '._chart-problem-tahunan') --}}
    </div>
    <div class="row">
        {{-- @include($views . '._chart-insiden-per-aset')
        @include($views . '._chart-problem-per-aset') --}}
    </div>
@endsection
