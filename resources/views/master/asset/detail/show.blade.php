@extends('layouts.modal')

@section('modal-body')
    <div class="form-group row">
        <label class="col-2 col-form-label">{{ __('Nama') }}</label>
        <div class="col-10 parent-group">
            <input class="form-control" disabled name="name" value="{{ $detail->name }}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-2 col-form-label">{{ __('Keterangan') }}</label>
        <div class="col-10 parent-group">
            <textarea class="form-control " disabled id="descriptionCtrl" name="description"
                placeholder="{{ __('Keterangan') }}" readonly>{!! $detail->description !!}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-2 col-form-label">{{ __('Lampiran :') }}</label>
        <div class="col-10 parent-group">
            @foreach ($detail->files($module.'.detail')->where('flag', 'attachments')->get() as $file)
                <div class="progress-container w-100" data-uid="{{ $file->id }}">
                    <div class="alert alert-custom alert-light fade show py-2 px-4 mb-0 mt-2 success-uploaded"
                        role="alert">
                        <div class="alert-icon">
                            <i class="{{ $file->file_icon }}"></i>
                        </div>
                        <div class="alert-text text-left">
                            <input type="hidden" name="attachments[files_ids][]" value="{{ $file->id }}">
                            <div>Lampiran :</div>
                            <a href="{{ $file->file_url }}" target="_blank" class="text-primary">
                                {{ $file->file_name }}
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('modal-footer')
@endsection
