<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function __invoke()
    {
        $html = response('Ttt', 200, ["t" => 'a']);
        $json = response()->json(['a' => 'b'], 200, ['k1' => 'v1']);
        return $json;
    }
}
