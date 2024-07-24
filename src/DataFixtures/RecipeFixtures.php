<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use App\Entity\Recipe;
use App\Repository\IngredientRepository;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\This;
use Symfony\Component\String\Slugger\SluggerInterface;

class RecipeFixtures extends Fixture implements DependentFixtureInterface
{
    // private IngredientRepository $repository;

    private $slugger;

    public function __construct(SluggerInterface $slugger, IngredientRepository $repository)
    {
        $this->slugger = $slugger;
        // $this->repository = $repository;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \FakerRestaurant\Provider\fr_FR\Restaurant($faker));

        // $ingredients = $this->repository->findAll();

        for ($i = 0; $i < 25; $i++) {

            $recipe = new Recipe();
            $ingredient = new Ingredient();

            $recipe->setName($faker->foodName());

            $slug = $this->slugger->slug($recipe->getName())->lower();
            $recipe->setSlug($slug);

            $recipe->setTemps($faker->numberBetween(1, 1440));

            $recipe->setPersonnes($faker->numberBetween(1, 50));

            $recipe->setDifficulty($faker->numberBetween(1, 5));

            $recipe->setDescription($faker->sentence(5));

            $recipe->setPrice($faker->numberBetween(1, 1000));

            $recipe->setFavorite(true);

            for ($j = 0; $j < mt_rand(2,6); $j++) {
                $recipe->addIngredient($this->getReference('INGREDIENT' . mt_rand(0, 19)));
            }

            // foreach ($ingredients as $ingredient) {
            //     $recipe->addIngredient($ingredient);
            // }

            $recipe->setCreatedAt(new DateTimeImmutable());

            $manager->persist($recipe);
        }

        $manager->flush();
    }

    public function getDependencies() //fonction de l'interface qui permet de choisir les fixtures a lancer avant
    {
        return [IngredientFixtures::class]; // va lancer d'abord cette fixture
    }
}
