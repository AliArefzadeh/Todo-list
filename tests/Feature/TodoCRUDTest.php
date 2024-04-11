<?php

namespace Tests\Feature;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class TodoCRUDTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanCreateTodo()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/active/todo', [
                'tasks' => 'Test Todo',
                'user_id' =>$user->id ,
            ]);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                'message' => 'Todo resource created successfully',
            ]);
    }

    public function testUserCanUpdateTodo()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $todo = Todo::factory()->create(['user_id' => $user->id]);

        $newData = [
            'tasks' => 'Updated Todo Tasks',
        ];
        $response = $this->putJson('/api/active/todo/' . $todo->id, $newData);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Tasks have been updated successfully',
            ]);

        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'tasks' => 'Updated Todo Tasks',
        ]);
    }

    public function testUserCanShowTodoInfo()
    {
        $user = User::factory()->create();

        $todo = Todo::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->getJson('/api/active/todo/' . $todo->id);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'data' => [
                    'id' => $todo->id,
                    'tasks' => $todo->tasks,

                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'email_verified_at' => $user->email_verified_at->toISOString(),

                    ],
                ],
            ]);
    }



    public function testUserCanDeleteTodo()
    {

        $user = User::factory()->create();
        $todo = Todo::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->deleteJson('/api/active/todo/' . $todo->id);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => 'Todo resource deleted successfully',
            ]);

        $this->assertDatabaseMissing('todos', ['id' => $todo->id]);
    }
}
