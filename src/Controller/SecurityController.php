<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {}

    /**
    * @Route("/Inscription", name="app_inscription")
    */
    public function inscription(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder): Response
    {

      // Créer un utilisateur vide
      $user = new User();

      //Creation d'un formulaire
      $formulaireUser= $this->createForm(UserType::class, $user);

      $formulaireUser->handleRequest($request);
      if ($formulaireUser->isSubmitted()&& $formulaireUser->isValid()) {

        //definir le role de l'utilisateur
        $user->setRoles(['ROLE_USER']);

        //encoder le mot de passe de l'utilisateur

        $motDePasseEncode = $encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($motDePasseEncode);
      //Enregistrer en Base de Données
      $manager->persist($user);
      $manager->flush();
      //Rediriger sur la page d'acceuil
      return $this->redirectToRoute('pro_stage');
      }
      //afficher la page presentant le formulaire d'inscription

      return $this->render('security/inscription.html.twig', ['vueFormulaireUser' => $formulaireUser->createView()]);
    }
}
