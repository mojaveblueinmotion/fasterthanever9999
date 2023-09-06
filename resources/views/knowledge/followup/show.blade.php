@extends('layouts.page', ['container' => 'container'])
@php
    $route_name = '.unknown';
    if ($record->status == 'open') {
        $route_name = '.post-open';
    }
    if ($record->status == 'repair') {
        $route_name = '.post-repair';
    }
    if ($record->status == 'repaired') {
        $route_name = '.post-repaired';
    }
    $user = auth()->user();
@endphp

@if ($route_name != '.unknown')
    @section('action', route($routes . $route_name, $record->id))
@endif

@section('card-body')
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-bordered w-100">
                <tr>
                    <td style="font-weight: bold; width: 15%">Kode</td>
                    <td style="text-align: center; width: 1%;">:</td>
                    <td style="width: 34%">
                        {{ $record->code }}
                    </td>
                    <td style="font-weight: bold; width: 15%">Severity</td>
                    <td style="text-align: center; width: 1%;">:</td>
                    <td style="width: 34%">
                        {{ $record->severity->name ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold; width: 15%">Pelapor</td>
                    <td style="text-align: center; width: 1%;">:</td>
                    <td style="width: 34%">
                        {{ $record->creator->name }} ({{ $record->creator->position->name }})
                        <br> {{ $record->creator->position->location->name }}
                    </td>
                    <td style="font-weight: bold; width: 15%">Grup Helpdesk</td>
                    <td style="text-align: center; width: 1%;">:</td>
                    <td style="width: 34%">
                        {{ $record->helpdeskGroup->name }} <br>
                        @if (isset($record->helpdeskUser->position->name))
                            {{ $record->helpdeskUser->name }} ({{ $record->helpdeskUser->position->name }})
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold; width: 15%">Aset</td>
                    <td style="text-align: center; width: 1%;">:</td>
                    <td style="width: 34%">
                        {{ $record->asset->name }} <br>
                        {{ $record->asset->type->name }}
                    </td>
                    <td style="font-weight: bold; width: 15%">Grup Teknisi</td>
                    <td style="text-align: center; width: 1%;">:</td>
                    <td style="width: 34%">
                        {{ $record->technicianGroup->name ?? '' }} <br>
                        @if (isset($record->technicianUser->position->name))
                            {{ $record->technicianUser->name }} ({{ $record->technicianUser->position->name }})
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold; width: 15%">Priority</td>
                    <td style="text-align: center; width: 1%;">:</td>
                    <td style="width: 34%">
                        {{ $record->priority->name ?? '' }}
                    </td>
                    <td style="font-weight: bold; width: 15%">Status</td>
                    <td style="text-align: center; width: 1%;">:</td>
                    <td style="width: 34%">
                        {!! $record->labelStatus() !!} <br>
                        @if (isset($record->closedBy->position->name))
                            {{ $record->closedBy->name }} ({{ $record->closedBy->position->name }})
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold; width: 15%">Incidents</td>
                    <td style="text-align: center; width: 1%;">:</td>
                    <td style="width: 34%">
                        <ol class="mx-2 px-2">
                            @foreach ($record->incidents as $incident)
                                <li>
                                    <a href="{{ route('incident.show', $incident->id) }}">
                                        {{ $incident->code }}
                                        {!! $incident->labelStatus() !!}
                                    </a>
                                </li>
                            @endforeach
                        </ol>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold; width: 15%">Laporan</td>
                    <td style="text-align: center; width: 1%;">:</td>
                    <td colspan="4">
                        {!! $record->reporting_notes !!}
                        @forelse ($record->files($module)->where('flag', 'attachments')->get() as $file)
                            <div class="progress-container w-100" data-uid="{{ $file->id }}">
                                <div class="alert alert-custom alert-light fade show py-2 px-4 mb-0 mt-2 success-uploaded"
                                    role="alert">
                                    <div class="alert-icon">
                                        <i class="{{ $file->file_icon }}"></i>
                                    </div>
                                    <div class="alert-text text-left">
                                        {{-- <input type="hidden" name="attachments[files_ids][]" value="{{ $file->id }}"> --}}
                                        <div>Lampiran :</div>
                                        <a href="{{ $file->file_url }}" target="_blank" class="text-primary">
                                            {{ $file->file_name }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            {{-- <div class="col-form-label">{{ __('Tidak ada Lampiran :') }}</div> --}}
                        @endforelse
                    </td>
                </tr>
                @if (in_array($record->status, ['repair', 'repaired', 'closed']))
                    <tr>
                        <td style="font-weight: bold; width: 15%">Helpdesk</td>
                        <td style="text-align: center; width: 1%;">:</td>
                        <td colspan="4">
                            {{ $record->helpdeskUser->name }} ({{ $record->helpdeskUser->position->name }})
                            <br>
                            {!! $record->helpdesk_to_technician_notes !!}
                            @forelse ($record->files($module)->where('flag', 'helpdesk-to-technician')->get() as $file)
                                <div class="progress-container w-100" data-uid="{{ $file->id }}">
                                    <div class="alert alert-custom alert-light fade show py-2 px-4 mb-0 mt-2 success-uploaded"
                                        role="alert">
                                        <div class="alert-icon">
                                            <i class="{{ $file->file_icon }}"></i>
                                        </div>
                                        <div class="alert-text text-left">
                                            {{-- <input type="hidden" name="attachments[files_ids][]" value="{{ $file->id }}"> --}}
                                            <div>Lampiran :</div>
                                            <a href="{{ $file->file_url }}" target="_blank" class="text-primary">
                                                {{ $file->file_name }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                {{-- <div class="col-form-label">{{ __('Tidak ada Lampiran :') }}</div> --}}
                            @endforelse
                        </td>
                    </tr>
                @endif
                @if (in_array($record->status, ['repaired', 'closed']))
                    <tr>
                        <td style="font-weight: bold; width: 15%">Teknisi</td>
                        <td style="text-align: center; width: 1%;">:</td>
                        <td colspan="4">
                            {{ $record->technicianUser->name }} ({{ $record->technicianUser->position->name }})
                            <br>
                            {!! $record->technician_identification_notes !!}
                            @forelse ($record->files($module)->where('flag', 'technician-to-helpdesk')->get() as $file)
                                <div class="progress-container w-100" data-uid="{{ $file->id }}">
                                    <div class="alert alert-custom alert-light fade show py-2 px-4 mb-0 mt-2 success-uploaded"
                                        role="alert">
                                        <div class="alert-icon">
                                            <i class="{{ $file->file_icon }}"></i>
                                        </div>
                                        <div class="alert-text text-left">
                                            {{-- <input type="hidden" name="attachments[files_ids][]" value="{{ $file->id }}"> --}}
                                            <div>Lampiran :</div>
                                            <a href="{{ $file->file_url }}" target="_blank" class="text-primary">
                                                {{ $file->file_name }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                {{-- <div class="col-form-label">{{ __('Tidak ada Lampiran :') }}</div> --}}
                            @endforelse
                        </td>
                    </tr>
                @endif
                @if (in_array($record->status, ['closed']))
                    <tr>
                        <td style="font-weight: bold; width: 15%">Helpdesk</td>
                        <td style="text-align: center; width: 1%;">:</td>
                        <td colspan="4">
                            {{ $record->closedBy->name }} ({{ $record->closedBy->position->name }})
                            <br>
                            {!! $record->conclusion_notes !!}
                            @forelse ($record->files($module)->where('flag', 'conclusion')->get() as $file)
                                <div class="progress-container w-100" data-uid="{{ $file->id }}">
                                    <div class="alert alert-custom alert-light fade show py-2 px-4 mb-0 mt-2 success-uploaded"
                                        role="alert">
                                        <div class="alert-icon">
                                            <i class="{{ $file->file_icon }}"></i>
                                        </div>
                                        <div class="alert-text text-left">
                                            {{-- <input type="hidden" name="attachments[files_ids][]" value="{{ $file->id }}"> --}}
                                            <div>Lampiran :</div>
                                            <a href="{{ $file->file_url }}" target="_blank" class="text-primary">
                                                {{ $file->file_name }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                {{-- <div class="col-form-label">{{ __('Tidak ada Lampiran :') }}</div> --}}
                            @endforelse
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
    @if ($record->status == 'open' && $record->helpdeskGroup->checkMembership($user->id))
        <div class="row">
            <div class="col-12">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{ __('Priority') }}</label>
                    <div class="col-sm-10 parent-group">
                        <select class="form-control base-plugin--select2-ajax"
                            data-url="{{ route('ajax.select-priority', 'all') }}"
                            data-placeholder="{{ __('Pilih Salah Satu') }}" id="priorityCtrl" name="priority_id">
                            @if (isset($record->priority->name))
                                <option value="{{ $record->priority_id }}" selected>{{ $record->priority->name }}</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{ __('Severity') }}</label>
                    <div class="col-sm-10 parent-group">
                        <select class="form-control base-plugin--select2-ajax"
                            data-url="{{ route('ajax.select-severity', 'all') }}"
                            data-placeholder="{{ __('Pilih Salah Satu') }}" id="severityCtrl" name="severity_id">
                            @if (isset($record->severity->name))
                                <option value="{{ $record->severity_id }}" selected>{{ $record->severity->name }}
                                </option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{ __('Keterangan') }}</label>
                    <div class="col-sm-10">
                        <textarea class="form-control base-plugin--tinymce" name="notes">{!! $record->conclusion_notes ?? $record->helpdesk_to_technician_notes !!}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{ __('Lampiran :') }}</label>
                    <div class="col-sm-4 parent-group">
                        <div class="custom-file">
                            <input type="hidden" name="attachments[uploaded]" class="uploaded" value="0">
                            <input type="file" multiple class="custom-file-input base-form--save-temp-files"
                                data-name="attachments" data-container="parent-group" data-max-size="20480"
                                data-max-file="10" accept="*">
                            <label class="custom-file-label" for="file">Choose File</label>
                        </div>
                        <div class="form-text text-muted">*Maksimal 20MB</div>
                        @foreach ($record->files($module)->whereIn('flag', ['post-open'])->get() as $file)
                            <div class="progress-container w-100" data-uid="{{ $file->id }}">
                                <div class="alert alert-custom alert-light fade show py-2 px-4 mb-0 mt-2 success-uploaded"
                                    role="alert">
                                    <div class="alert-icon">
                                        <i class="{{ $file->file_icon }}"></i>
                                    </div>
                                    <div class="alert-text text-left">
                                        <input type="hidden" name="attachments[files_ids][]"
                                            value="{{ $file->id }}">
                                        <div>Lampiran :</div>
                                        <a href="{{ $file->file_url }}" target="_blank" class="text-primary">
                                            {{ $file->file_name }}
                                        </a>
                                    </div>
                                    <div class="alert-close">
                                        <button type="button" class="close base-form--remove-temp-files"
                                            data-toggle="tooltip" data-original-title="Remove">
                                            <span aria-hidden="true">
                                                <i class="ki ki-close"></i>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{ __('Status') }}</label>
                    <div class="col-sm-4 parent-group col-form-label">
                        <div class="radio-inline">
                            <label class="radio radio-primary">
                                <input type="radio" name="action"
                                    {{ $record->temp_status == 'close' ? 'checked' : '' }} value="close">
                                <span></span>Close
                            </label>
                            <label class="radio radio-primary">
                                <input type="radio" name="action"
                                    {{ $record->temp_status == 'repair' ? 'checked' : '' }} value="repair">
                                <span></span>Teruskan ke Teknisi
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif ($record->status == 'repair' && $record->technicianGroup->checkMembership($user->id))
        <div class="row">
            <div class="col-12">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{ __('Keterangan') }}</label>
                    <div class="col-sm-10">
                        <textarea class="form-control base-plugin--tinymce" name="technician_identification_notes">{!! $record->technician_identification_notes !!}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{ __('Lampiran :') }}</label>
                    <div class="col-sm-4 parent-group">
                        <div class="custom-file">
                            <input type="hidden" name="attachments[uploaded]" class="uploaded" value="0">
                            <input type="file" multiple class="custom-file-input base-form--save-temp-files"
                                data-name="attachments" data-container="parent-group" data-max-size="20480"
                                data-max-file="10" accept="*">
                            <label class="custom-file-label" for="file">Choose File</label>
                        </div>
                        <div class="form-text text-muted">*Maksimal 20MB</div>
                        @foreach ($record->files($module)->whereIn('flag', [/* 'post-repair', */ 'technician-to-helpdesk'])->get() as $file)
                            <div class="progress-container w-100" data-uid="{{ $file->id }}">
                                <div class="alert alert-custom alert-light fade show py-2 px-4 mb-0 mt-2 success-uploaded"
                                    role="alert">
                                    <div class="alert-icon">
                                        <i class="{{ $file->file_icon }}"></i>
                                    </div>
                                    <div class="alert-text text-left">
                                        <input type="hidden" name="attachments[files_ids][]"
                                            value="{{ $file->id }}">
                                        <div>Lampiran :</div>
                                        <a href="{{ $file->file_url }}" target="_blank" class="text-primary">
                                            {{ $file->file_name }}
                                        </a>
                                    </div>
                                    <div class="alert-close">
                                        <button type="button" class="close base-form--remove-temp-files"
                                            data-toggle="tooltip" data-original-title="Remove">
                                            <span aria-hidden="true">
                                                <i class="ki ki-close"></i>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @elseif ($record->status == 'repaired' && $record->helpdeskGroup->checkMembership($user->id))
        <div class="row">
            <div class="col-12">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{ __('Kesimpulan') }}</label>
                    <div class="col-sm-10">
                        <textarea class="form-control base-plugin--tinymce" name="notes">{!! $record->conclusion_notes !!}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{ __('Lampiran :') }}</label>
                    <div class="col-sm-4 parent-group">
                        <div class="custom-file">
                            <input type="hidden" name="attachments[uploaded]" class="uploaded" value="0">
                            <input type="file" multiple class="custom-file-input base-form--save-temp-files"
                                data-name="attachments" data-container="parent-group" data-max-size="20480"
                                data-max-file="10" accept="*">
                            <label class="custom-file-label" for="file">Choose File</label>
                        </div>
                        <div class="form-text text-muted">*Maksimal 20MB</div>
                        @php
                            $attachments = $record
                                ->files($module)
                                ->whereIn('flag', ['conclusion'])
                                ->get();
                        @endphp
                        @foreach ($attachments as $file)
                            <div class="progress-container w-100" data-uid="{{ $file->id }}">
                                <div class="alert alert-custom alert-light fade show py-2 px-4 mb-0 mt-2 success-uploaded"
                                    role="alert">
                                    <div class="alert-icon">
                                        <i class="{{ $file->file_icon }}"></i>
                                    </div>
                                    <div class="alert-text text-left">
                                        <input type="hidden" name="attachments[files_ids][]"
                                            value="{{ $file->id }}">
                                        <div>Lampiran :</div>
                                        <a href="{{ $file->file_url }}" target="_blank" class="text-primary">
                                            {{ $file->file_name }}
                                        </a>
                                    </div>
                                    <div class="alert-close">
                                        <button type="button" class="close base-form--remove-temp-files"
                                            data-toggle="tooltip" data-original-title="Remove">
                                            <span aria-hidden="true">
                                                <i class="ki ki-close"></i>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@if (
    (in_array($record->status, ['open', 'repaired']) && $record->helpdeskGroup->checkMembership($user->id)) ||
        ($record->status == 'repair' && $record->technicianGroup->checkMembership($user->id)))
    @section('card-footer')
        <div class="card-footer">
            <div class="d-flex justify-content-between">
                @include('layouts.forms.btnBack')
                @include('layouts.forms.btnDropdownSubmit')
            </div>
        </div>
    @endsection
@else
@endif

@push('scripts')
@endpush
