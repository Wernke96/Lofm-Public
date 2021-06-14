<?php


namespace App\Lofm\Exceptions;

use Illuminate\Http\Response;

class UnauthorizedExecption extends \Exception
{
    public function render($request)
    {
        return response()->json(["error" => $this->message ],Response::HTTP_UNAUTHORIZED);
    }
}
