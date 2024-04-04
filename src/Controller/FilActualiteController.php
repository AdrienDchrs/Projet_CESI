<?php

namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Publication;
use App\Form\PublicationType;
use App\Form\ModifierPublicationType;
use App\Repository\PublicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request; 
use Knp\Component\Pager\PaginatorInterface; 
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;


class FilActualiteController extends AbstractController
{
    /**
     * Cette fonction permet de paginer et d'afficher tous mes résultats sur ma page actualité
     *
     * @param PublicationRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/filActualite', name: 'filActualite', methods: ['GET','POST'])]
    public function creerPublication(PublicationRepository $repository, PaginatorInterface $paginator, Request $request, EntityManagerInterface $manager): Response
    {
        $publication = new Publication();

        $publication->setidU($this->getUser());
        $publication->setImageName('assets/images/actualite/' . $publication->getImageName() . '.jpg');

        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $publication = $form->getData();

            $this->addFlash('success', 'Votre publication a été ajoutée avec succès !');

            $manager->persist($publication);
            $manager->flush();

            return $this->redirectToRoute('filActualite');
        }

        $publications = $paginator->paginate($repository->findBy([],['createdAt' => 'DESC'],null,null),$request->query->getInt('page', 1),5);

        return $this->render('actualite.html.twig', [
            'publications' => $publications,
            'user'      => $this->getUser(),  
            'form'      => $form->createView(),
        ]);
    }

    /**
     * Cette fonction permet de modifier une publication
     *
     * @param Publication $publication
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/filActualite/modifier/{id}', name: 'modifierPublication', methods: ['GET','POST'])]
    public function modifierPublication(PublicationRepository $repository, $id, EntityManagerInterface $manager, Request $request): Response
    {
        $publication = $repository->find($id);

        $nouveauTitre = $request->request->get('titreModifie');
        $nouveauTexte = $request->request->get('texteModifie');
        $nouvelleImage = $request->request->get('imageModifie');

        // Si un nouveau fichier a été téléchargé
        if ($nouvelleImage instanceof UploadedFile) 
        {
            $nomFichier = $uploaderHelper->uploadPublicationImage($nouvelleImage);

            $publication->setImageName($nomFichier);
        }

        $publication->setTitre($nouveauTitre);
        $publication->setTexte($nouveauTexte);
        
        $publication->setCreatedAt(new \DateTimeImmutable());

        $manager->flush();

        return $this->redirectToRoute('filActualite'); 
    }

    /**
     * Cette fonction permet de supprimer une publication
     * @param PublicationRepository $repository
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param $id
     * @return Response
     */
    #[Route('/filActualite/supprimer/{id}', name: 'supprimerPublication', methods: ['GET','POST'])]
    public function supprimerPublication(PublicationRepository $repository, $id, EntityManagerInterface $manager, Request $request): Response
    {
        $deletePublication = $repository->findBy(['id' => $id]);

        $manager->remove($deletePublication[0]);
        $manager->flush();

        return $this->redirectToRoute('filActualite');
    }

    #[Route('', name: 'filtrerPublication', methods: ['GET','POST'])]
    public function filtrerPublication(): Response
    {

    }    
}
