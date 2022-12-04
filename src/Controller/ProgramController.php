<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Repository\EpisodeRepository;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



#[Route('/program/', name: 'program_')]
class ProgramController extends AbstractController
{

    #[Route('', name: 'homepage')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
        return $this->render('/program/index.html.twig', [
            'website' => 'Wild ',
            'programs' => $programs,
        ]);
    }


    #[Route('{id}', methods: ['GET'], requirements: ['page'=>'\d+'], name : 'show')]
    public function show(Program $program): Response
    {
        return $this->render('program/show.html.twig', [
            'program' => $program,
        ]);
    }


    #[Route('{programId}/seasons/{seasonId}', methods: ['GET'], requirements: ['page'=>'\d+'], name: 'season_show')]
    public function showSeason(int $programId, int $seasonId, ProgramRepository $programRepository, SeasonRepository $seasonRepository, EpisodeRepository $episodeRepository): Response
    {
        $programId = $programRepository->findOneBy(['id' => $programId]);
        $seasonId =  $seasonRepository->findOneBy(['id' => $seasonId]);
        $episode = $episodeRepository->findBy(['season' => $seasonId]);

        return $this->render('program/season_show.html.twig', [
            'program' => $programId,
            'season' => $seasonId,
            'episodes' => $episode,
        ]);


    }

}




