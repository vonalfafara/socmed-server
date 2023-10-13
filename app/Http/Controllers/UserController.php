<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
   public function getUsers(Request $request) {
      $searchValues = explode(' ', $request->q);

      return UserResource::collection(User::where(function ($q) use ($searchValues) {
         foreach ($searchValues as $value) {
            $q->orWhere('first_name', 'ilike', '%' . $value . '%');
         }
         foreach ($searchValues as $value) {
            $q->orWhere('last_name', 'ilike', '%' . $value . '%');
         }
      })->paginate(10));
   }
}
