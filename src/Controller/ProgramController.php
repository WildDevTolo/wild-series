<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\DataFixtures\ProgramFixtures;


#[Route('/program/', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('', name: 'homepage')]
    public function index(): Response
    {
        return $this->render('program/index.html.twig', [
            'website' => 'Wild ',
        ]);
    }

    #[Route('{id}', methods: ['GET'], requirements: ['page'=>'\d+'], name : 'id')]
    public function show(int $id)
    {
//        TODO render twig file

        return $this->render('program/show.html.twig', [
            'id' => $id
        ]);
}



}




