<?php
// src/Controller/CategoryController.php
namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/category", name="category_")
 */
Class CategoryController extends AbstractController
{
    /**
     * Show all categories of the table category
     *
     * @Route("/", name="index")
     * @return Response A response instance
     */
    public function index(): Response
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        return $this->render(
            'category/index.html.twig', [
            'categories' => $categories]
        );
    }

    /**
     * Getting all programs for a category
     *
     * @Route("/{categoryName}", name="show")
     * @return Response
     */
    public function show(string $categoryName):Response
    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name' => $categoryName]);

        if (!$category)
        {
            throw $this->createNotFoundException(
                'No category named '.$categoryName.' found in Category\'s table.'
            );

        }
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findBy(['category' => $category]);

        return $this->render('category/show.html.twig', [
            'category' => $category,
            'programs' => $programs,
        ]);
    }
}
