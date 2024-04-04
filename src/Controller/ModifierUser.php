<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ModifierUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ModifierUser extends AbstractController
{
    #[Route('/parametres/{id}', name: 'parametres', methods:['GET','POST'])]
    public function parametres(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher, AuthenticationUtils $authenticationUtils): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(ModifierUserType::class, $user);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid() && $form->get('plainPassword')->getData() != null)
        {    
            $newPassword = $form->get('plainPassword')->getData();

            $hashedPassword = $hasher->hashPassword($user, $newPassword);
            
            $user->setPassword($hashedPassword);

            $this->addFlash('success', 'Le mot de passe a été modifié.');

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('parametres' , ['id' => $user->getId()]);
        }   
        else
        {
            return $this->render('parametres.html.twig', 
            ['form' => $form->createView(), 
             'user' => $user,
             'error' => $authenticationUtils->getLastAuthenticationError()]);
        }
    }
}
