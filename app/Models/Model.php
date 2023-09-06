<?php

namespace App\Models;

use App\Models\Traits\RaidModel;
use App\Models\Traits\ResponseTrait;
use App\Models\Traits\Utilities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as Base;

class Model extends Base
{
    use HasFactory;
    use RaidModel, Utilities, ResponseTrait;

    const BULAN = [
        '01'    =>  'Januari',
        '02'    =>  'Februari',
        '03'    =>  'Maret',
        '04'    =>  'April',
        '05'    =>  'Mei',
        '06'    =>  'Juni',
        '07'    =>  'Juli',
        '08'    =>  'Agustus',
        '09'    =>  'September',
        '10'    =>  'Oktober',
        '11'    =>  'November',
        '12'    =>  'Desember',
    ];
}
