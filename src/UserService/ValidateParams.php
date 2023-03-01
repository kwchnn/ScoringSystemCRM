<?php


namespace App\UserService;

class ValidateParams
{
    public function validateNumber(string $number): string
    {
        if (!preg_match("/^[0-9]{10,10}+$/", $number))
        {
            return "Неправильный формат номера телефона";
        }
        return $number;
    }

    public function validateEmail(string $email): string
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            return "Неправильный формат email адреса";
        }
        return $email;
    }
}