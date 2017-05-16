<?php
/**
 * Created by PhpStorm.
 * User: Miha
 * Date: 12-May-17
 * Time: 22:04
 */

namespace App\Traits;

use App\Activity;


trait RecordsActivity
{

    protected static function bootRecordsActivity()
    {
        // when event occurs on object, also create activity for it
        if(auth()->guest()) return;

            foreach (static::getEventsForRecord() as $event){
                static::$event(function ($model) use ($event) {
                    $model->recordActivity($event);
                });
            }

        //on thread delete, also delete activity created for it
        static::deleting(function ($model){
            $model->activity()->delete();
        });

    }

    /**
     * Events that are being recorded
     * @return array
     */
    protected static function getEventsForRecord()
    {
        return ['created'];
    }

    protected function recordActivity($event)
    {
        Activity::create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event),
            'subject_id' => $this->id,
            'subject_type' => get_class($this)
        ]);
    }

    /**
     * Fetch the activity relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function activity()
    {
        return $this->morphMany('App\Activity', 'subject');
    }

    protected function getActivityType($event)
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());
        return $event . "_" . $type;
    }
}