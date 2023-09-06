@extends('layouts.page', ['container' => 'container'])
@php
    $route_name = '.unknown';
    if ($record->status == 'open') {
        $route_name = '.post-open';
    }
    if (in_array($record->status, ['repair.waiting', 'repair'])) {
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
                    <td style="font-weight: bold; width: 15%">Judul</td>
                    <td style="text-align: center; width: 1%;">:</td>
                    <td style="width: 34%">
                        {{ $record->title }}
                    </td>
                    <td style="font-weight: bold; width: 15%">Insiden Terkait</td>
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
                    <td style="font-weight: bold; width: 15%">Dibuat Oleh</td>
                    <td style="text-align: center; width: 1%;">:</td>
                    <td style="width: 34%">
                        {{ $record->creator->name }} ({{ $record->creator->position->name }})
                        <br> {{ $record->creator->position->location->name }}
                    </td>
                    <td style="font-weight: bold; width: 15%">Problem Terkait</td>
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
                    <td style="font-weight: bold; width: 15%">Aset</td>
                    <td style="text-align: center; width: 1%;">:</td>
                    <td style="width: 34%">
                        <a href="{{ route('master.asset.detail', $record->asset_id) }}">{{ $record->asset->name }}</a>
                        <br>
                        <b>Tipe: </b>{{ $record->asset->type->name }}
                    </td>
                    <td style="font-weight: bold; width: 15%">Change Terkait</td>
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
                </tr>
                <tr>
                    <td style="font-weight: bold; width: 15%">Komponen Aset</td>
                    <td style="text-align: center; width: 1%;">:</td>
                    <td style="width: 34%">
                        <ol class="mx-2 px-2">
                            @foreach ($record->assetDetails as $asset_detail)
                                <li>
                                    {{ $asset_detail->name }}
                                </li>
                            @endforeach
                        </ol>
                    </td>
                    <td style="font-weight: bold; width: 15%">Knowledge Terkait</td>
                    <td style="text-align: center; width: 1%;">:</td>
                    <td style="width: 34%">
                        <ol class="mx-2 px-2">
                            @foreach ($record->refs as $knowledge)
                                <li>
                                    <a href="{{ route('knowledge.show', $knowledge->id) }}">
                                        {{ $knowledge->code }}
                                        {!! $knowledge->labelStatus() !!}
                                    </a>
                                </li>
                            @endforeach
                        </ol>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold; width: 15%">Uraian Knowledge</td>
                    <td style="text-align: center; width: 1%;">:</td>
                    <td colspan="4">
                        {!! $record->text !!}
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
                <tr>
                    <td style="font-weight: bold; width: 15%">Direferensikan Knowledge</td>
                    <td style="text-align: center; width: 1%;">:</td>
                    <td style="width: 34%">
                        <ol class="mx-2 px-2">
                            @foreach ($record->knowledges as $knowledge)
                                <li>
                                    <a href="{{ route('knowledge.show', $knowledge->id) }}">
                                        {{ $knowledge->code }}
                                        {!! $knowledge->labelStatus() !!}
                                    </a>
                                </li>
                            @endforeach
                        </ol>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endsection

@if (
    (in_array($record->status, ['open', 'repaired']) && $record->helpdeskGroup->checkMembership($user->id)) ||
        (in_array($record->status, ['repair.waiting', 'repair']) &&
            $record->technicianGroup->checkMembership($user->id)))
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
