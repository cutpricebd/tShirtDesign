<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class OrderExport implements FromView
{
    protected $orders;

    function __construct($orders)
    {
        $this->orders = $orders;
    }


    public function collection()
    {
        return $this->orders;
    }

    public function view(): View
    {
        return view('back.report.order.exportExcel')->with('orders', $this->orders);
    }
}
