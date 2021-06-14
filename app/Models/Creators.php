<?php

namespace App\Models;

use App\Models\Creator\YoutubeChannel;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

/**
 * Class Creators
 * @package App\Models
 * @property $id
 * @property $creatorName
 * @property $youtubeChannelId
 * @property $spotifyId
 * @property $created_at
 * @property $updated_at
 * @property $delete_at
 *
 * @property-read \App\Models\Creator\YoutubeChannel $youtubeChannel
 */

class Creators extends Model
{
    use SoftDeletes;
    protected $fillable = [
        "creatorName",
        "youtubeChannelId",
        "spotifyId"
    ];
    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at',
        ];
    protected $collection = "creators";
    protected $primaryKey = "_id";

    public function youtube()
    {
        return $this->hasOne(YoutubeChannel::class,"creator_id");
    }

}
