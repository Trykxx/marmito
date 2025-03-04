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
        return $this->render('admin/ingredient/index.html.twig', ['ingredients' => $ingredients]);
    }

    #[Route('/detail/{id}', name: 'show')]
    public function show(Ingredient $ingredient)
    { //paramConverters

        return $this->render('admin/ingredient/show.html.twig', ['ingredient' => $ingredient]);
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

            $this->addFlash('success', 'Ingredient créé !');

            return $this->redirectToRoute('admin_ingredient_index');
        }

        return $this->render('admin/ingredient/create.html.twig', ['ingredientForm' => $form]);
    }

    #[Route('/update/{id}', name: 'update')]
    public function update(Request $request, Ingredient $ingredient, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Ingredient modifié !');

            return $this->redirectToRoute('admin_ingredient_index');
        }

        return $this->render('admin/ingredient/update.html.twig', ['ingredientForm' => $form]);
    }

    #[Route('/delete/{id}', name:'delete', methods:'DELETE')]
    public function delete(Ingredient $ingredient, EntityManagerInterface $em)
    {
        $em->remove($ingredient);
        $em->flush();

        $this->addFlash('success', 'Ingredient supprimé !');

        return $this->redirectToRoute('admin_ingredient_index');
    }
}
