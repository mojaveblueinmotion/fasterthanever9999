@extends('layouts.page', ['container' => 'container'])

@section('card-body')
    @method('POST')
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-bordered">
                <tr>
                    <td style="font-weight: bold; width: 15%">Nama Aset</td>
                    <td style="text-align: center; width: 1%;">:</td>
                    <td style="width: 34%">
                        {{ $record->name }}
                    </td>
                    <td style="font-weight: bold; width: 15%">Tipe Aset</td>
                    <td style="text-align: center; width: 1%;">:</td>
                    <td style="width: 34%">
                        {{ $record->type->name }}
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold; width: 15%">Serial Number</td>
                    <td style="text-align: center; width: 1%;">:</td>
                    <td style="width: 34%">
                        {{ $record->serial_number }}
                    </td>
                    <td style="font-weight: bold; width: 15%">Merk</td>
                    <td style="text-align: center; width: 1%;">:</td>
                    <td style="width: 34%">
                        {{ $record->merk }}
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold; width: 15%">Tgl Registrasi</td>
                    <td style="text-align: center; width: 1%;">:</td>
                    <td style="width: 34%">
                        {{ $record->regist_date->format('d/m/Y') }}
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold; width: 15%">Incident</td>
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
                    <td style="font-weight: bold; width: 15%">Problem</td>
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
                    <td style="font-weight: bold; width: 15%">Change</td>
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
                    <td style="font-weight: bold; width: 15%">Knowledge</td>
                    <td style="text-align: center; width: 1%;">:</td>
                    <td style="width: 34%">
                        <ol class="mx-2 px-2">
                            @foreach ($record->knowledges ?? [] as $knowledge)
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

    <hr>
    <table id="dataFilters" class="width-full">
        <tbody>
            <tr>
                <td class="pb-2 valign-top td-filter-reset width-80px">
                    <div class="reset-filter mr-1 hide">
                        <button class="btn btn-secondary btn-icon width-full reset button" data-toggle="tooltip"
                            data-original-title="Reset Filter"><i class="fas fa-sync"></i></button>
                    </div>
                    <div class="label-filter mr-1">
                        <button class="btn btn-secondary btn-icon width-full filter button" data-toggle="tooltip"
                            data-original-title="Filter"><i class="fas fa-filter"></i></button>
                    </div>
                </td>
                <td>
                    <div class="row">
                        <div class="col-12 col-sm-6 col-xl-3 pb-2">
                            <input type="text" class="form-control filter-control" data-post="name"
                                placeholder="{{ __('Komponen Aset') }}">
                        </div>
                    </div>
                </td>
                <td class="text-right td-btn-create width-200px">
                    @if (auth()->user()->checkPerms($perms . '.create'))
                        @include('layouts.forms.btnAdd', [
                            'modal_size'    => 'modal-lg',
                            'urlAdd'        => route($routes . '.detail.create', $record->id),
                        ])
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
    <div class="table-responsive">
        @if (isset($tableStruct['datatable_1']))
            <table id="datatable_1" class="table table-bordered is-datatable" style="width: 100%;"
                data-url="{{ $tableStruct['url'] }}" data-paging="{{ $paging ?? true }}" data-info="{{ $info ?? true }}">
                <thead>
                    <tr>
                        @foreach ($tableStruct['datatable_1'] as $struct)
                            <th class="text-center v-middle" data-columns-name="{{ $struct['name'] ?? '' }}"
                                data-columns-data="{{ $struct['data'] ?? '' }}"
                                data-columns-label="{{ $struct['label'] ?? '' }}"
                                data-columns-sortable="{{ $struct['sortable'] === true ? 'true' : 'false' }}"
                                data-columns-width="{{ $struct['width'] ?? '' }}"
                                data-columns-class-name="{{ $struct['className'] ?? '' }}"
                                style="{{ isset($struct['width']) ? 'width: ' . $struct['width'] . '; ' : '' }}">
                                {{ $struct['label'] }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        @endif
    </div>
@endsection

@section('buttons')
@endsection

@push('scripts')
@endpush
