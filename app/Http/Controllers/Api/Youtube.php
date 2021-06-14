<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CreatorCollection;
use App\Models\Creators;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use App\Api\Models\Youtube as YoutubeApi;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request as GETRequest;
use MongoDB\BSON\ObjectId;
use Psr\Log\LoggerInterface;

class Youtube extends Controller
{
    /**
     * @var YoutubeApi
     */
    private $youtube;

    private $logger;

    public function __construct(\App\Api\Models\Youtube $youtube, LoggerInterface $logger)
    {
        $this->youtube = $youtube;
        $this->logger = $logger;

    }

    public function getCreators(Request $request)
    {
        /** @var Creators $creator */
        $creator = Creators::query();

        if ($request->query("name")) {
            $creator->where(
                "creatorName",
                "like",
                "%{$request->query("name")}%"
            );
        }
        $reponse = $creator->simplePaginate(10);
        return new CreatorCollection($reponse);

    }

    public function getVideos($creatorId, Request $request)
    {
        $results = [];
        /** @var Creators $creator */
        $creator = Creators::find((string)$creatorId);
        if ($request->query("pageToken")) {
            $results = $this->youtube->getVideos($creator->youtubeChannelId, $request->query("pageToken"));
        } else {
            $results = $this->youtube->getVideos($creator->youtubeChannelId);
        }
        return response()
            ->json(["data" => $results],Response::HTTP_OK)
            ->header("Content-Type","application/json");
    }
}
