<?php

namespace App\Http\Controllers;

use App\Actions\Users\DeleteUser;
use App\Actions\Users\GetUsers;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(GetUsers $action)
    {
        $this->authorize('viewAny', User::class);

        return Inertia::render('users/Index')->with([
            'users' => $action->handle(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, DeleteUser $action)
    {
        $action->handle($user);

        return redirect()->back()->with('status', 'User deleted successfully.');
    }
}
