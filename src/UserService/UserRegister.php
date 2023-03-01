<?php


namespace App\UserService;


use App\Repository\UserRepository;
use App\Entity\User;
use App\UserService\Adapter\UserRegisterInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserRegister extends UserParams implements UserRegisterInterface
{
    private ?object $user_object;

    public function __construct(private UserRepository $user_repository,
                                private UserPasswordHasherInterface $user_password_hasher,
                                private ManagerRegistry $manager_registry,
                                private ValidateParams $validate_params)
    {
        parent::__construct($this->validate_params);
    }

    public function register(): void
    {
        $user = $this->user_repository->findOneBy(['email' => $this->email]);
        if (!$user)
        {
            $manager = $this->manager_registry->getManager();
            $this->user_object = new User();
            $this->user_object->setEmail($this->email)
                ->setPhone($this->phone_number)
                ->setLastName($this->last_name)
                ->setFirstName($this->first_name)
                ->setEducation($this->education)
                ->setRoles(["ROLE_USER"])
                ->setPassword($this->hashPassword())
                ->setScore(0)
                ->setAgreement($this->agreement);
            $manager->persist($this->user_object);
            $manager->flush();
        }
    }

    private function hashPassword(): string
    {
        return $this->user_password_hasher->hashPassword(
            $this->user_object,
            $this->password
        );
    }
}