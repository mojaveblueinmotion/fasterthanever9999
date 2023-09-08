<html>

<head>
    <title>{{ $title }}</title>
    <style>
        * {
            box-sizing: border-box;
        }

        /** Define the margins of your page **/
        @page {
            margin: 1cm 1.5cm 1cm 1.5cm;
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
            bottom: 0;
            left: 0px;
            right: 0;
            height: 50px;
            line-height: 35px;
        }

        body {
            margin-top: 2cm;
            font-size: 12pt;
        }

        .pagenum:before {
            content: counter(page);
            content: counter(page, decimal);
        }

        table {
            width: 100%;
            border: 1pt solid black;
            border-collapse: collapse;
            /* table-layout: fixed; */
        }

        tr th,
        tr td {
            border-bottom: 1pt solid black;
            border: 1pt solid black;
            border-right: 1pt solid black;
        }

        ul {
            margin: 0;
            padding-left: 20px;
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

        .text-center {
            text-align: center;
        }
    </style>
</head>
</head>

<body class="page">
    <header>
        <table style="border:none; width: 100%;">
            <tr>
                <td style="border:none;" width="150px">
                    <img src="{{ config('base.logo.your_logo') }}" style="max-width: 150px; max-height: 60px">
                </td>
                <td style="border:none;  text-align: center; font-size: 14pt;" width="auto">
                    <b>{{ __('PURCHASE ORDER') }}</b>
                    {{-- <div><b> {{ strtoupper($record->unitKerja->name) }}</b></div> --}}
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
        <table style="border:none; width:100%; margin-top: 0.5rem;">
            <tr>
                <td style="border:none; width:48%;">
                    <table style="border:none; width:100%;">
                        <tr>
                            <td style="border: none; width: 150px;">{{ __('ID Purchase Order') }}</td>
                            <td style="border: none; width: 10px; text-align: left;">:</td>
                            <td style="border: none; text-align: left;">{{ $record->id_purchase_order }}</td>
                        </tr>
                       
                        <tr>
                            <td style="border: none; width: 150px;">{{ __('Tgl Purchase Order') }}</td>
                            <td style="border: none; width: 10px; text-align: left;">:</td>
                            <td style="border: none; text-align: left;">{{ $record->tgl_purchase_order->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td style="border: none; width: 150px;">{{ __('Tgl Kirim') }}</td>
                            <td style="border: none; width: 10px; text-align: left;">:</td>
                            <td style="border: none; text-align: left;">{{ $record->tgl_kirim->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td style="border: none; width: 150px;">{{ __('Vendor') }}</td>
                            <td style="border: none; width: 10px; text-align: left;">:</td>
                            <td style="border: none; text-align: left;">{{ $record->vendor->name }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <br>
        <div style="page-break-inside: avoid;">
            <div style="text-align:left;">Daftar Aset :</div>
            <br>
            <table class="table-data" width="100%" border="1" style="table-layout: fixed">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 10%;">#</th>
                        <th class="text-center">{{ __('Struktur Aset') }}</th>
                        <th class="text-center">{{ __('Aset') }}</th>
                        <th class="text-center">{{ __('Jumlah') }}</th>
                        <th class="text-center">{{ __('Harga Per Unit') }}</th>
                        <th class="text-center">{{ __('Total Harga') }}</th>
                        {{-- <th class="text-center" style="width: 50%;">{{ __('Lampiran') }}</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @php
                        $finalTotal = array();
                    @endphp
                    @foreach ($record->detail as $detail)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $detail->barang->struktur_aset }}</td>
                        <td>{{ $detail->barang->name }}</td>
                        <td>{{ $detail->jumlah }} Item</td>
                        <td>Rp. {{ $detail->harga_per_unit }}</td>
                        <td>Rp. {{ $detail->total_harga }}</td>
                        @php
                            array_push($finalTotal, str_replace( ',', '', $detail->total_harga )) 
                        @endphp
                        {{-- <td>{{ str_word_count($detail->rangkuman) }} Words</td>
                        <td>
                            <ul>
                                @foreach ($detail->files($module)->where('flag', 'attachments')->get() as $file)
                                <li>
                                    <a href="{{ $file->file_url }}" target="_blank" class="text-primary">
                                        {{ $file->file_name }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </td> --}}
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5">Grand Total</th>
                        <td><b>Rp. {{ number_format(array_sum($finalTotal)) }}</b></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <br>
        <table style="border:none; width:100%; margin-top: 0.5rem;">
            <tr>
                <td style="border:none; width:48%;">
                    <table style="border:none; width:100%;">
                        <tr>
                            <td style="border: none; width: 150px;">{{ __('Catatan') }}</td>
                            <td style="border: none; width: 10px; text-align: justify;">:</td>
                            <td style="border: none; text-align: left;">{{ $record->catatan }}</td>
                        </tr>
                        <tr>
                            <td style="border: none; width: 150px;">{{ __('Lampiran') }}</td>
                            <td style="border: none; width: 10px; text-align: left;">:</td>
                            <td style="border: none; text-align: left;">
                                <ul>
                                    @foreach ($record->files($module)->where('flag', 'attachments')->get() as $file)
                                    <li>
                                        <a href="{{ $file->file_url }}" target="_blank" class="text-primary">
                                            {{ $file->file_name }}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <br>
        @if ($record->approval($module)->exists())
        <div style="page-break-inside: avoid;">
            <div style="text-align: center;">
                {{ config('base.company.name') .", ".now()->translatedFormat('d F Y') }}<br>
                {{ __('Menyetujui') }},
            </div>
            <table style="border:none;">
                <tbody>
                    @php
                    $ids = $record->approval($module)->pluck('id')->toArray();
                    $length = count($ids);
                    @endphp
                    @for ($i = 0; $i < $length; $i +=4) <tr>
                        @if (!empty($ids[$i]))
                        <td style="border: none; text-align: center; width: 33%; vertical-align: bottom;">
                            @if ($approval = $record->approval($module)->find($ids[$i]))
                            @if ($approval->status == 'approved')
                            <div style="height: 110px; padding-top: 15px;">
                                {!! \Base::getQrcode('Approved by: '.$approval->user->name.',
                                '.$approval->approved_at)
                                !!}
                            </div>

                            <div><b><u>{{ $approval->user->name }}</u></b></div>
                            <div>{{ $approval->user->position->name }}</div>
                            @else
                            <div style="height: 110px; padding-top: 15px;; color: #ffffff;">#</div>
                            <div><b><u>(............................)</u></b></div>
                            <div>{{ $approval->role->name }}</div>
                            @endif
                            @endif
                        </td>
                        @endif
                        @if (!empty($ids[$i+1]))
                        <td style="border: none; text-align: center; width: 33%; vertical-align: bottom;">
                            @if ($approval = $record->approval($module)->find($ids[$i+1]))
                            @if ($approval->status == 'approved')
                            <div style="height: 110px; padding-top: 15px;">
                                {!! \Base::getQrcode('Approved by: '.$approval->user->name.',
                                '.$approval->approved_at)
                                !!}
                            </div>

                            <div><b><u>{{ $approval->user->name }}</u></b></div>
                            <div>{{ $approval->user->position->name }}</div>
                            @else
                            <div style="height: 110px; padding-top: 15px;; color: #ffffff;">#</div>
                            <div><b><u>(............................)</u></b></div>
                            <div>{{ $approval->role->name }}</div>
                            @endif
                            @endif
                        </td>
                        @endif
                        @if (!empty($ids[$i+2]))
                        <td style="border: none; text-align: center; width: 33%; vertical-align: bottom;">
                            @if ($approval = $record->approval($module)->find($ids[$i+2]))
                            @if ($approval->status == 'approved')
                            <div style="height: 110px; padding-top: 15px;">
                                {!! \Base::getQrcode('Approved by: '.$approval->user->name.',
                                '.$approval->approved_at)
                                !!}
                            </div>

                            <div><b><u>{{ $approval->user->name }}</u></b></div>
                            <div>{{ $approval->user->position->name }}</div>
                            @else
                            <div style="height: 110px; padding-top: 15px;; color: #ffffff;">#</div>
                            <div><b><u>(............................)</u></b></div>
                            <div>{{ $approval->role->name }}</div>
                            @endif
                            @endif
                        </td>
                        @endif
                        @if (!empty($ids[$i+3]))
                        <td style="border: none; text-align: center; width: 33%; vertical-align: bottom;">
                            @if ($approval = $record->approval($module)->find($ids[$i+3]))
                            @if ($approval->status == 'approved')
                            <div style="height: 110px; padding-top: 15px;">
                                {!! \Base::getQrcode('Approved by: '.$approval->user->name.',
                                '.$approval->approved_at)
                                !!}
                            </div>

                            <div><b><u>{{ $approval->user->name }}</u></b></div>
                            <div>{{ $approval->user->position->name }}</div>
                            @else
                            <div style="height: 110px; padding-top: 15px;; color: #ffffff;">#</div>
                            <div><b><u>(............................)</u></b></div>
                            <div>{{ $approval->role->name }}</div>
                            @endif
                            @endif
                        </td>
                        @endif
                        </tr>
                        @endfor
                </tbody>
            </table>
            <footer>
                <table table width="100%" border="0" style="border: none;">
                    <tr>
                        <td style="width: 10%;border: none;">
                            <small>
                                <i>***Dokumen ini sudah ditandatangani secara elektronik oleh {{ config('base.company.name') }}.</i>
                                <div style="margin-top:-15px;"><i>Tanggal Cetak: {{now()->translatedFormat('d F Y H:i:s')}}</i></div>
                            </small>
                        </td>
                    </tr>
                </table>
            </footer>
        </div>
        @endif
    </main>
</body>

</html>