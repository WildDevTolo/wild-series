<?php

namespace App\Controller;

use App\Repository\EpisodeRepository;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use Doctrine\ORM\Query\AST\WhereClause;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/program/', name: 'episode_')]
class EpisodeController extends AbstractController
{
    #[Route('{id}/show', name: 'show')]
    public function show(int $id, EpisodeRepository $episodeRepository, SeasonRepository $seasonRepository, ProgramRepository $programRepository): Response
    {
//        TODO render twig file
        $programId = $programRepository->findBy(['id' => $id]);
        $program = $programRepository->findAll(['id' => $id]);
        $seasonId = $seasonRepository->findBy(['program' => $programId]);
        $episode = $episodeRepository->findBy(['id' => $seasonId]);


//        if (!$program) {
//            throw $this->createNotFoundException(
//                'No program with id : ' . $id . ' found in program\'s table.'
//            );
//        }

        return $this->render('episode/show.html.twig', [
            'episode' => $episode,
            'season' => $seasonId,
            'program' => $program,
        ]);
    }
}