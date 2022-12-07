<?php

namespace App\Exports;

use App\exilio;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class exilioExport implements FromView, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return exilio::all();
    }

    public function view(): View
    {
        return view('exilios.excel',
            ['info'=>\App\Models\exilio::exportar_excel()]);

        ;
    }
    public function title(): string
    {

        return date("Y-m-d H_i");
    }
}
