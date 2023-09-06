@extends('layouts.app')

@section('title', $title)

@section('content')
@section('content-header')
    @include('layouts.base.subheader')
@show
@section('content-body')
    <div class="d-flex flex-column-fluid">
        <div class="{{ $container ?? 'container-fluid' }}">
            @yield('page-start')
        @section('page')
            @if (isset($form_action))
                <form action="{{ $form_action }}" method="POST" autocomplete="@yield('autocomplete', 'off')"
                    onsubmit="event.preventDefault()">
                @else
                    <form action="@yield('action')" method="POST" autocomplete="@yield('autocomplete', 'off')"
                        onsubmit="event.preventDefault()">
            @endif
            @csrf
        @section('form-content')
            <div class="card card-custom">
            @section('card-header')
                <div class="card-header">
                    <h3 class="card-title">@yield('card-title', $title)</h3>
                    <div class="card-toolbar">
                    @section('card-toolbar')
                        @include('layouts.forms.btnBackTop')
                    @show
                </div>
            </div>
            <div class="card-body">
                @yield('card-body')
            </div>
        @show


        @section('card-footer')
            {{-- <div class="card-footer">
                                        @section('card-footer-content')
                                            <div class="d-flex justify-content-between">
                                                @include('layouts.forms.btnBack')
                                                @include('layouts.forms.btnSubmitPage')
                                            </div>
                                        @show
                                    </div> --}}
        @show
    </div>
@show
</form>
@show
@yield('page-end')
</div>
</div>
@show
@endsection
