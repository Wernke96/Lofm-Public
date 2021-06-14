<?php

namespace App\Console\Commands\Youtube;

use App\Api\Models\Youtube;
use App\Jobs\Youtube\ChannelsInfo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Scheduling\Schedule;

class ChannelContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lofm:youtube:get:channels';

    /**
     * The console command description.
     *
     * @var string
     */
    public static function schedule(Schedule $schedule) :void
    {
        try{
            $schedule->call(function () {
               Artisan::call("lofm:youtube:get:channels");
            })->cron("10 0 */1 * *")
                ->description("Lofm youtube channel cron")
                ->withoutOverlapping();
        } catch (\Exception $e) {
            Log::info("something wrong with the cron",[
                "code" => $e->getCode(),
                "message" => $e->getMessage()
            ]);
        }
    }

    protected $description = 'This command start the schedule job for all content creator';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ChannelsInfo::dispatch();
    }
}
