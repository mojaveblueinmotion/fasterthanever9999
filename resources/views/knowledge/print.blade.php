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
                    <b>{{ strtoupper(__('Knowledge')) }}</b>
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
                <td style="border: none; width: 10%;" align="right"><span class="pagenum"></span></td>
            </tr>
        </table>
    </footer>
    <main>
        <table style="border:none; width:100%;">
            <tr>
                <td style="border: none; font-weight: bold; vertical-align: top; width: 19%">Judul</td>
                <td style="border: none; text-align: center; vertical-align: top; width: 1%;">:</td>
                <td style="border: none; vertical-align: top; width: 30%">
                    {{ $record->title }}
                </td>
                <td style="border: none; font-weight: bold; vertical-align: top; width: 19%">Insiden Terkait</td>
                <td style="border: none; text-align: center; vertical-align: top; width: 1%;">:</td>
                <td style="border: none; vertical-align: top; width: 30%">
                    <ol class="mx-2 px-2">
                        @foreach ($record->incidents as $incident)
                            <li>
                                {{ $incident->code }}
                                {!! $incident->labelStatus() !!}
                            </li>
                        @endforeach
                    </ol>
                </td>
            </tr>
            <tr>
                <td style="border: none; font-weight: bold; vertical-align: top; width: 19%">Dibuat Oleh</td>
                <td style="border: none; text-align: center; vertical-align: top; width: 1%;">:</td>
                <td style="border: none; vertical-align: top; width: 30%">
                    {{ $record->creator->name }} ({{ $record->creator->position->name }})
                    <br> {{ $record->creator->position->location->name }}
                </td>
                <td style="border: none; font-weight: bold; vertical-align: top; width: 19%">Problem Terkait</td>
                <td style="border: none; text-align: center; vertical-align: top; width: 1%;">:</td>
                <td style="border: none; vertical-align: top; width: 30%">
                    <ol class="mx-2 px-2">
                        @foreach ($record->problems as $problem)
                            <li>
                                {{ $problem->code }}
                                {!! $problem->labelStatus() !!}
                            </li>
                        @endforeach
                    </ol>
                </td>
            </tr>
            <tr>
                <td style="border: none; font-weight: bold; vertical-align: top; width: 19%">Aset</td>
                <td style="border: none; text-align: center; vertical-align: top; width: 1%;">:</td>
                <td style="border: none; vertical-align: top; width: 30%">
                    {{ $record->asset->name }}
                    <br>
                    <b>Tipe: </b>{{ $record->asset->type->name }}
                </td>
                <td style="border: none; font-weight: bold; vertical-align: top; width: 19%">Change Terkait</td>
                <td style="border: none; text-align: center; vertical-align: top; width: 1%;">:</td>
                <td style="border: none; vertical-align: top; width: 30%">
                    <ol class="mx-2 px-2">
                        @foreach ($record->changes as $change)
                            <li>
                                {{ $change->code }}
                                {!! $change->labelStatus() !!}
                            </li>
                        @endforeach
                    </ol>
                </td>
            </tr>
            <tr>
                <td style="border: none; font-weight: bold; vertical-align: top; width: 19%">Komponen Aset</td>
                <td style="border: none; text-align: center; vertical-align: top; width: 1%;">:</td>
                <td style="border: none; vertical-align: top; width: 30%">
                    <ol class="mx-2 px-2">
                        @foreach ($record->assetDetails as $asset_detail)
                            <li>
                                {{ $asset_detail->name }}
                            </li>
                        @endforeach
                    </ol>
                </td>
                <td style="border: none; font-weight: bold; vertical-align: top; width: 19%">Knowledge Terkait</td>
                <td style="border: none; text-align: center; vertical-align: top; width: 1%;">:</td>
                <td style="border: none; vertical-align: top; width: 30%">
                    <ol class="mx-2 px-2">
                        @foreach ($record->refs as $knowledge)
                            <li>
                                {{ $knowledge->code }}
                                {!! $knowledge->labelStatus() !!}
                            </li>
                        @endforeach
                    </ol>
                </td>
            </tr>
            <tr>
                <td style="border: none; font-weight: bold; vertical-align: top; width: 19%">Uraian Knowledge</td>
                <td style="border: none; text-align: center; vertical-align: top; width: 1%;">:</td>
                <td colspan="4" style="border: none; vertical-align: top;">
                    {!! $record->text !!}
                    <b>Lampiran :</b><br>
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
                        <div class="col-form-label">{{ __('Tidak ada Lampiran :') }}</div>
                    @endforelse
                </td>
            </tr>
        </table>
    </main>
</body>

</html>
