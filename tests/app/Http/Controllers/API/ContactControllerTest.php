<?php

namespace Tests\app\Http\Controllers\API;

use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ContactControllerTest extends TestCase {
    use DatabaseMigrations;

    public function test_ShouldSaveContact() {
        $faker = Factory::create();

        $params = [
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => $faker->email,
            'phone' => $faker->phoneNumber,
        ];

        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->json('POST', '/api/contact', $params);

        $response->assertStatus(201);
    }

    public function test_ShouldUpdateContact() {
        $faker = Factory::create();

        $params = [
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => $faker->email,
            'phone' => $faker->phoneNumber,
        ];

        $id = DB::table('contacts')
            ->insertGetId($params);

        $param_update = [
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'phone' => $faker->phoneNumber,
        ];

        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->json('PUT', '/api/contact/' . $id, $param_update);

        $response->assertStatus(200);

        $contact = DB::table('contacts')
            ->where('id', $id)
            ->first();

        $this->assertEquals($param_update['first_name'], $contact->first_name);
        $this->assertEquals($param_update['last_name'], $contact->last_name);
        $this->assertEquals($param_update['phone'], $contact->phone);

    }

    public function test_ShouldDestroyContact() {
        $faker = Factory::create();

        $params = [
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => $faker->email,
            'phone' => $faker->phoneNumber,
        ];

        $id = DB::table('contacts')
            ->insertGetId($params);

        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->json('DELETE', '/api/contact/' . $id);

        $response->assertStatus(200);

        $contact = DB::table('contacts')
            ->where('id', $id)
            ->first();

        $this->assertNull($contact);
    }

    public function testContact_ShouldDeleteContactAndMessages() {
        $faker = Factory::create();

        $params = [
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => $faker->email,
            'phone' => $faker->phoneNumber,
        ];

        $id = DB::table('contacts')
            ->insertGetId($params);

        $params_message = [
            'message' => $faker->text,
            'contact_id' => $id,
        ];

        $message_id = DB::table('messages')
            ->insertGetId($params_message);

        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->json('DELETE', '/api/contact/' . $id);

        $response->assertStatus(200);

        $contact = DB::table('contacts')
            ->where('id', $id)
            ->first();
        $message = DB::table('messages')
            ->where('id', $message_id)
            ->first();

        $this->assertNull($contact);
        $this->assertNull($message);
    }
}
