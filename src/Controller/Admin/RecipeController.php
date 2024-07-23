<?php

namespace App\Controller\Admin;

use App\Entity\Ingredient;
use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/recipe', name: 'admin_recipe_')]
class RecipeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(RecipeRepository $repository): Response
    {
        $recipe = $repository->findAll();

        return $this->render('admin/recipe/index.html.twig', ['recipes' => $recipe]);
    }

    #[Route('/create', name: 'create', methods:['post','get'])]
    public function create(Request $request, EntityManagerInterface $em)
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($recipe);
            $em->flush();

            $this->addFlash('success', 'Recette créé !');

            return $this->redirectToRoute('admin_recipe_index');
        }

        return $this->render('admin/recipe/create.html.twig',['recipeForm'=>$form]);
    }

    #[Route('/detail/{id}', name: 'show')]
    public function show(Recipe $recipe)
    { //paramConverters

        return $this->render('admin/recipe/show.html.twig', ['recipe' => $recipe]);
    }

    #[Route('/update/{id}', name: 'update')]
    public function update(Request $request, Recipe $recipe, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Recette modifié !');

            return $this->redirectToRoute('admin_recipe_index');
        }

        return $this->render('admin/recipe/update.html.twig', ['recipeForm' => $form]);
    }

    #[Route('/delete/{id}', name:'delete', methods:'DELETE')]
    public function delete(Recipe $recipe, EntityManagerInterface $em)
    {
        $em->remove($recipe);
        $em->flush();

        $this->addFlash('success', 'Recette supprimé !');

        return $this->redirectToRoute('admin_recipe_index');
    }

}
