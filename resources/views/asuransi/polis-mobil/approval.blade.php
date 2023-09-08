@extends('layouts.page', ['container' => 'container'])

@section('content-body')
@method('POST')
<div class="container-fluid">
    <div class="card card-custom">
        <div class="card-header">
            <h3 class="card-title">Purchase Order</h3>
            <div class="card-toolbar">
                @section('card-toolbar')
                @include('layouts.forms.btnBackTop')
                @show
            </div>
        </div>
        <div class="card-body">
            @include($views.'.includes.header')
        </div>
    </div>
</div>

<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">Daftar Aset</h3>
                    <div class="card-toolbar">
                    </div>
                </div>
                <div class="card-body">
                    @include($views.'.detail.detail-grid-laporan')
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-custom">
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">{{ __('Catatan') }}</label>
                        <div class="col-md-10 parent-group">
                            <textarea @if(request()->route()->getName() == $routes.'.approval') disabled @endif required name="catatan" class="form-control" placeholder="{{ __('Catatan') }}">{{ $record->catatan }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">{{ __('Lampiran') }}</label>
                        <div class="col-sm-10 parent-group">
                            <div class="custom-file">
                                <input type="hidden" name="attachments[uploaded]" class="uploaded" value="0">
                                <input @if(request()->route()->getName() == $routes.'.approval') disabled @endif type="file" multiple class="custom-file-input base-form--save-temp-files" data-name="attachments"
                                    data-container="parent-group" data-max-size="20024" data-max-file="100" accept="*">
                                <label class="custom-file-label" for="file">Choose File</label>
                            </div>
                            <div class="form-text text-muted">*Maksimal 20MB</div>
                            @foreach ($record->files($module)->where('flag', 'attachments')->get() as $file)
                            <div class="progress-container w-100" data-uid="{{ $file->id }}">
                                <div class="alert alert-custom alert-light fade show py-2 px-4 mb-0 mt-2 success-uploaded" role="alert">
                                    <div class="alert-icon">
                                        <i class="{{ $file->file_icon }}"></i>
                                    </div>
                                    <div class="alert-text text-left">
                                        <input type="hidden" name="attachments[files_ids][]" value="{{ $file->id }}">
                                        <div>Uploaded File:</div>
                                        <a href="{{ $file->file_url }}" target="_blank" class="text-primary">
                                            {{ $file->file_name }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card-footer">
        <div class="d-flex justify-content-between">
            @include('layouts.forms.btnBack')
            @include('layouts.forms.btnDropdownApproval')
            @include('layouts.forms.modalReject')
        </div>
    </div>
</div>
@endsection