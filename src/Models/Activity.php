<?php

namespace Bean\Activity\Models;

class Activity extends \PhpSoft\Base\Models\BaseModel
{
    public $fillable = [
        'actor', 'actor_id', 'actor_type', 'type', 'object', 'object_id', 'object_type',
        'target', 'target_id', 'target_type', 'meta', 'content', 'summary',
    ];

    protected $casts = [
        'id' => 'string',
        'actor' => 'array',
        'object' => 'array',
        'target' => 'array',
        'meta' => 'array',
    ];

    public function scopeOfActor($query, $actor_id, $actor_type = 'User')
    {
        $query->where('actor_type', $actor_type);
        $actor_id && $query->where('actor_id', $actor_id);
        return $query;
    }

    public function scopeOfObject($query, $object_id, $object_type)
    {
        $query->where('object_type', $object_type);
        $object_id && $query->where('object_id', $object_id);
        return $query;
    }

    public function scopeOfTypes($query, $types)
    {
        return $query
            ->whereIn('type', $types);
    }
}
