<?php

namespace App\Controller;

use App\DataFixtures\CategoryFixtures;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category/', name: 'category_')]
class CategoryController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findAll();

        return $this->render('category/index.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('{categoryName}', name: 'show')]
    public function show(string $categoryName, CategoryRepository $categoryRepository, ProgramRepository $programRepository):Response
    {
        $category = $categoryRepository->findBy(['name' => $categoryName]);

        if (!$category) {
            throw $this->createNotFoundException(
                'No category found.'
            );
        }
        $program = $programRepository->findBy(['category' => $category], ['id' => 'DESC'], limit:3);
        if (!$program) {
            throw $this->createNotFoundException(
                'No series found.'
            );
        }

        return $this->render('category/show.html.twig', [
            'category' => $category,
            'program' => $program,
        ]);
    }
}
