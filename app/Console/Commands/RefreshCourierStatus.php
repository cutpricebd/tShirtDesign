<?php

namespace App\Console\Commands;

use App\Jobs\UpdateCourierStatusJob;
use App\Models\Order\Order;
use Illuminate\Console\Command;

class RefreshCourierStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'courier:refresh-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Submitted Courier Status.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orders = Order::whereIn('status', ['In Courier'])->where('courier_invoice', '!=', null)->where('courier_submitted_at', '<=', now()->subHour(12))->get();

        foreach($orders as $order){
            UpdateCourierStatusJob::dispatch($order->id);
        }

        $this->info('Courier Refreshed success!');
    }
}
