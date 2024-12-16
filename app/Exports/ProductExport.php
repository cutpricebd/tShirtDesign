<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

// use Maatwebsite\Excel\Concerns\FromCollection;

class ProductExport implements FromView
{
    protected $products;
    protected $from_date;
    protected $to_date;

    function __construct($products, $from_date, $to_date)
    {
       $this->products = $products;
       $this->from_date = $from_date;
       $this->to_date = $to_date;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->products;
    }

    public function view(): View
    {
        return view('back.report.product.exportExcel')->with([
            'products' => $this->products,
            'from_date' => $this->from_date,
            'to_date' => $this->to_date,
        ]);
    }
}
