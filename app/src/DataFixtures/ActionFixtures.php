<?php
/**
 * Action fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Action;
use App\Entity\Wallet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

/**
 * Class ActionFixtures.
 */
class ActionFixtures extends Fixture
{
    /**
     * Faker.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Persistence object manager.
     *
     * @var \Doctrine\Persistence\ObjectManager
     */
    protected $manager;

    /**
     * Load.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Persistence object manager
     */
    public function load(ObjectManager $manager): void
    {
        $this->faker = Factory::create();
        $this->manager = $manager;

        for ($i = 0; $i < 10; ++$i) {
            $action = new Action();
            $action->setName($this->faker->word);
            $action->setAmount($this->faker->numberBetween());
            $this->manager->persist($action);
        }

        $manager->flush();
    }
}