<?php

namespace App\Traits;

Trait ApiResponses{

    protected function success(array $data = [], string $successMessage = Null, string $message = "Called API successfully.", int $code = 200)
    {
        return response()
                ->json([
                    "status_code"    =>  $code,
                    "message"   =>  $message,
                    "status"    =>  $successMessage,
                    "data"      =>  $data
                ], $code);
    }

    protected function error(string $error, int $code = 400, array $data = [], string $message = "Called API successfully.")
    {
        return response()
                ->json([
                    "status_code"    =>  $code,
                    "message"   =>  $message,
                    "status"    =>  $error,
                    "data"      =>  $data
                ], $code);
    }
}