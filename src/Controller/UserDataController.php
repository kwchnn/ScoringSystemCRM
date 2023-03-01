<?php


namespace App\Controller;


use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserDataController extends AbstractController
{
    public function __construct(private UserRepository $user_repository)
    {

    }

    #[Route('/user', name: 'user')]
    public function userData()
    {
        $users = $this->user_repository->findOneBy(['email' => $this->getUser()->getUserIdentifier()]);
        return $this->render('user.html.twig', ['users' => $users]);
    }

//    #[Route('/dump', name: 'dump')]
//    public function dump(ScoreCount $params)
//    {
//        $params = $params->getScoreByEmail(16);
//        return $this->render('dump.html.twig', ['params' => $params]);
//    }
}