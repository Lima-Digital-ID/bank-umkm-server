<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\Nasabah;
class NasabahController extends Controller
{
    public function index()
    {
        $allNasabah = Nasabah::get();

        return response()->json([
            'data' => $allNasabah
        ]);
    }
}
