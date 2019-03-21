<?php

namespace Bean\Activity\Traits;

trait Activitiable
{
    public function toObject(...$fields) {
        $object = new static;
        foreach ($fields as $field) {
            $object->$field = $this->$field;
        }
        return $object;
    }

    public function objectActivities()
    {
        return $this->hasMany('Bean\Activity\Models\Activity', 'object_id')
            ->where('object_type', get_class_name($this))
            ->orderBy('id', 'DESC');
    }
}
