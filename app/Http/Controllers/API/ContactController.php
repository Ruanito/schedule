<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Schedule\Contact\ContactService;
use Schedule\Contact\Exception\ContactException;

class ContactController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $id = ContactService::create($request->all());
            $response = response(['id' => $id], 201);
        } catch (ContactException $e) {
            $response = response(['message' => $e->getMessage()], 400);
        }

        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response(['status' => 'success'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            ContactService::update($request->all(), $id);
            $response = response([], 200);
        } catch (ContactException $e) {
            $response = response(['message' => $e->getMessage()], 400);
        }

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            ContactService::delete($id);
            $response = response([], 200);
        } catch (ContactException $e) {
            $response = response(['message' => $e->getMessage()], 400);
        }

        return $response;
    }
}
