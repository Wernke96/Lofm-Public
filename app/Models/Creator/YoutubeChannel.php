<?php

namespace App\Models\Creator;

use App\Models\Creators;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

/**
 * Class Creators
 * @package App\Models
 * @property $_id
 * @property $creator_id
 * @property $description
 * @property $thumbnail
 * @property $youtube_published_at
 * @property $created_at
 * @property $updated_at
 * @property $delete_at
 *
 * @property-read \App\Models\Creators $creator
 */

class YoutubeChannel extends Model
{
    use SoftDeletes;

    protected $dates =["delete_at"];
    public function creator()
    {
        return $this->belongsTo(Creators::class,"creator_id","_id");
    }



}
