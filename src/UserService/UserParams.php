<?php

namespace App\UserService;

use App\UserService\Adapter\UserParamsInterface;

class UserParams implements UserParamsInterface
{
    protected string $first_name;
    protected string $last_name;
    protected string $email;
    protected string $phone_number;
    protected string $password;
    protected string $education;
    protected string $agreement;

    public function __construct(private $validate_params)
    {
    }

    public function getFormParams(array $params): void
    {
        $this->first_name = $params["first_name"];
        $this->last_name = $params["last_name"];
        $this->email = $this->validate_params->validateEmail($params["email"]);
        $this->phone_number = $this->validate_params->validateNumber($params["phone_number"]);
        $this->password = $params["password"];
        $this->education = $params["education"];
        $this->agreement = $params["agreement"];
    }

}