<?php
namespace App\Http\Controllers\API;

use App\Models\Bancos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BancosController extends Controller
{
    public function index()
    {
        $result = Bancos::all();

        return response()->json(['data' => $result], 201);
    }
}
