<?php

namespace Bean\Activity\Services;

use Bean\Activity\Models\Activity;
use Bean\Activity\Repositories\Contracts\ActivityBreadInterface;

class ActivityService
{
    public $bread;

    public function __construct(ActivityBreadInterface $bread)
    {
        $this->bread = $bread;
    }

    public function browse($filter = [])
    {
        $activities = $this->bread->browse($filter);
        return $activities;
    }

    public function read($actor, $type, $object, $target = null)
    {
        $activity = $this->bread->read(null, [
            'actor_id' => $actor->id,
            'actor_type' => $actor->object_type ?? get_class_name($actor),
            'type' => $type,
            'object_id' => $object->id,
            'object_type' => $object->object_type ?? get_class_name($object),
        ]);
        return $activity;
    }

    public function add($actor, $type, $object, $target = null, $meta = null)
    {
        $activity = $this->bread->add(compact('actor', 'type', 'object', 'target', 'meta'));
        return $activity;
    }

    public function edit($actor, $type, $object, $target = null, $meta = null)
    {
        $activity = $this->read($actor, $type, $object);
        $activity = $activity
                    ? $this->bread->edit($activity->id, compact('actor', 'type', 'object', 'target', 'meta'))
                    : $this->bread->add(compact('actor', 'type', 'object', 'target', 'meta'));
        return $activity;
    }

    public function update($filter, $data)
    {
        return $this->bread->update($filter, $data);
    }

    public function delete($actor, $type, $object)
    {
        $activity = $this->read($actor, $type, $object);
        return $activity && $this->bread->delete($activity->id);
    }

    public function create(array $data) {
        return $this->bread->add($data);
    }
}
