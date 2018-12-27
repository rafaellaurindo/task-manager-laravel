<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TasksTest extends TestCase
{
    use DatabaseMigrations;

    private $TASKS_API_ENDPOINT = '/api/v1/tasks';

    /**
     * Test listing of tasks
     */
    public function testListingOfTasks()
    {
        $data = factory(\App\Task::class, 5)->create();

        $response = $this->get($this->TASKS_API_ENDPOINT);
        $response->assertStatus(200)
            ->assertJson([
                'data'  =>  $data->toArray(),
                'total' =>  5
            ]);
    }

    /**
     * Test view a task that exists in the storage
     */
    public function testViewATaskThatExistsInTheStorage()
    {
        $data = factory(\App\Task::class)->create();

        $response = $this->get("{$this->TASKS_API_ENDPOINT}/{$data->id}");
        $response->assertStatus(200)
            ->assertJson($data->toArray());
    }

    /**
     * Test view a task that not exists in the storage
     */
    public function testViewATaskThatNotExistsInTheStorage()
    {

        $response = $this->get($this->TASKS_API_ENDPOINT . '999');
        $response->assertStatus(404)
            ->assertJson([
                'error' =>  'true'
            ]);
    }

    /**
     * Test create one task with all attributes valid
     */
    public function testCreateOneTaskWithAllAttributesValid()
    {
        $data = factory(\App\Task::class)->make();

        $response = $this->post($this->TASKS_API_ENDPOINT, $data->toArray());
        $response->assertStatus(201)
            ->assertJson($data->toArray());
    }

    /**
     * Test create one task without priority attribute
     */
    public function testCreateOneTaskWithoutPriorityAttribute()
    {
        $data = factory(\App\Task::class)->make([
            'priority'  => null
        ]);

        $response = $this->post($this->TASKS_API_ENDPOINT, $data->toArray());
        $response->assertStatus(400)
            ->assertJson([
                'error'     =>  'true',
                'message'   => [
                    'priority' => [
                        'The priority field is required.'
                    ]
                ]
            ]);
    }

    /**
     * Test create one task without term attribute invalid
     */
    public function testCreateOneTaskWithTermAttributeInvalid()
    {
        $data = factory(\App\Task::class)->make([
            'term'  =>  '2018-8-20 20:20:55'
        ]);

        $response = $this->post($this->TASKS_API_ENDPOINT, $data->toArray());
        $response->assertStatus(400)
            ->assertJson([
                'error'     =>  'true',
                'message'   => [
                    "term"  => [
                        "The term does not match the format Y-m-d H:i:s."
                    ]
                ]
            ]);
    }

    /**
     * Test update a task with all attributes valid
     */
    public function testUpdateATaskWithAllAttributesValid()
    {
        $data = factory(\App\Task::class)->create();
        $data['name'] = 'Alterar nome do projeto.';

        $response = $this->put("{$this->TASKS_API_ENDPOINT}/{$data->id}", $data->toArray());
        $response->assertStatus(202)
            ->assertJson($data->toArray());
    }

    /**
     * Test update attribute is_completed of one task
     */
    public function testUpdateAttributeIsCompletedOfOneTask()
    {
        $data = factory(\App\Task::class)->create([
            'is_completed'  =>  1
        ]);

        $data['is_completed'] = 0;

        $response = $this->put("{$this->TASKS_API_ENDPOINT}/{$data->id}", $data->toArray());
        $response->assertStatus(202)
            ->assertJson($data->toArray());
    }

    /**
     * Test update attribute is_completed of one task
     */
    public function testUpdateOneWithPriorityAttributeInvalid()
    {
        $data = factory(\App\Task::class)->create();

        $data['priority'] = 'Dangerous';

        $response = $this->put("{$this->TASKS_API_ENDPOINT}/{$data->id}", $data->toArray());
        $response->assertStatus(400)
            ->assertJson([
                'error' =>  'true',
                'message'   =>  [
                    'priority'  =>  [
                        'The selected priority is invalid.'
                    ]
                ]
            ]);
    }

    /**
     * Test delete of one task that exists in the storage
     */
    public function testDeleteOfOneTaskThatExistsInTheStorage()
    {
        $data = factory(\App\Task::class)->create();

        $response = $this->delete("{$this->TASKS_API_ENDPOINT}/{$data->id}");
        $response->assertStatus(204);
    }

    /**
     * Test delete of one task that not exists in the storage
     */
    public function testDeleteOfOneTaskThatNotExistsInTheStorage()
    {

        $response = $this->delete( $this->TASKS_API_ENDPOINT . '999');
        $response->assertStatus(404)
            ->assertJson([
                'error' =>  'true'
            ]);
    }

}
