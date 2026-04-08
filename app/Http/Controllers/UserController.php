<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function follow(Request $request, User $user)
    {
        $authUser = Auth::user();

        if ($authUser->id !== $user->id) {
            $authUser->following()->toggle($user->id);
        }

        return back()->with('success', 'Obserwowanie zaktualizowane!');
    }
}

