<?php


namespace Modules\Finance\Http\Controllers\Receipt\Import;


use Maatwebsite\Excel\Concerns\FromArray;

class ErrorDataExport implements FromArray
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }
}
