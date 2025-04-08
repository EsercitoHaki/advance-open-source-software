<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\AuthRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthRepository extends BaseRepository implements AuthRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
    
    public function create(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $data['user_id'] = DB::raw('UUID()');
        
        return $this->model->create($data);
    }
    
    public function findByEmail(string $email)
    {
        return $this->model->where('email', $email)->first();
    }
}