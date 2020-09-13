<?php
/**
 * Category fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

/**
 * Class CategoryFixtures.
 */
class CategoryFixtures extends Fixture
{
    /**
     * Faker.
     *
     * @var Generator
     */
    protected $faker;

    /**
     * Persistence object manager.
     *
     * @var ObjectManager
     */
    protected $manager;

    /**
     * Load.
     *
     * @param ObjectManager $manager Persistence object manager
     */
    public function load(ObjectManager $manager): void
    {
        $this->faker = Factory::create();
        $this->manager = $manager;

        for ($i = 0; $i < 10; ++$i) {
            $category = new Category();
            $category->setName($this->faker->word);
            $this->manager->persist($category);
        }

        $manager->flush();
    }
}
