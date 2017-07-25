<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = ['id'];

    public function threads()
    {
        return $this->belongsToMany('App\Thread');
    }

    public function getRouteKeyName()
    {
        return 'name';
    }

    public static function createTags($arrayOfTags)
    {

        $items = explode(',', $arrayOfTags);
        $listOfTags = array();

        foreach($items as $item)
        {
            $tag = (\App\Tag::firstOrCreate(['name' => strtolower(trim($item))]));
            $listOfTags[] = $tag->id;
        }
        return $listOfTags;

    }

    /**
     * Returns popular tags, limit to 10
     * @return mixed
     */
    public static function getPopularTags()
    {
        return static::has('threads')
            ->withCount('threads')
            ->orderBy('threads_count')
            ->limit(15)
            ->get();
    }

    /**
     * Transforming tags to json for JQCloud plugin
     * @param $tags
     * @return array
     */
    public static function toCloudArray($tags)
    {
        $cloud = array();
        foreach ($tags as $key=>$tag)
        {
            $cloud[] = [
                'text' => $tag->name,
                'weight' => $key / 0.5,
                'link' => '/threads?tag='.$tag->name
            ];
        }
        return json_encode($cloud);
    }
}
