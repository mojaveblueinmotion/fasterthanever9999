@php
    $user = auth()->user();
    $form_action = '';
    if (isset($record) && in_array($record->status, ['approval.waiting']) && $record->checkAction('approval', $perms)) {
        $form_action = route($routes . '.reject', $record->id);
    } elseif (isset($record->identification) && in_array($record->identification->status, ['approval.waiting']) && $record->identification->checkAction('approval', $perms)) {
        $form_action = route($routes . '.reject', $record->identification->id);
    } elseif (isset($record->withdrawal) && in_array($record->withdrawal->status, ['approval.waiting']) && $record->withdrawal->checkAction('approval', $perms)) {
        $form_action = route($routes . '.reject', $record->withdrawal->id);
    } elseif (isset($record->repair) && in_array($record->repair->status, ['approval.waiting']) && $record->repair->checkAction('approval', $perms)) {
        $form_action = route($routes . '.reject', $record->repair->id);
    }
@endphp

@extends('layouts.page', [
    'container' => 'container',
    'form_action' => $form_action,
])

@section('form-content')
    <div class="card card-custom">
        <div class="card-header">
            <h3 class="card-title">@yield('card-title', 'Pengaduan')</h3>
            <div class="card-toolbar">
                @section('card-toolbar')@include('layouts.forms.btnBackTop') @show
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    @include('globals.notes')
                </div>
                <div class="col-12">
                    <table class="table table-bordered w-100">
                        <tr>
                            <td style="font-weight: bold; width: 15%">No Tiket</td>
                            <td style="text-align: center; width: 1%;">:</td>
                            <td style="width: 34%">
                                {{ $record->code }}
                                {!! $record->labelStatus() !!} <br>
                            </td>
                            <td style="font-weight: bold; width: 15%">Tanggal Insiden</td>
                            <td style="text-align: center; width: 1%;">:</td>
                            <td style="width: 34%">
                                {{ $record->date->format('d/m/Y') }}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; width: 15%">Pelapor</td>
                            <td style="text-align: center; width: 1%;">:</td>
                            <td style="width: 34%">
                                {{ $record->reporter->name }} ({{ $record->reporter->position->name }})
                                <br> {{ $record->reporter->position->location->name }}
                            </td>
                            <td style="font-weight: bold; width: 15%">Priority</td>
                            <td style="text-align: center; width: 1%;">:</td>
                            <td style="width: 34%">
                                {{ $record->priority->name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; width: 15%">Aset</td>
                            <td style="text-align: center; width: 1%;">:</td>
                            <td style="width: 34%">
                                {{-- <a href="{{ route('master.asset.detail', $record->asset_id) }}"> --}}
                                {{ $record->asset->name }}
                                {{-- </a> --}}
                                <br>
                                <b>Tipe: </b>{{ $record->asset->type->name }}
                            </td>
                            <td style="font-weight: bold; width: 15%">Severity</td>
                            <td style="text-align: center; width: 1%;">:</td>
                            <td style="width: 34%">
                                {{ $record->severity->name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; width: 15%">Komponen Aset</td>
                            <td style="text-align: center; width: 1%;">:</td>
                            <td style="width: 34%">
                                <ol class="mx-2 px-2">
                                    @foreach ($record->assetDetails as $asset_detail)
                                        <li>
                                            {{-- <a class="base-modal--render" data-modal-size="modal-xl" href="{{ route('master.asset.detail.show', $asset_detail->id) }}"> --}}
                                            {{ $asset_detail->name }}
                                            {{-- </a> --}}
                                        </li>
                                    @endforeach
                                </ol>
                            </td>
                            <td style="font-weight: bold; width: 15%">Helpdesk</td>
                            <td style="text-align: center; width: 1%;">:</td>
                            <td style="width: 34%">
                                @if (isset($record->helpdesk->group->name))
                                    {{-- <a class="base-modal--render" href="{{ route('master.role-group.show', $record->helpdesk->group_id) }}"> --}}
                                    {{ $record->helpdesk->group->name }}
                                    {{-- </a> --}}
                                    <br>
                                    @if (isset($record->helpdesk->user->position->name))
                                        {{ $record->helpdesk->user->name }}
                                        ({{ $record->helpdesk->user->position->name }})
                                    @endif
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; width: 15%">Insiden Terkait</td>
                            <td style="text-align: center; width: 1%;">:</td>
                            <td style="width: 34%">
                                <ol class="mx-2 px-2">
                                    @foreach ($record->refs as $incident)
                                        <li>
                                            {{-- <a href="{{ route('incident.show', $incident->id) }}"> --}}
                                            {{ $incident->code }}
                                            {!! $incident->labelStatus() !!}
                                            {{-- </a> --}}
                                        </li>
                                    @endforeach
                                </ol>
                            </td>
                            <td style="font-weight: bold; width: 15%">Teknisi</td>
                            <td style="text-align: center; width: 1%;">:</td>
                            <td style="width: 34%">
                                @if (isset($record->identification->group->name))
                                    {{-- <a class="base-modal--render" href="{{ route('master.role-group.show', $record->technician_group_id) }}"> --}}
                                    {{ $record->identification->group->name }}
                                    {{-- </a> --}}
                                    <br>
                                    @if (isset($record->identification->user->position->name))
                                        {{ $record->identification->user->name }}
                                        ({{ $record->identification->user->position->name }})
                                    @endif
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; width: 15%">Lampiran</td>
                            <td style="text-align: center; width: 1%;">:</td>
                            <td>
                                @forelse ($record->files($module)->where('flag', 'attachments')->get() as $file)
                                    <div class="progress-container w-100" data-uid="{{ $file->id }}">
                                        <div class="alert alert-custom alert-light fade show py-2 px-4 mb-0 mt-2 success-uploaded"
                                            role="alert">
                                            <div class="alert-icon">
                                                <i class="{{ $file->file_icon }}"></i>
                                            </div>
                                            <div class="alert-text text-left">
                                                {{-- <input type="hidden" name="attachments[files_ids][]" value="{{ $file->id }}"> --}}
                                                <a href="{{ $file->file_url }}" target="_blank" class="text-primary">
                                                    {{ $file->file_name }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-form-label">{{ __('Tidak ada Lampiran') }}</div>
                                @endforelse
                            </td>
                            {{-- <td colspan="3"></td> --}}
                            <td style="font-weight: bold; width: 15%">Linimasa</td>
                            <td style="text-align: center; width: 1%;">:</td>
                            <td style="width: 34%">
                                <b>Dibuat:</b> {{ $record->created_at->translatedFormat('l d/m/Y H:i') }} <br>
                                @if ($record->open_time)
                                    <b>Open:</b> {{ $record->open_time->translatedFormat('l d/m/Y H:i') }} <br>
                                @endif
                                @if (isset($record->helpdesk->created_at))
                                    <b>Helpdesk:</b>
                                    {{ $record->open_time->diffForHumans($record->helpdesk->updated_at ?? $record->helpdesk->created_at) }}
                                    <br>
                                @endif
                                @if (isset($record->identification->time))
                                    <b>Identifikasi:</b>
                                    {{ $record->identification->created_at->diffForHumans($record->identification->time) }}
                                    <br>
                                @endif
                                @if (isset($record->withdrawal->time))
                                    <b>Penarikan:</b>
                                    {{ $record->withdrawal->time->diffForHumans($record->withdrawal->created_at) }}
                                    <br>
                                @endif
                                @if (isset($record->repair->time))
                                    <b>Perbaikan:</b>
                                    {{ $record->repair->time->diffForHumans($record->repair->created_at) }}
                                    <br>
                                @endif
                                @if (isset($record->closedBy->position->name))
                                    <b>Penyelesaian:</b>
                                    {{ $record->closed_time->diffForHumans($record->technician_to_helpdesk_time ?? $record->open_time) }}
                                    <br>
                                    {{ $record->closedBy->name }} ({{ $record->closedBy->position->name }})
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; width: 15%">Laporan</td>
                            <td style="text-align: center; width: 1%;">:</td>
                            <td colspan="4">
                                {!! $record->reporting_notes !!}
                            </td>
                        </tr>
                        {{-- <tr>
                            <td style="font-weight: bold; width: 15%">Direferensikan Insiden</td>
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
                            <td style="font-weight: bold; width: 15%">Direferensikan Problem</td>
                            <td style="text-align: center; width: 1%;">:</td>
                            <td style="width: 34%">
                                <ol class="mx-2 px-2">
                                    @foreach ($record->problems as $problem)
                                        <li>
                                            <a href="{{ route('problem.show', $problem->id) }}">
                                                {{ $problem->code }}
                                                {!! $problem->labelStatus() !!}
                                            </a>
                                        </li>
                                    @endforeach
                                </ol>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; width: 15%">Direferensikan Change</td>
                            <td style="text-align: center; width: 1%;">:</td>
                            <td style="width: 34%">
                                <ol class="mx-2 px-2">
                                    @foreach ($record->changes as $change)
                                        <li>
                                            <a href="{{ route('change.show', $change->id) }}">
                                                {{ $change->code }}
                                                {!! $change->labelStatus() !!}
                                            </a>
                                        </li>
                                    @endforeach
                                </ol>
                            </td>
                            <td style="font-weight: bold; width: 15%">Direferensikan Knowledge</td>
                            <td style="text-align: center; width: 1%;">:</td>
                            <td style="width: 34%">
                                <ol class="mx-2 px-2">
                                    @foreach ($record->knowledges as $knowledge)
                                        <li>
                                            <a href="{{ route('knowledge.show', $knowledge->id) }}">
                                                {{ $knowledge->title }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ol>
                            </td>
                        </tr> --}}
                    </table>
                </div>
            </div>
        </div>
        @if (in_array($record->status, ['open']) && $record->helpdesk->group->checkMembership($user->id))
            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    @include('layouts.forms.btnBack')
                    <div class="btn-group dropup">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            {{-- <i class="mr-1 fa fa-save"></i> --}}
                            {{ __('Tindak Lanjut') }}
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item align-items-center base-modal--render" data-modal-size="modal-md"
                                data-modal-v-middle="false" data-submit="0"
                                href="{{ route($routes . '.form-dispose', $record->id) }}">
                                {{-- <i class="mr-1 flaticon2-list-3 text-primary"></i> --}}
                                {{ __('Teruskan') }}
                                <span class=""></span>
                            </a>
                            <a class="dropdown-item align-items-center base-modal--render" data-modal-size="modal-xl"
                                data-modal-v-middle="false" data-submit="1"
                                href="{{ route($routes . '.form-close', $record->id) }}">
                                {{-- <i class="mr-1 flaticon-interface-10 text-success"></i> --}}
                                {{ __('Penyelesaian') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @elseif(in_array($record->status, ['approval.waiting']) && $record->checkAction('approval', $perms))
            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    @include('layouts.forms.btnBack')
                    @include('layouts.forms.btnDropdownApproval')
                    @include('layouts.forms.modalReject')
                </div>
            </div>
        @endif
    </div>

    @if (isset($record->identification->user_id))
        <br>
        <div class="card card-custom">
            <div class="card-header">
                <h3 class="card-title">Identifikasi</h3>
                <div class="card-toolbar">
                    {{-- @include('layouts.forms.btnBackTop') --}}
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        @include('globals.notes', ['record' => $record->identification])
                    </div>
                    <div class="col-12">
                        <table class="table table-bordered w-100">
                            <tr>
                                <td style="font-weight: bold; width: 15%">Tgl Identifikasi</td>
                                <td style="text-align: center; width: 1%;">:</td>
                                <td style="width: 34%">
                                    {{ $record->identification->time->format('d/m/Y') }}
                                </td>
                                <td style="font-weight: bold; width: 15%">Jam Identifikasi</td>
                                <td style="text-align: center; width: 1%;">:</td>
                                <td style="width: 34%">
                                    {{ $record->identification->time->format('H:i') }}
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; width: 15%">Penyebab</td>
                                <td style="text-align: center; width: 1%;">:</td>
                                <td colspan="4">
                                    {!! $record->identification->reason !!}
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; width: 15%">Kondisi</td>
                                <td style="text-align: center; width: 1%;">:</td>
                                <td colspan="4">
                                    {!! $record->identification->condition !!}
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; width: 15%">Rekomendasi</td>
                                <td style="text-align: center; width: 1%;">:</td>
                                <td colspan="4">
                                    {!! $record->identification->recommendation !!}
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; width: 15%">Lampiran</td>
                                <td style="text-align: center; width: 1%;">:</td>
                                <td style="width: 34%">
                                    @forelse ($record->files('incident.identification')->where('flag', 'identification')->get() as $file)
                                        <div class="progress-container w-100" data-uid="{{ $file->id }}">
                                            <div class="alert alert-custom alert-light fade show py-2 px-4 mb-0 mt-2 success-uploaded"
                                                role="alert">
                                                <div class="alert-icon">
                                                    <i class="{{ $file->file_icon }}"></i>
                                                </div>
                                                <div class="alert-text text-left">
                                                    {{-- <input type="hidden" name="attachments[files_ids][]" value="{{ $file->id }}"> --}}
                                                    <a href="{{ $file->file_url }}" target="_blank"
                                                        class="text-primary">
                                                        {{ $file->file_name }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-form-label">{{ __('Tidak ada Lampiran') }}</div>
                                    @endforelse
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; width: 15%">Tindak Lanjut</td>
                                <td style="text-align: center; width: 1%;">:</td>
                                <td style="width: 34%">
                                    {{ $record->identification->follow_up }}
                                </td>
                                <td style="font-weight: bold; width: 15%">Teknisi</td>
                                <td style="text-align: center; width: 1%;">:</td>
                                <td style="width: 34%">
                                    {{ $record->identification->group->name }}<br>
                                    {{ $record->identification->user->name }}
                                    ({{ $record->identification->user->position->name }})
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            @if (in_array($record->identification->status, ['approval.waiting']) &&
                    $record->identification->checkAction('approval', $perms))
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        @include('layouts.forms.btnBack')
                        @include('layouts.forms.btnDropdownApproval', [
                            'urlApprove' => route($routes . '.approve', $record->identification->id),
                        ])
                        @include('layouts.forms.modalReject')
                    </div>
                </div>
            @endif
        </div>
    @endif

    @if (isset($record->withdrawal->id))
        <br>
        <div class="card card-custom">
            <div class="card-header">
                <h3 class="card-title">Penarikan</h3>
                <div class="card-toolbar">
                    {{-- @include('layouts.forms.btnBackTop') --}}
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        @include('globals.notes', ['record' => $record->withdrawal])
                    </div>
                    <div class="col-12">
                        <table class="table table-bordered w-100">
                            <tr>
                                <td style="font-weight: bold; width: 15%">Tgl Penarikan</td>
                                <td style="text-align: center; width: 1%;">:</td>
                                <td style="width: 34%">
                                    {{ isset($record->withdrawal->time) ? $record->withdrawal->time->format('d/m/Y') : '' }}
                                </td>
                                <td colspan="3"></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; width: 15%">Keterangan</td>
                                <td style="text-align: center; width: 1%;">:</td>
                                <td colspan="4">
                                    {!! $record->withdrawal->description !!}
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; width: 15%">Lampiran</td>
                                <td style="text-align: center; width: 1%;">:</td>
                                <td style="width: 34%">
                                    @forelse ($record->files('incident.withdrawal')->where('flag', 'withdrawal')->get() as $file)
                                        <div class="progress-container w-100" data-uid="{{ $file->id }}">
                                            <div class="alert alert-custom alert-light fade show py-2 px-4 mb-0 mt-2 success-uploaded"
                                                role="alert">
                                                <div class="alert-icon">
                                                    <i class="{{ $file->file_icon }}"></i>
                                                </div>
                                                <div class="alert-text text-left">
                                                    {{-- <input type="hidden" name="attachments[files_ids][]" value="{{ $file->id }}"> --}}
                                                    <a href="{{ $file->file_url }}" target="_blank"
                                                        class="text-primary">
                                                        {{ $file->file_name }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-form-label">{{ __('Tidak ada Lampiran') }}</div>
                                    @endforelse
                                </td>
                                <td colspan="3"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            @if (in_array($record->withdrawal->status, ['approval.waiting']) && $record->withdrawal->checkAction('approval', $perms))
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        @include('layouts.forms.btnBack')
                        @include('layouts.forms.btnDropdownApproval', [
                            'urlApprove' => route($routes . '.approve', $record->withdrawal->id),
                        ])
                        @include('layouts.forms.modalReject')
                    </div>
                </div>
            @endif
        </div>
    @endif

    @if (isset($record->repair->id))
        <br>
        <div class="card card-custom">
            <div class="card-header">
                <h3 class="card-title">Perbaikan</h3>
                <div class="card-toolbar">
                    {{-- @include('layouts.forms.btnBackTop') --}}
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        @include('globals.notes', ['record' => $record->repair])
                    </div>
                    <div class="col-12">
                        <table class="table table-bordered w-100">
                            <tr>
                                <td style="font-weight: bold; width: 15%">Tgl Perbaikan</td>
                                <td style="text-align: center; width: 1%;">:</td>
                                <td style="width: 34%">
                                    {{ isset($record->repair->time) ? $record->repair->time->format('d/m/Y') : '' }}
                                </td>
                                <td colspan="3"></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; width: 15%">Keterangan</td>
                                <td style="text-align: center; width: 1%;">:</td>
                                <td colspan="4">
                                    {!! $record->repair->description !!}
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; width: 15%">Lampiran</td>
                                <td style="text-align: center; width: 1%;">:</td>
                                <td style="width: 34%">
                                    @forelse ($record->files('incident.repair')->where('flag', 'repair')->get() as $file)
                                        <div class="progress-container w-100" data-uid="{{ $file->id }}">
                                            <div class="alert alert-custom alert-light fade show py-2 px-4 mb-0 mt-2 success-uploaded"
                                                role="alert">
                                                <div class="alert-icon">
                                                    <i class="{{ $file->file_icon }}"></i>
                                                </div>
                                                <div class="alert-text text-left">
                                                    {{-- <input type="hidden" name="attachments[files_ids][]" value="{{ $file->id }}"> --}}
                                                    <a href="{{ $file->file_url }}" target="_blank"
                                                        class="text-primary">
                                                        {{ $file->file_name }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-form-label">{{ __('Tidak ada Lampiran') }}</div>
                                    @endforelse
                                </td>
                                <td style="font-weight: bold; width: 15%">Pelaksana</td>
                                <td style="text-align: center; width: 1%;">:</td>
                                <td style="width: 34%">
                                    @if (isset($record->repair->user->name))
                                        {{ $record->repair->user->name }}
                                        ({{ $record->repair->user->position->name }})
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            @if (in_array($record->repair->status, ['approval.waiting']) && $record->repair->checkAction('approval', $perms))
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        @include('layouts.forms.btnBack')
                        @include('layouts.forms.btnDropdownApproval', [
                            'urlApprove' => route($routes . '.approve', $record->repair->id),
                        ])
                        @include('layouts.forms.modalReject')
                    </div>
                </div>
            @endif
        </div>
    @endif

    @if ($record->status == 'closed')
        <br>
        <div class="card card-custom">
            <div class="card-header">
                <h3 class="card-title">Penyelesaian</h3>
                <div class="card-toolbar">
                    {{-- @include('layouts.forms.btnBackTop') --}}
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered w-100">
                            <tr>
                                <td style="font-weight: bold; width: 15%">Tgl Penyelesaian</td>
                                <td style="text-align: center; width: 1%;">:</td>
                                <td style="width: 34%">
                                    {{ $record->closed_time->format('d/m/Y') }}
                                </td>
                                <td style="font-weight: bold; width: 15%">Pelaksana</td>
                                <td style="text-align: center; width: 1%;">:</td>
                                <td style="width: 34%">
                                    {{ $record->closedBy->name }} ({{ $record->closedBy->position->name }})
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; width: 15%">Penyelesaian</td>
                                <td style="text-align: center; width: 1%;">:</td>
                                <td colspan="4">
                                    {{-- {{ $record->closedBy->name }} ({{ $record->closedBy->position->name }})
                                    <br> --}}
                                    {!! $record->conclusion_notes !!}
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; width: 15%">Lampiran</td>
                                <td style="text-align: center; width: 1%;">:</td>
                                <td style="width: 34%">
                                    @forelse ($record->files($module)->where('flag', 'conclusion')->get() as $file)
                                        <div class="progress-container w-100" data-uid="{{ $file->id }}">
                                            <div class="alert alert-custom alert-light fade show py-2 px-4 mb-0 mt-2 success-uploaded"
                                                role="alert">
                                                <div class="alert-icon">
                                                    <i class="{{ $file->file_icon }}"></i>
                                                </div>
                                                <div class="alert-text text-left">
                                                    {{-- <input type="hidden" name="attachments[files_ids][]" value="{{ $file->id }}"> --}}
                                                    <a href="{{ $file->file_url }}" target="_blank"
                                                        class="text-primary">
                                                        {{ $file->file_name }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-form-label">{{ __('Tidak ada Lampiran') }}</div>
                                    @endforelse
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
@endpush
