<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\InscriptionType;
use App\Form\ModifierUserType;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

  #[Route('/connexion', name: 'security.connexion', methods:['GET', 'POST'])]
  public function connexion(AuthenticationUtils $authenticationUtils): Response
  {
    return $this->render('security/connexion.html.twig', [ 
      'error' => $authenticationUtils->getLastAuthenticationError(),
      'user' => $this->getUser(),
    ]);
  }

  #[Route('/deconnexion', name: 'security.deconnexion', methods:['GET'])]
  public function deconnexion() 
  {
    $response = $this->logout();

    return $this->render('security/connexion.html.twig');

  }

  #[Route('/inscription','security.inscription', methods:['GET','POST'])]
  public function inscription(Request $request, EntityManagerInterface $manager, AuthenticationUtils $authenticationUtils): Response
  {
    $user = new User();

    $form = $this->createForm(InscriptionType::class, $user);

    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid())
    {
      $user = $form->getData();
      $user->setRoles(['ROLE_USER']);

      $this->addFlash('success', 'Votre compte a bien été crée !'); 

      $manager->persist($user);
      $manager->flush();

      return $this->redirectToRoute('security.connexion');
    }

    return $this->render('security/inscription.html.twig', [
      'form'  => $form->createView(),
       ]);
  }
}
