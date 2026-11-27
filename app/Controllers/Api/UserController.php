<?php
namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\User;
use Core\Http\Response;

class UserController extends BaseController {
    public function index(): Response {
        $users = array_map(
            static fn(User $user): array => $user->toArray(),
            User::latest(50)
        );

        return $this->ok($users);
    }
}
