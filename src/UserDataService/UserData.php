<?php


namespace App\UserDataService;


use App\Repository\UserRepository;

class UserData
{
    public function __construct(private UserRepository $user_repository)
    {}
    public function getUser(int $id): object
    {
        return $this->user_repository->findOneBy(['id' => $id]);
    }
}