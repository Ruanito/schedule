<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Schedule\Message\Exception\MessageException;
use Schedule\Message\MessageService;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param int $contact_id
     * @return \Illuminate\Http\Response
     */
    public function index($contact_id)
    {
        try {
            $messages = MessageService::listMessages($contact_id);
            $response = response($messages, 200);
        } catch (MessageException $e) {
            $response = response(['message' => $e->getMessage()], 400);
        }

        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int $contact_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $contact_id)
    {
        try {
            $message_id = MessageService::create($request->all(), $contact_id);
            $response = response(['id' => $message_id], 201);
        } catch (MessageException $e) {
            $response = response(['message' => $e->getMessage()], 400);
        }

        return $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $contact_id
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $contact_id, int $id)
    {
        try {
            MessageService::update($request->all(), $contact_id, $id);
            $response = response([], 200);
        } catch (MessageException $e) {
            $response = response(['message' => $e->getMessage()], 400);
        }

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $contact_id
     * @param  int  $int
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $contact_id, int $id)
    {
        try {
            MessageService::delete($contact_id, $id);
            $response = response([], 200);
        } catch (MessageException $e) {
            dd($e->getMessage());
            $response = response(['message' => $e->getMessage()], 400);
        }

        return $response;
    }
}
