<?php


namespace App\Lofm\Exceptions;


use Illuminate\Http\Response;

class UserErrorException extends \Exception
{
    public function render($request)
    {
        return response()->json(["error" => $this->message ],Response::HTTP_CONFLICT);
    }
}
