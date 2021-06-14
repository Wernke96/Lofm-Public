<?php

namespace App\Http\Resources;

use App\Models\Creators;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class Creator extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Creators $creator */
        $creator = $this;
        $youtube = $creator->youtube()->first();
        Log::info(print_r($youtube,true));
        $result = [
            "id" => $creator->id,
            "creator_name" => $creator->creatorName,
            "thumbnail" => $creator->youtube->thumbnail,
            "youtube_description" => $creator->youtube->description
        ];

        return $result;
    }
}
