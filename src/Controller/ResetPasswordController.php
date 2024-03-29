<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use App\Security\UserAuthenticationAuthenticator;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Repository\UserRepository;
use Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class ResetPasswordController extends AbstractController
{
    private $emailVerifier;
   

    public function __construct(EmailVerifier $emailVerifier, RequestStack $request )
    {
        $this->emailVerifier = $emailVerifier;
        $this->currentRequest = $request->getCurrentRequest();
    }

    
    public function __invoke(User $data,Request $request,GuardAuthenticatorHandler $guardHandler, UserAuthenticationAuthenticator $authenticator,$token,UserPasswordEncoderInterface $passwordEncoder): User
    {
       
       $content = json_decode($request->getContent());
       $data = $this->getDoctrine()->getRepository(User::class)->findOneBy(['rest_token' => $token]);
       $data->setPassword($passwordEncoder->encodePassword($data, $content->password));
       $data->setRestToken(null);
           
       return $data;
    }

}

