<?php

namespace App\Controller\Admin;

use App\Entity\Ingredient;
use App\Form\IngredientType;
use App\Repository\IngredientRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/ingredient', name: 'admin_ingredient_')]
class IngredientController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(IngredientRepository $repository): Response
    {
        $ingredients = $repository->findAll();
        return $this->render('admin/ingredient/index.html.twig',['ingredients' => $ingredients]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request, EntityManagerInterface $em)
    {
        $ingredient = new Ingredient();
        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($ingredient);
            $em->flush();

            $this->addFlash('success','Ingredient créé !');

            return $this->redirectToRoute('admin_ingredient_index');
        }

        return $this->render('admin/ingredient/create.html.twig', ['ingredientForm' => $form]);
    }

    #[Route('/update/{id}', name: 'update')]
    public function update(Request $request, Ingredient $ingredient,EntityManagerInterface $em): Response
    {
        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($ingredient);
            $em->flush();

            $this->addFlash('success','Ingredient modifié !');

            return $this->redirectToRoute('admin_ingredient_index');
        }

        return $this->render('admin/ingredient/update.html.twig', ['ingredientForm' => $form]);
    }

    #[Route('/delete', name: 'delete')]
    public function delete(): Response
    {
        return $this->render('admin/ingredient/delete.html.twig');
    }
}

// public function update(Category $category, Request $request)
//     {
//         $form = $this->createForm(CategoryType::class, $category);

//         $form->handleRequest($request);

//         if ($form->isSubmitted() && $form->isValid()) {
//             $this->em->flush();
//             return $this->redirectToRoute('admin_category_index');
//         }

//         return $this->render('admin/category/update.html.twig', [
//             'formCategory' => $form
//         ]);

//     }