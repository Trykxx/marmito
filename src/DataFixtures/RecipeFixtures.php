<?php

namespace App\DataFixtures;

use App\Entity\Recipe;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class RecipeFixtures extends Fixture
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \FakerRestaurant\Provider\fr_FR\Restaurant($faker));

        for ($i = 0; $i < 25; $i++) {

            $recipe = new Recipe();
            $recipe->setName($faker->foodName());

            $slug = $this->slugger->slug($recipe->getName())->lower();
            $recipe->setSlug($slug);

            $recipe->setTemps($faker->numberBetween(1, 1440));

            $recipe->setPersonnes($faker->numberBetween(1, 50));

            $recipe->setDifficulty($faker->numberBetween(1, 5));

            $recipe->setDescription($faker->sentence(5));

            $recipe->setPrice($faker->numberBetween(1, 1000));

            $recipe->setFavorite(true);

            $recipe->setCreatedAt(new DateTimeImmutable());

            $manager->persist($recipe);
        }

        $manager->flush();
    }
}
