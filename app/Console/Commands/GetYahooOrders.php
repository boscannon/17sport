<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\YahooService;

class GetYahooOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'GetYahooOrders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '抓取yahoo訂單';

    protected $yahooService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->yahooService = app(YahooService::class);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->yahooService->getOrders();
    }
}
