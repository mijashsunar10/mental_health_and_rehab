<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;

class VerifyOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:verify-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    
    public function handle()
{
    $orders = Order::where('status', 'completed')->get();
    
    $this->table(
        ['ID', 'Customer', 'Package', 'Amount', 'Status', 'Created'],
        $orders->map(function ($order) {
            return [
                $order->id,
                $order->customer_name,
                $order->package->title,
                '$'.number_format($order->amount, 2),
                $order->status,
                $order->created_at->format('Y-m-d')
            ];
        })->toArray()
    );
    
    $this->info("Total completed orders: ".$orders->count());
}
}
