<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserStatusController extends Controller
{
    public function update(User $user)
    {
       $user->update(['status_id'=>2]);

       return redirect()->route('users.index')->with('status','Status updated!');
    }
}
