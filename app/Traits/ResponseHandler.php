<?php

namespace App\Traits;

trait ResponseHandler
{
    public function buildSuccess($status, $data, $display_message, $code)
    {
        return response()->json([
            'errors' => [], 
            'data' => $data, 
            'message' => $display_message
        ]);
    }

    public function buildUnSuccessful($status, $data, $display_message, $code, $error=NULL)
	{
		return response()->json([
			'errors' => [$error],
			'data' => $data,
			'message' => $display_message
		], $code);
	}
}
