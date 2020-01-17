<?php

namespace Tests\app\Http\Controllers\API;

use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class MessageControllerTest extends TestCase {
    use DatabaseMigrations;

    public $faker;

    public function testMessage_ShouldStorageMessage() {
        $this->faker = Factory::create();
        $contact_id = $this->buildContactAndReturnId();

        $message_params = [
            'message' => $this->faker->text,
            'contact_id' => $contact_id,
        ];

        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->json('POST', "/api/contact/{$contact_id}/message", $message_params);

        $response->assertStatus(201);
    }

    public function testMessage_ShouldUpdateMessage() {
        $this->faker = Factory::create();
        $contact_id = $this->buildContactAndReturnId();
        $message_id = $this->buildMessageAndReturnId($contact_id);

        $params = ['message' => $this->faker->text];

        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->json('PUT', "/api/contact/{$contact_id}/message/{$message_id}", $params);

        $response->assertStatus(200);

        $message = DB::table('messages')
            ->where('id', $message_id)
            ->first();

        $this->assertEquals($params['message'], $message->message);
    }

    public function testMessage_ShouldDeleteMessage() {
        $this->faker = Factory::create();
        $contact_id = $this->buildContactAndReturnId();
        $message_id = $this->buildMessageAndReturnId($contact_id);

        $params = ['message' => $this->faker->text];

        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->json('DELETE', "/api/contact/{$contact_id}/message/{$message_id}", $params);

        $response->assertStatus(200);

        $message = DB::table('messages')
            ->where('id', $message_id)
            ->first();

        $this->assertNull($message);
    }

    public function testMessage_ShouldReturnMessagesList() {
        $this->faker = Factory::create();
        $contact_id = $this->buildContactAndReturnId();
        $message_id = $this->buildMessageAndReturnId($contact_id);

        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->json('GET', "/api/contact/{$contact_id}/message");

        $message = DB::table('messages')
            ->where('id', $message_id)
            ->first();

        $response->assertStatus(200);
        $response->assertJson([
            ['message' => $message->message],
        ]);

    }

    private function buildContactAndReturnId(): int {
        $contact_params = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
        ];

        return DB::table('contacts')
            ->insertGetId($contact_params);
    }

    private function buildMessageAndReturnId(int $contact_id): int {
        $params = [
            'message' => $this->faker->text,
            'contact_id' => $contact_id,
        ];

        return DB::table('messages')
            ->insertGetId($params);
    }
}
