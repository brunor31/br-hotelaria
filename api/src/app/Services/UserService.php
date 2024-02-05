<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class UserService
{

    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        try {

            $users = $this->user->paginate(10);

            return response()->json(
                $users, Response::HTTP_OK
            );

        } catch(\Exception $e) {

            return response()->json(
                ['message' => 'Erro ao listar usuários', 'error' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function store(array $data): JsonResponse
    {
        try {

            $user = $this->user->create($data);

            Log::channel('br-hotelaria-logs')
                ->info('Usuário criado', ['user' => $user]);
            
            return response()->json(
                ['message' => 'Usuário criado com sucesso!'],
                Response::HTTP_CREATED
            );

        } catch (\Exception $e) {

            return response()->json(
                ['message' => 'Erro ao criar usuário', 'error' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function show(string $id)
    {
        try {

            $user = $this->user->find($id);

            if(empty($user)) {

                return response()->json(
                    ['message' => 'Usuário não encontrado'],
                    Response::HTTP_NOT_FOUND
                );
            }

            return $user;
            
        } catch(\Exception $e) {

            return response()->json(
                ['message' => 'Erro ao listar usuário', 'error' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function update(array $data, string $id)
    {
        try {
            
            $user = $this->show($id);

            $user->update($data);

            Log::channel('br-hotelaria-logs')
                ->info('Usuário atualizado', ['user' => $user]);

            return response()->json(
                ['message' => 'Usuário atualizado com sucesso!'],
                Response::HTTP_OK
            );

        } catch (\Exception $e) {

            return response()->json(
                ['message' => 'Erro ao atualizar usuário', 'error' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

}

