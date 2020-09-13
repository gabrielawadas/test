<?php
/**
 * Action fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Action;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

/**
 * Class ActionFixtures.
 */
class ActionFixtures extends Fixture
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
            $action = new Action();
            $action->setName($this->faker->word);
            $action->setAmount($this->faker->numberBetween());
            $action->setDate($this->faker->dateTimeAd());

            $this->manager->persist($action);
        }

        $manager->flush();
    }
}
