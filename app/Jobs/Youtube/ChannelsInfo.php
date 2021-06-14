<?php

namespace App\Jobs\Youtube;

use App\Api\Models\Youtube;
use App\Models\Creators;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Models\Creator\YoutubeChannel as YouTubeChannelModel;
use Google_Service_YouTube_Channel;

class ChannelsInfo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;
    protected $youtube;
    /**
     * Create a new job instance.
     *
     * @param Youtube $youtube
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $youtube = new Youtube();
        $creators = Creators::query()->doesntHave("youtube")->get();
        Log::info(print_r($creators->toArray(),true));
        /** @var Creators $creator */
        foreach ($creators as $creator) {
            Log::info(print_r($creator->youtubeChannel,true));
            Log::info(print_r($creator->creatorName, true));
            $channel = ["id" => $creator->youtubeChannelId];
            $youtubeRepsone = $youtube->getThumbnail($channel);
            $youtubeModel = new YouTubeChannelModel();
            $youtubeModel->creator_id =  $creator->_id;
                /** @var Google_Service_YouTube_Channel $item */
            foreach ($youtubeRepsone->getItems() as $item)
                $youtubeModel->description = $item
                    ->getSnippet()
                    ->getDescription();
                $youtubeModel->youtube_published_at = $item
                    ->getSnippet()
                    ->getPublishedAt();
                $youtubeModel->thumbnail = $item
                    ->getSnippet()
                    ->getThumbnails()
                    ->getDefault()->getUrl();
                $youtubeModel->save();

            }



    }
}
