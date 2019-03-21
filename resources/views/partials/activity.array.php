<?php

$this->set('type', 'Activity');
$this->set('id', $activity->id);
$this->set('attributes', function ($section) use ($activity) {
    $section->extract($activity, [
        'id',
        'actor',
        'actor_type',
        'object',
        'object_type',
        'target',
        'target_type',
        'meta',
        'published',
        'content',
        'summary',
    ]);
});
