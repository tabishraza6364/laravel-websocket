<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendMessageRequest;

class MessageController extends Controller
{
    public function send(SendMessageRequest $request)
    {
        try {
            event(new \App\Events\SendMessage($request->get('message')));
            return redirect()->back();
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }
}
