<html>

<head>
    <title>{{ $title }}</title>
    <style>
        * {
            box-sizing: border-box;
        }

        /** Define the margins of your page **/
        @page {
            margin: 1cm;
        }

        header {
            position: fixed;
            top: 0px;
            left: 0;
            right: 0;
            /*margin-left: 10mm;*/
            /*margin-right: 5mm;*/
            /*line-height: 35px;*/
        }

        footer {
            position: fixed;
            bottom: -30px;
            left: 0px;
            right: 0;
            height: 30px;
            line-height: 35px;
        }

        body {
            margin-top: 2cm;
            font-size: 12pt;
            font-weight: normal;
        }

        .pagenum:before {
            content: counter(page);
            content: counter(page, decimal);
        }

        table {
            width: 100%;
            border: 1pt solid black;
            border-collapse: collapse;
        }

        tr th,
        tr td {
            border-bottom: 1pt solid black;
            border: 1pt solid black;
            border-right: 1pt solid black;
        }

        ul,
        ol {
            margin: 0;
            padding-left: 20px;
        }

        p {
            margin-top: 0;
        }

        td p {
            margin-bottom: 0;
        }


        .table-data {
            height: 44px;
            background-repeat: no-repeat;
            /*background-position: center center;*/
            border: 1px solid;
            /*text-align: justify;*/
            /*background-color: #ffffff;*/
            font-weight: normal;
            /*color: #555555;*/
            /*padding: 11px 5px 11px 5px;*/
            vertical-align: middle;
        }

        .table-data tr th,
        .table-data tr td {
            padding: 5px 8px;
        }

        .table-data tr td {
            vertical-align: top;
        }

        .page-break: {
            page-break-inside: always;
        }

        .nowrap {
            white-space: nowrap;
        }

        .wysiwyg-content {
            max-width: 100% !important;
            text-align: justify;
            width: 100% !important;
        }

        .wysiwyg-content img {
            max-height: 90% !important;
            max-width: 100% !important;
        }
    </style>
</head>

