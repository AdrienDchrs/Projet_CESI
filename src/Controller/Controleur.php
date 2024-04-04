<?php 

namespace App\Controller; 

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response; 
use Symfony\Component\Routing\Annotation\Route;

class Controleur extends AbstractController
{
    #[Route('/', 'home.index', methods:['GET'])]
    public function index(): Response
    {
        return $this->render('home.html.twig');
    }

    #[Route('/mentionsLegales', 'home.mentionsLegales', methods:['GET'])]
    public function mentionsLegales(): Response 
    {
        return $this->render('mentionsLegales.html.twig');
    }
}

?>