<?php

namespace Tests\Feature;

use Database\Factories\TodoFactory;
use Database\Factories\UserFactory;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class TodoTest extends TestCase
{

    public function testTodoIndexResponsesHttpUnauthorizedWhenUserIsGuest(): void
    {
        $response = $this->getJson(route("todo.index"));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testTodoIndexResponsesHttpForbiddenWhenUsersEmailIsNotVerified(): void
    {
        $user = UserFactory::new()->unverified()->create();
        $response = $this->actingAs($user)->getJson(route("todo.index"));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testTodoIndexResponsesHttpNotFoundWhenUserHasNoTodos(): void
    {
        $user = UserFactory::new()->create(['email_verified_at' => now()->carbonize()]);
        $this->actingAs($user)->getJson(route("todo.index"))->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function testTodoIndexResponsesHttpOk(): void
    {
        $user = UserFactory::new()->create(['email_verified_at' => now()->carbonize()]);
        TodoFactory::new()->for($user)->createMany(10);
        $this->actingAs($user)->getJson(route('todo.index'))->assertStatus(Response::HTTP_OK);
    }

    public function testTodoIndexResponsesOnlyCurrentUsersTodos(): void
    {
        $user1 = UserFactory::new()->create();
        $user2 = UserFactory::new()->create();

        TodoFactory::new()->for($user1)->createMany(10);
        TodoFactory::new()->for($user2)->createMany(10);
        $response = $this->actingAs($user1)->getJson(route('todo.index'));
        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonCount(10, "data.items");
    }

    public function testTodoStoreResponsesHttpUnauthorizedWhenUserIsGuest(): void
    {
        $response = $this->postJson(route("todo.store"));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testTodoStoreResponsesHttpForbiddenWhenUsersEmailIsNotVerified(): void
    {
        $user = UserFactory::new()->unverified()->create();
        $this->actingAs($user)->postJson(route("todo.store"))->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testTodoStoreResponsesHttpUnprocessableEntityWhenDescriptionIsNotInBody(): void
    {
        $description = "";
        $user = UserFactory::new()->create(["email_verified_at" => now()->carbonize()]);
        $this->actingAs($user)->postJson(route("todo.store"), ["description" => $description])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testTodoStoreResponsesHttpUnprocessableEntityWhenDueDateIsPast(): void
    {
        $description = "some valid description";
        $dueDate = "2002-11-6 00:00:00";

        $user = UserFactory::new()->create(["email_verified_at" => now()->carbonize()]);

        $this->actingAs($user)->postJson(route("todo.store"), ["description" => $description, "due_date" => $dueDate])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testTodoStoreResponsesHttpCreated(): void
    {
        $description = "some valid description";
        $dueDate = now()->addMonth()->carbonize();

        $user = UserFactory::new()->create(["email_verified_at" => now()->carbonize()]);

        $this->actingAs($user)->postJson(route("todo.store"), ["description" => $description, "due_date" => $dueDate])
            ->assertStatus(Response::HTTP_CREATED);
    }

    public function testTodoStoreCreatesTodo(): void
    {
        $description = "some valid description";
        $dueDate = now()->addMonth()->carbonize();

        $user = UserFactory::new()->create(["email_verified_at" => now()->carbonize()]);

        $this->actingAs($user)->postJson(route("todo.store"), ["description" => $description, "due_date" => $dueDate])
            ->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseCount("todos", 1);
    }

    public function testTodoShowResponsesHttpNotFoundWhenTodoDoesNotExist(): void
    {
        $user = UserFactory::new()->create();
        $this->actingAs($user)->getJson(route("todo.show", ["id" => 1]))->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function testTodoShowResponsesHttpForbiddenWhenUsersEmailIsNotVerified(): void
    {
        $user = UserFactory::new()->unverified()->create();
        $this->actingAs($user)->getJson(route("todo.show", ["id" => 1]))->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testTodoShowResponsesHttpUnauthorizedWhenUserIsGuest(): void
    {
        $this->getJson(route("todo.show", ["id" => 1]))->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testTodoShowResponsesHttpForbiddenWhenUserTryingToSeeOtherUsersTodo(): void
    {
        $user1 = UserFactory::new()->create();
        $user2 = UserFactory::new()->create();

        $todo = TodoFactory::new()->for($user1)->create();

        $this->actingAs($user2)->getJson(route("todo.show", ["id" => $todo->id]))->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testTodoShowResponsesHttpOk(): void
    {
        $user = UserFactory::new()->create();

        $todo = TodoFactory::new()->for($user)->create();

        $this->actingAs($user)->getJson(route("todo.show", ["id" => $todo->id]))->assertStatus(Response::HTTP_OK);
    }

    public function testTodoUpdateResponsesHttpUnauthorizedWhenUserIsGuest(): void
    {
        $this->putJson(route("todo.update", ["id" => 1]))->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testTodoUpdateResponsesHttpForbiddenWhenUsersEmailIsNotVerified(): void
    {
        $user = UserFactory::new()->unverified()->create();

        $this->actingAs($user)->putJson(route("todo.update", ["id" => 1]))->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testTodoUpdateResponsesHttpNotFoundWhenTodoDoesNotExist(): void
    {
        $user = UserFactory::new()->create();
        $this->actingAs($user)->putJson(route("todo.update", ["id" => 1]))->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function testTodoUpdateResponsesHttpForbiddenWhenUserIsTryingToUpdateOtherUsersTodo(): void
    {
        $user1 = UserFactory::new()->create();
        $user2 = UserFactory::new()->create();

        $todo = TodoFactory::new()->for($user1)->create();

        $this->actingAs($user2)->putJson(route("todo.update", ["id" => $todo->id]), ["description" => "some edit"])
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testTodoUpdateResponsesHttpAccepted(): void
    {
        $user = UserFactory::new()->create();

        $todo = TodoFactory::new()->for($user)->create();

        $this->actingAs($user)
            ->putJson(route("todo.update", ["id" => $todo->id], ["description" => "some edit", "done" => 1, "category_id" => 1, "due_date" => now()->addMonth()->carbonize()]))
            ->assertStatus(Response::HTTP_ACCEPTED);
    }

    public function testTodoUpdateUpdatesTodo(): void
    {
        $user = UserFactory::new()->create();

        $todo = TodoFactory::new()->for($user)->create();

        $newDescription = "my desc is updated";

        $this->actingAs($user)->putJson(route("todo.update", ["id" => $todo->id, "description" => $newDescription]))
            ->assertStatus(Response::HTTP_ACCEPTED);

        $this->assertDatabaseHas("todos", ["description" => $newDescription, "user_id" => $user->id]);
    }

    public function testTodoDestroyResponsesHttpUnauthorizedWhenUserIsGuest(): void
    {
        $this->deleteJson(route("todo.destroy", ["id" => 1]))->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testTodoDestroyResponsesHttpForbiddenWhenUsersEmailIsNotVerified(): void
    {
        $user = UserFactory::new()->unverified()->create();

        $this->actingAs($user)->deleteJson(route("todo.destroy", ["id" => 1]))->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testTodoDestroyResponsesHttpNotFoundWhenTodoDoesNotExist(): void
    {
        $user = UserFactory::new()->create();

        $this->actingAs($user)->deleteJson(route("todo.destroy", ["id" => 1]))->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function testTodoDestroyResponsesHttpForbiddenWhenUserIsTryingToDestroyOtherUsersTodo(): void
    {
        $user1 = UserFactory::new()->create();
        $user2 = UserFactory::new()->create();

        $todo = TodoFactory::new()->for($user1)->create();

        $this->actingAs($user2)->deleteJson(route("todo.destroy", ["id" => $todo->id]))->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testTodoDestroyResponsesHttpAccepted(): void
    {
        $user = UserFactory::new()->create();

        $todo = TodoFactory::new()->for($user)->create();

        $this->actingAs($user)->deleteJson(route("todo.destroy", ["id" => $todo->id]))->assertStatus(Response::HTTP_ACCEPTED);
    }

    public function testTodoDestroyDestroysTodo(): void
    {
        $user = UserFactory::new()->create();

        $todo = TodoFactory::new()->for($user)->create();

        $this->actingAs($user)->deleteJson(route("todo.destroy", ["id" => $todo->id]))
            ->assertStatus(Response::HTTP_ACCEPTED);

        $this->assertDatabaseMissing("todos", ["id" => $todo->id]);
    }
}
