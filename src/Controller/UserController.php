<?php

namespace App\Controller;

use App\Form\RegistrationType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use http\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;

class UserController extends AbstractController
{
    private $security;
    /**
     * Constructeur pour récupérer le user
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/profil/{id}", name="user_profil", requirements={"id": "\d+"}, methods={"GET", "Post"})
     */
    public function profil($id, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);
        if (!$user){
            throw $this->createNotFoundException(
                'Utilisateur inconnu'
            );
        }
        return $this->render('user/profil.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/user", name="user_update")
     */
    public function updateUser(EntityManagerInterface $em, Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = $this->security->getUser();
        $userRegistrationForm = $this->createForm(RegistrationType::class, $user);
        //récupère les infos inscrit dans le form
        $userRegistrationForm->handleRequest($request);
        //vérifie la validiter du formulaire
        if ($userRegistrationForm->isSubmitted() && $userRegistrationForm->isValid()){
            //encoder le password modifier ou pas
            $password = $user->getPassword();
            $encoded = $encoder->encodePassword($user, $password);
            $user->setPassword($encoded);

            $em->persist($user);
            $em->flush();

            $this->addFlash("success", "Votre profil a été mise à jour.");
            return $this->redirectToRoute('app_home');
        }

        return $this->render('registration/register.html.twig', [
            'user' => $user,
            'registrationForm' => $userRegistrationForm->createView(),
        ]);
    }

    /**
     * @Route("/profil/{id}/delete", name="user_delete", requirements={"id": "\d+"}, methods={"GET", "Post"})
     */
    public function deleteUser($id, UserRepository $userRepository, EntityManagerInterface $em, Request $request, TokenStorageInterface $tokenStorage): Response
    {
        $user = $userRepository->find($id);
        $userCurrent = $this->security->getUser();
        if($user === $userCurrent){ //->getUsername()
            $em->remove($user);
            $em->flush();
            $this->addFlash("success", "Votre compte a été supprimé");
        }else{
            $this->addFlash("error", "Vous n'avez pas le droit de modifier ce compte");
        }

        //éviter l'erreur
        $request->getSession()->invalidate();
        $tokenStorage->setToken(); // TokenStorageInterface

        return $this->redirectToRoute('app_home');
    }
}
