<?php

namespace App\DataFixtures;

use App\Entity\Recette;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');
        $faker->addProvider(new \FakerRestaurant\Provider\fr_FR\Restaurant($faker));
        for ($i = 0; $i < 10; $i++) {
            $recette = new Recette();
            $recette->setNom($faker->foodName());
            for ($i = 0; $i < mt_rand(0, 6); $i++) {
                $recette->addIngredient($this->getReference('INGREDIENT' . mt_rand(1, 19)));
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            IngredientFixtures::class
        ];
    }
}
