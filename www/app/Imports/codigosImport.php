<?php

namespace App\Imports;

use App\Models\excel_listados_codigos;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;

class codigosImport implements ToModel, WithMultipleSheets
{
    use WithConditionalSheets;

    var $excel_listados = 0;
    private $fila_numero = 0;

    public function __construct($id) {
        $this->excel_listados=$id;
    }

    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }
    public function conditionalSheets(): array
    {
        return [
            //'Worksheet 1' => new FirstSheetImport(),
            //'Worksheet 2' => new SecondSheetImport(),
            //'Worksheet 3' => new ThirdSheetImport(),
            0 => new FirstSheetImport(),
        ];
    }


    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $codigo=$row[0];
        $codigo=trim($codigo);
        $codigo=mb_strtoupper($codigo);
        $codigo=str_replace(" ","",$codigo);
        return new excel_listados_codigos([
            'codigo'     => $codigo,
            'id_excel_listados'     => $this->excel_listados,
            'fila' => ++$this->fila_numero

        ]);
    }
}
