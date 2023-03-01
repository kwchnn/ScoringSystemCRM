<?php


namespace App\ScoringService;

use App\Entity\User;
use App\Repository\EducationRepository;
use App\Repository\EmailRepository;
use App\Repository\MobileOperatorRepository;
use App\ScoringService\Adapter\ScoreCountInterface;
use Doctrine\Persistence\ManagerRegistry;

class ScoreCount implements ScoreCountInterface
{
    private object $manager;

    public function __construct(private MobileOperatorRepository $mobile_operator_repository,
                                private EmailRepository $email_repository,
                                private EducationRepository $education_repository,
                                private ManagerRegistry $manager_registry)
    {
        $this->manager = $this->manager_registry->getManager();
    }

    public function getScore(string $email): void
    {
        $user = $this->manager->getRepository(User::class)->findOneBy(['email' => $email]);
        $this->getScoreByPhone($user->getId());
        $this->getScoreByEmail($user->getId());
        $this->getScoreByEducation($user->getId());
        $this->getScoreByAgreement($user->getId());
        $this->manager->flush();
    }

    private function getScoreByPhone($id)
    {
        $user = $this->manager->getRepository(User::class)->find($id);
        $number = substr($user->getPhone(),0, -7);
        $score = $this->mobile_operator_repository->findOneBy(['operator_name' => $number]);
        if ($score)
        {
            $user->setScore($score->getScore());
            return $this->manager->persist($user);
        }
        $user->setScore(1);
        $this->manager->persist($user);
    }

    public function getScoreByEmail($id)
    {
        $user = $this->manager->getRepository(User::class)->find($id);
        preg_match("/[^@]\w+\./", $user->getEmail(), $email_domain);
        $email_domain = implode("", $email_domain);
        $user_email = substr($email_domain, 0, -1 );
        $email = $this->email_repository->findOneBy(['email_name' => $user_email]);
        if ($email)
        {
            $user->setScore($user->getScore() + $email->getScore());
            return $this->manager->persist($user);
        }
        $user->setScore($user->getScore() + 3);
        $this->manager->persist($user);
    }

    private function getScoreByEducation($id): void
    {
        $user = $this->manager->getRepository(User::class)->find($id);
        $education = $this->education_repository->findOneBy(['education_name' => $user->getEducation()]);
        $user->setScore($user->getScore() + $education->getScore());
        $this->manager->persist($user);
    }

    private function getScoreByAgreement($id): void
    {
        $user = $this->manager->getRepository(User::class)->find($id);
        $user->setScore($user->getScore() + $user->getAgreement());
        $this->manager->persist($user);
    }


}