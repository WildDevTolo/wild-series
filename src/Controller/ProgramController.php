<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Repository\EpisodeRepository;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ProgramType;
use Symfony\Component\HttpFoundation\Request;




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

    #[Route('new', name: 'new')]
    public function new(Request $request, ProgramRepository $programRepository): Response
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $programRepository->save($program, true);

            // Redirect to categories list
            return $this->redirectToRoute('program_homepage');
        }

        // Render the form
        return $this->renderForm('program/new.html.twig', [
            'form' => $form,
        ]);
    }


    #[Route('{id}', methods: ['GET'], requirements: ['page'=>'\d+'], name : 'show')]
    public function show(int $id, Program $program, SeasonRepository $seasonRepository): Response
    {
        $seasonId =  $seasonRepository->findBy(['program' => $id]);

        return $this->render('program/show.html.twig', [
            'program' => $program,
            'season' => $seasonId
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


    #[Route('{programId}/seasons/{seasonId}/episode/{episodeId}', methods: ['GET'], requirements: ['page'=>'\d+'], name: 'episode_show')]
    public function showEpisode(Program $programId, Season $seasonId, Episode $episodeId): Response
    {
//

        return $this->render('program/episode_show.html.twig', [
            'program' => $programId,
            'season' => $seasonId,
            'episode' => $episodeId,
        ]);
    }



}




