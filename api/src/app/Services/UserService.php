<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserService
{

    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function store(array $data): JsonResponse
    {
        $user = $this->user->create($data);
        return response()->json(
            $user, Response::HTTP_CREATED
        );
    }

}

