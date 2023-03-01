<?php


namespace App\UserService\Adapter;


interface UserParamsInterface
{
    public function getFormParams(array $params): void;
}