<body class="page">
    <header>
        <table style="border:none; width: 100%;">
            <tr>
                <td style="border:none;" width="150px">
                    <img src="{{ config('base.logo.print') }}" style="max-width: 150px; max-height: 60px">
                </td>
                <td style="border:none;  text-align: center; font-size: 14pt;" width="auto">
                    <b>{{ strtoupper(__('Incident')) }}</b>
                    <div><b>{{ strtoupper(config('base.company.name')) }}</b></div>
                </td>
                <td style="border:none; text-align: right; font-size: 12px;" width="150px">
                    <b></b>
                </td>
            </tr>
        </table>
        <hr>
    </header>
    <footer>
        <table width="100%" border="0" style="border: none;">
            <tr>
                <td style="width: 10%;border: none;" align="right"><span class="pagenum"></span></td>
            </tr>
        </table>
    </footer>
    <main>
        <h2 style="text-align: center">Pengaduan</h2>
        <table style="border: none; width: 100%">
            <tr>
                <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">No Tiket</td>
                <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                <td style="border: none; vertical-align:top; width: 34%">
                    {{ $record->code }}
                    {!! $record->labelStatus() !!} <br>
                </td>
                <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Tanggal Insiden</td>
                <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                <td style="border: none; vertical-align:top; width: 34%">
                    {{ $record->date->format('d/m/Y') }}
                </td>
            </tr>
            <tr>
                <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Pelapor</td>
                <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                <td style="border: none; vertical-align:top; width: 34%">
                    {{ $record->reporter->name }} ({{ $record->reporter->position->name }})
                    <br> {{ $record->reporter->position->location->name }}
                </td>
                <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Priority</td>
                <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                <td style="border: none; vertical-align:top; width: 34%">
                    {{ $record->priority->name ?? '' }}
                </td>
            </tr>
            <tr>
                <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Aset</td>
                <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                <td style="border: none; vertical-align:top; width: 34%">
                    {{-- <a href="{{ route('master.asset.detail', $record->asset_id) }}"> --}}
                    {{ $record->asset->name }}
                    {{-- </a> --}}
                    <br>
                    <b>Tipe: </b>{{ $record->asset->type->name }}
                </td>
                <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Severity</td>
                <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                <td style="border: none; vertical-align:top; width: 34%">
                    {{ $record->severity->name ?? '' }}
                </td>
            </tr>
            <tr>
                <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Komponen Aset</td>
                <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                <td style="border: none; vertical-align:top; width: 34%">
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
                <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Helpdesk</td>
                <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                <td style="border: none; vertical-align:top; width: 34%">
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
                <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Insiden Terkait</td>
                <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                <td style="border: none; vertical-align:top; width: 34%">
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
                <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Teknisi</td>
                <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                <td style="border: none; vertical-align:top; width: 34%">
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
                <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Lampiran</td>
                <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                <td style="border: none; vertical-align:top;">
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
                <td colspan="3" style="border: none:"></td>
                {{-- <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Linimasa</td>
                <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                <td style="border: none; vertical-align:top; width: 34%">
                    <b>Dibuat:</b> {{ $record->created_at->translatedFormat('l d/m/Y H:i') }} <br>
                    @if ($record->open_time)
                        <b>Open:</b> {{ $record->open_time->translatedFormat('l d/m/Y H:i') }} <br>
                    @endif
                    @if (isset($record->helpdesk->created_at))
                        <b>Helpdesk:</b>
                        {{ $record->open_time->diffForHumans($record->helpdesk->created_at) }}
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
                </td> --}}
            </tr>
            <tr>
                <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Laporan</td>
                <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                <td colspan="4" style="border: none; vertical-align:top;">
                    {!! $record->reporting_notes !!}
                </td>
            </tr>
        </table>

        @if (isset($record->identification->user_id))
            <br>
            <h2 style="text-align: center">Identifikasi</h2>
            <table style="border: none; width: 100%">
                <tr>
                    <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Tanggal</td>
                    <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                    <td style="border: none; vertical-align:top; width: 34%">
                        {{ $record->identification->time->format('d/m/Y') }}
                    </td>
                    <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Jam</td>
                    <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                    <td style="border: none; vertical-align:top; width: 34%">
                        {{ $record->identification->time->format('H:i') }}
                    </td>
                </tr>
                <tr>
                    <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Penyebab</td>
                    <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                    <td colspan="4" style="border: none; vertical-align:top; width: 34%">
                        {!! $record->identification->reason !!}
                    </td>
                </tr>
                <tr>
                    <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Kondisi</td>
                    <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                    <td colspan="4" style="border: none; vertical-align:top; width: 34%">
                        {!! $record->identification->condition !!}
                    </td>
                </tr>
                <tr>
                    <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Rekomendasi</td>
                    <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                    <td colspan="4" style="border: none; vertical-align:top; width: 34%">
                        {!! $record->identification->recommendation !!}
                    </td>
                </tr>
                <tr>
                    <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Lampiran</td>
                    <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                    <td style="border: none; vertical-align:top; width: 34%">
                        @forelse ($record->files('incident.identification')->where('flag', 'identification')->get() as $file)
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
                </tr>
                <tr>
                    <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Tindak Lanjut</td>
                    <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                    <td style="border: none; vertical-align:top; width: 34%">
                        {{ $record->identification->follow_up }}
                    </td>
                    <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Teknisi</td>
                    <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                    <td style="border: none; vertical-align:top; width: 34%">
                        {{ $record->identification->group->name }}<br>
                        {{ $record->identification->user->name }}
                        ({{ $record->identification->user->position->name }})
                    </td>
                </tr>
            </table>
        @endif

        @if (isset($record->withdrawal->id))
            <br>
            <h2 style="text-align: center">Penarikan</h2>
            <table style="border: none; width: 100%">
                <tr>
                    <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Tanggal</td>
                    <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                    <td style="border: none; vertical-align:top; width: 34%">
                        {{ isset($record->withdrawal->time) ? $record->withdrawal->time->format('d/m/Y') : '' }}
                    </td>
                    <td colspan="3" style="border: none"></td>
                </tr>
                <tr>
                    <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Keterangan</td>
                    <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                    <td colspan="4" style="border: none; vertical-align:top; width: 34%">
                        {!! $record->withdrawal->description !!}
                    </td>
                </tr>
                <tr>
                    <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Lampiran</td>
                    <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                    <td style="border: none; vertical-align:top; width: 34%">
                        @forelse ($record->files('incident.withdrawal')->where('flag', 'withdrawal')->get() as $file)
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
                    <td colspan="3" style="border: none"></td>
                </tr>
            </table>
        @endif

        @if (isset($record->repair->id))
            <br>
            <h2 style="text-align: center">Perbaikan</h2>
            <table style="border: none; width: 100%">
                <tr>
                    <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Tanggal</td>
                    <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                    <td style="border: none; vertical-align:top; width: 34%">
                        {{ isset($record->repair->time) ? $record->repair->time->format('d/m/Y') : '' }}
                    </td>
                    <td colspan="3" style="border: none"></td>
                </tr>
                <tr>
                    <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Keterangan</td>
                    <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                    <td colspan="4" style="border: none">
                        {!! $record->repair->description !!}
                    </td>
                </tr>
                <tr>
                    <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Lampiran</td>
                    <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                    <td style="border: none; vertical-align:top; width: 34%">
                        @forelse ($record->files('incident.repair')->where('flag', 'repair')->get() as $file)
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
                    <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Pelaksana</td>
                    <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                    <td style="border: none; vertical-align:top; width: 34%">
                        {{ $record->repair->user->name }} ({{ $record->repair->user->position->name }})
                    </td>
                </tr>
            </table>
        @endif

        @if ($record->status == 'closed')
            <br>
            <h2 style="text-align: center">Penyelesaian</h2>
            <table style="border: none; width: 100%">
                <tr>
                    <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Tgl Penyelesaian</td>
                    <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                    <td style="border: none; vertical-align:top; width: 34%">
                        {{ $record->closed_time->format('d/m/Y') }}
                    </td>
                    <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Pelaksana</td>
                    <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                    <td style="border: none; vertical-align:top; width: 34%">
                        {{ $record->closedBy->name }} ({{ $record->closedBy->position->name }})
                    </td>
                </tr>
                <tr>
                    <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Penyelesaian</td>
                    <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                    <td colspan="4">
                        {{-- {{ $record->closedBy->name }} ({{ $record->closedBy->position->name }})
                        <br> --}}
                        {!! $record->conclusion_notes !!}
                    </td>
                </tr>
                <tr>
                    <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Lampiran</td>
                    <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                    <td style="border: none; vertical-align:top; width: 34%">
                        @forelse ($record->files($module)->where('flag', 'conclusion')->get() as $file)
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
                </tr>
            </table>
        @endif
    </main>
</body>

</html>
