<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\UpdateOrdersStock;

class GetOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'GetOrders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '抓取所有平台訂單';

    protected $updateOrdersStock;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->updateOrdersStock = app(UpdateOrdersStock::class);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->updateOrdersStock->index();
    }
}
