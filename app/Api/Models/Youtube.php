<?php


namespace App\Api\Models;
use App\Models\Creators;
use Google_Client;
use Illuminate\Support\Facades\Log;

class Youtube
{
    protected $client;
    protected $service;

    public function __construct()
    {
        $this->client = new Google_Client();
        Log::info(env("YOUTUBE_API"));
        $this->client->setScopes(['https://www.googleapis.com/auth/youtube.readonly']);
        $this->client->setDeveloperKey(env("YOUTUBE_API"));
        $this->service = new \Google_Service_YouTube($this->client);

    }

    public function getThumbnail(array $channelId)
    {
        return $this->
        service->
        channels->
        listChannels("snippet",$channelId);
    }

    public function getVideos(string $channelId, ?string $pageToken = null)
    {
        Log::info($channelId);
        $query = [];
        $query["channelId"] = $channelId;
        if ($pageToken){
            $query["pageToken"] = $pageToken;
        }
        return $this->service->playlists->listPlaylists('player,status', $query);
    }



}
