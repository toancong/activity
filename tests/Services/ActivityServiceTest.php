<?php

namespace Bean\Activity\Tests\Services;

use \Bean\Activity\Tests\TestCase;

class ActivityServiceTest extends TestCase
{
    public function testBrowseActivity()
    {
        factory(\Bean\Activity\Models\Activity::class, 15)->create(['type' => 'favorite']);
        factory(\Bean\Activity\Models\Activity::class, 15)->create(['type' => 'apply']);
        $filter = [
            'type' => 'favorite'
        ];
        $actitivies = app('activity')->browse($filter);
        $this->assertEquals(10, $actitivies->count());

        $filter = [
            'type' => 'favorite',
            'page' => [
                'number' => 2,
            ]
        ];
        $actitivies = app('activity')->browse($filter);
        $this->assertEquals(5, $actitivies->count());

        $filter = [
            'type' => 'favorite',
            'page' => [
                'number' => 3,
            ]
        ];
        $actitivies = app('activity')->browse($filter);
        $this->assertEquals(0, $actitivies->count());

        $filter = [
            'type' => 'favorite',
            'page' => [
                'size' => 20,
            ]
        ];
        $actitivies = app('activity')->browse($filter);
        $this->assertEquals(15, $actitivies->count());

        $filter = [
            'type' => 'favorite',
            'page' => [
                'size' => 20,
                'number' => 1,
            ]
        ];
        $actitivies = app('activity')->browse($filter);
        $this->assertEquals(15, $actitivies->count());

        $filter = [
            'type' => 'favorite',
            'page' => [
                'size' => 20,
                'number' => 3,
            ]
        ];
        $actitivies = app('activity')->browse($filter);
        $this->assertEquals(0, $actitivies->count());
    }

    public function testAddActivity()
    {
        $user = (object)[
            'id' => 2,
            'email' => 'user@example.com',
        ];
        $product = (object)[
            'id' => 3,
            'name' => 'Name Product',
        ];
        $activity = app('activity')->add($user, 'favorite', $product);
        $this->assertNotNull($activity);
        $activity = app('activity')->read($user, 'favorite', $product);
        $this->assertNotNull($activity);

        $this->assertGreaterThanOrEqual(1, $activity->id);
        $this->assertEquals((array)$user, $activity->actor);
        $this->assertEquals(2, $activity->actor_id);
        $this->assertEquals('stdClass', $activity->actor_type);
        $this->assertEquals('favorite', $activity->type);
        $this->assertEquals((array)$product, $activity->object);
        $this->assertEquals(3, $activity->object_id);
        $this->assertEquals('stdClass', $activity->object_type);
        $this->assertInstanceOf(\DateTime::class, \DateTime::createFromFormat('Y-m-d H:i:s', $activity->published));
        $this->assertInstanceOf(\DateTime::class, \DateTime::createFromFormat('Y-m-d H:i:s', $activity->created_at));
        $this->assertInstanceOf(\DateTime::class, \DateTime::createFromFormat('Y-m-d H:i:s', $activity->updated_at));
        $this->assertNotInstanceOf(\DateTime::class, \DateTime::createFromFormat('Y-m-d H:i:s', $activity->id));
        $this->assertDatabaseHas('activities', ['id' => $activity->id]);
    }

    /**
     * @expectedException     \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testDeleteActivity()
    {
        $user = (object)[
            'id' => 2,
            'email' => 'user@example.com',
        ];
        $product = (object)[
            'id' => 3,
            'name' => 'Name Product',
        ];
        $activity = app('activity')->add($user, 'favorite', $product);
        $this->assertNotNull($activity);

        app('activity')->delete($user, 'favorite', $product);

        try {
            app('activity')->read($user, 'favorite', $product);
        } catch (\Exception $e) {
            $this->assertDatabaseMissing('activities', ['id' => $activity->id]);
            throw $e;
        }
    }

    public function testReAddActivity()
    {
        $user = (object)[
            'id' => 2,
            'email' => 'user@example.com',
        ];
        $product = (object)[
            'id' => 3,
            'name' => 'Name Product',
        ];
        app('activity')->add($user, 'favorite', $product);
        $one = app('activity')->read($user, 'favorite', $product);
        $this->assertNotNull($one);

        $two = app('activity')->add($user, 'favorite', $product);
        $this->assertNotNull($two);
        $this->assertNotEquals($one->id, $two->id);
    }

    public function testEditActivity()
    {
        $user = (object)[
            'id' => 2,
            'email' => 'user@example.com',
        ];
        $product = (object)[
            'id' => 3,
            'name' => 'Name Product',
        ];
        app('activity')->add($user, 'favorite', $product);
        $one = app('activity')->read($user, 'favorite', $product);
        $this->assertNotNull($one);

        $meta = (object)[
            'order' => 10,
        ];
        $two = app('activity')->edit($user, 'favorite', $product, null, $meta);
        $this->assertNotNull($two);
        $this->assertEquals($one->id, $two->id);
        $this->assertNotEquals($one->toArray(), $two->toArray());
        $this->assertEquals((array)$meta, (array)$two->meta);
    }
}
