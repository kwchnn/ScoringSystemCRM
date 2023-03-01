<?php


namespace App\UserService\Adapter;


interface UserRegisterInterface extends UserParamsInterface
{
    public function register(): void;
}