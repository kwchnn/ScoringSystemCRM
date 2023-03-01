<?php


namespace App\Controller;

use App\ScoringService\Adapter\ScoreCountInterface;
use App\UserService\Adapter\UserRegisterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserRegisterController extends AbstractController
{
    public function __construct(private UserRegisterInterface $user_register, private ScoreCountInterface $count)
    {
    }

    #[Route('/register', name: 'register_form')]
    public function renderFormAction(Request $request)
    {
        if ($this->getUser())
        {
            return $this->redirectToRoute('user');
        }
        return $this->render('user_register.html.twig');
    }

    #[Route('/register_method', name: 'register_action')]
    public function registerMethodAction(Request $request)
    {
        $this->user_register->getFormParams($request->request->all());
        $this->user_register->register();
        $this->count->getScore($request->request->get('email'));
        return $this->redirectToRoute('app_login');
    }

}