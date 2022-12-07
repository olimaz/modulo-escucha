<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class spssExport implements FromView, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //return exilio::all();
    }

    public function view(): View
    {
        return view('spss.show',
            ['info'=>\App\Models\excel_spss::calcular_datos()]);
    }
    public function title(): string
    {

        return date("Y-m-d H_i");
    }


}
