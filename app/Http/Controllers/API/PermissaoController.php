<?php

namespace App\Http\Controllers\API;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PermissaoController extends Controller
{

    public function indexRegras()
    {
        $result = Role::all();
        return response()->json(['data' => $result], 201);
    }

    public function addRegras(Request $request)
    {

        $result = $request->all();
        foreach ($result as $i) {

            DB::table('role_user')->insert([
                'user_id' =>  $i['user_id'],
                'role_id' =>  $i['role_id']
            ]);
        }


        return response()->json(['data' => 'ok'], 201);
    }

    public function addPermissao(Request $request)
    {
        $result = $request->all();
        foreach ($result as $i) {
            DB::table('permission_role')->insert([
                'permission_id' =>  $i['permission_id'],
                'role_id' =>  $i['role_id']
            ]);
        }
        return response()->json(['data' => 'ok'], 201);
    }

    public function indexPermissao()
    {
        $result = Permission::all();
        return response()->json(['data' => $result], 201);
    }

}
