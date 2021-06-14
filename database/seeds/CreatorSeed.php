<?php

use Illuminate\Database\Seeder;
use App\Models\Creators;
class CreatorSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $channels = [
            [
                "channelsName"=> "The Bootleg Boy",
            "youtubeChannelsID"=> "UC0fiLCwTmAukotCXYnqfj0A"
            ],
            [
                "channelsName"=> "STEEZYASFUCK",
                "youtubeChannelsID"=> "UCsIg9WMfxjZZvwROleiVsQg"
            ],
            [
                "channelsName"=> "Rare",
                "youtubeChannelsID"=> "UC8d8GkPcfQGa8lWAnqhElWg"
            ],
        ];
        foreach($channels as $channel){
            $creator = new Creators();
            $creator->youtubeChannelId = $channel["youtubeChannelsID"];
            $creator->creatorName = $channel["channelsName"];
            $creator->save();
        }
    }
}
