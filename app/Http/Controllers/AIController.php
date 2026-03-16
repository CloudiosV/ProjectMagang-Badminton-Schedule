<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AIController extends Controller
{
    public function chat(Request $request)
    {
        $msg = $request->message;

        try {

            $ai = (new \App\Ai\Agents\SupportAgent)
                ->prompt($msg);

            return response()->json([
                'text' => $ai->text
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'text' => 'AI is having an error'
            ]);
        }
    }
}