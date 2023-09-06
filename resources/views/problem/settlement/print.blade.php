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
        <table style="border:none; width:100%;">
            <tr>
                <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Insiden</td>
                <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                <td style="border: none; vertical-align:top; width: 34%">
                    {{ $record->code }}
                    {!! $record->labelStatus() !!} <br>
                </td>
                <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Priority</td>
                <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                <td style="border: none; vertical-align:top; width: 34%">
                    {{ $record->priority->name ?? '' }}
                </td>
            </tr>
            <tr>
                <td style="border: none; font-weight: bold; vertical-align:top;width: 15%">Pelapor</td>
                <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                <td style="border: none; vertical-align:top; width: 34%">
                    {{ $record->creator->name }} ({{ $record->creator->position->name }})
                    <br> {{ $record->creator->position->location->name }}
                </td>
                <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Severity</td>
                <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                <td style="border: none; vertical-align:top; width: 34%">
                    {{ $record->severity->name ?? '' }}
                </td>
            </tr>
            <tr>
                <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Aset</td>
                <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                <td style="border: none; vertical-align:top; width: 34%">
                    {{ $record->asset->name }}
                    <br>
                    <b>Tipe: </b>{{ $record->asset->type->name }}
                </td>
                <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Grup Helpdesk</td>
                <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                <td style="border: none; vertical-align:top; width: 34%">
                    @if (isset($record->helpdeskGroup->name))
                        {{ $record->helpdeskGroup->name }}
                        <br>
                        @if (isset($record->helpdeskUser->position->name))
                            {{ $record->helpdeskUser->name }} ({{ $record->helpdeskUser->position->name }})
                        @endif
                    @endif
                </td>
            </tr>
            <tr>
                <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Komponen Aset</td>
                <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                <td style="border: none; vertical-align:top; width: 34%">
                    <ol class="mx-2 px-2">
                        @foreach ($record->assetDetails as $asset_detail)
                            <li>
                                {{ $asset_detail->name }}
                            </li>
                        @endforeach
                    </ol>
                </td>
                <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Grup Teknisi</td>
                <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                <td style="border: none; vertical-align:top; width: 34%">
                    @if (isset($record->technicianGroup->name))
                        {{ $record->technicianGroup->name }}
                        <br>
                        @if (isset($record->technicianUser->position->name))
                            {{ $record->technicianUser->name }} ({{ $record->technicianUser->position->name }})
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
                                {{ $incident->code }}
                            </li>
                        @endforeach
                    </ol>
                </td>
                <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Linimasa</td>
                <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                <td style="border: none; vertical-align:top; width: 34%">
                    <b>Dibuat:</b> {{ $record->created_at->translatedFormat('l d/m/Y H:i') }} <br>
                    @if ($record->open_time)
                        <b>Open:</b> {{ $record->open_time->translatedFormat('l d/m/Y H:i') }} <br>
                    @endif
                    @if ($record->helpdesk_to_technician_time)
                        <b>Diteruskan ke Teknisi:</b>
                        {{ $record->helpdesk_to_technician_time->diffForHumans($record->open_time) }}
                        <br>
                    @endif
                    @if ($record->technician_start_time)
                        <b>Mulai Perbaikan:</b>
                        {{ $record->technician_start_time->diffForHumans($record->helpdesk_to_technician_time) }}
                        <br>
                    @endif
                    @if ($record->technician_to_helpdesk_time)
                        <b>Perbaikan Selesai:</b>
                        {{ $record->technician_to_helpdesk_time->diffForHumans($record->technician_start_time) }}
                        <br>
                    @endif
                    @if (isset($record->closedBy->position->name))
                        <b>Closed:</b>
                        {{ $record->closed_time->diffForHumans($record->technician_to_helpdesk_time ?? $record->open_time) }}
                        <br>
                        {{ $record->closedBy->name }} ({{ $record->closedBy->position->name }})
                    @endif
                </td>
            </tr>
            <tr>
                <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Laporan</td>
                <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                <td colspan="4" style="border: none; vertical-align:top; ">
                    {!! $record->reporting_notes !!}
                    <b>Lampiran</b><br>
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
                        <div class="col-form-label">{{ __('Tidak ada Lampiran.') }}</div>
                    @endforelse
                </td>
            </tr>
            @if (in_array($record->status, ['repair.waiting', 'repair', 'repaired', 'closed']) &&
                    isset($record->technicianUser->name))
                <tr>
                    <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Helpdesk</td>
                    <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                    <td colspan="4" style="border: none; vertical-align:top; ">
                        {{-- {{ $record->helpdeskUser->name }} ({{ $record->helpdeskUser->position->name }})
                        <br> --}}
                        {!! $record->helpdesk_to_technician_notes !!}
                        <b>Lampiran</b><br>
                        @forelse ($record->files($module)->where('flag', 'helpdesk-to-technician')->get() as $file)
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
                            <div class="col-form-label">{{ __('Tidak ada Lampiran.') }}</div>
                        @endforelse
                    </td>
                </tr>
            @endif
            @if (in_array($record->status, ['repaired', 'closed']) && isset($record->technicianUser->name))
                <tr>
                    <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Teknisi</td>
                    <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                    <td colspan="4" style="border: none; vertical-align:top; ">
                        {{-- {{ $record->technicianUser->name }} ({{ $record->technicianUser->position->name }})
                        <br> --}}
                        <b>Identifikasi</b>
                        {!! $record->technician_identification_notes !!}
                        <b>Penyelesaian</b>
                        {!! $record->technician_solution_notes !!}
                        <b>Lampiran</b><br>
                        @forelse ($record->files($module)->where('flag', 'technician-to-helpdesk')->get() as $file)
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
                            <div class="col-form-label">{{ __('Tidak ada Lampiran.') }}</div>
                        @endforelse
                    </td>
                </tr>
            @endif
            @if (in_array($record->status, ['closed']))
                <tr>
                    <td style="border: none; font-weight: bold; vertical-align:top; width: 15%">Helpdesk</td>
                    <td style="border: none; text-align: center; vertical-align:top; width: 1%;">:</td>
                    <td colspan="4" style="border: none; vertical-align:top; ">
                        {{-- {{ $record->closedBy->name }} ({{ $record->closedBy->position->name }})
                        <br> --}}
                        {!! $record->conclusion_notes !!}
                        <b>Lampiran</b><br>
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
                            <div class="col-form-label">{{ __('Tidak ada Lampiran.') }}</div>
                        @endforelse
                    </td>
                </tr>
            @endif
        </table>
    </main>
</body>

</html>
