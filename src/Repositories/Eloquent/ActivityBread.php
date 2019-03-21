<?php

namespace Bean\Activity\Repositories\Eloquent;

use PhpSoft\Base\Repositories\Eloquent\BreadRepository;
use Bean\Activity\Repositories\Contracts\ActivityBreadInterface;

class ActivityBread extends BreadRepository implements ActivityBreadInterface
{
    public function getModel()
    {
        return \Bean\Activity\Models\Activity::class;
    }

    public function parseData($data, $isEdit = false)
    {
        extract($data);
        $data = [];
        if ($actor) {
            $data['actor'] = $actor;
            $data['actor_id'] = $actor->id;
            $data['actor_type'] = $actor->object_type ?? get_class_name($actor);
        }
        if ($object) {
            $data['object'] = $object;
            $data['object_id'] = $object->id;
            $data['object_type'] = $object->object_type ?? get_class_name($object);
        }
        if ($type) {
            $data['type'] = $type;
        }
        if ($target ?? null) {
            $data['target'] = $target;
            $data['target_id'] = $target->id;
            $data['target_type'] = $target->target_type ?? get_class_name($target);
        } else {
            $data['target'] = null;
        }
        if ($meta ?? null) {
            $data['meta'] = $meta;
        } else {
            $data['meta'] = null;
        }
        $data['content'] = $content ?? null;
        $data['summary'] = $summary ?? null;

        return $data;
    }
}
