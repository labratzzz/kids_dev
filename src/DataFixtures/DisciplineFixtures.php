<?php

namespace App\DataFixtures;

use App\Entity\Discipline;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DisciplineFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $disciplines = [
            $this->createDiscipline('Естествознание', 'fixtures/forest.svg'),
            $this->createDiscipline('Пища', 'fixtures/food.svg'),
            $this->createDiscipline('Сказки', 'fixtures/fairytale.svg'),
            $this->createDiscipline('Животные', 'fixtures/cow.svg'),
            $this->createDiscipline('Азбука', 'fixtures/alphabet.svg'),
            $this->createDiscipline('Цифры', 'fixtures/number.svg'),
            $this->createDiscipline('Игры', 'fixtures/puzzle.svg')
        ];

        foreach ($disciplines as $discipline) {
            $manager->persist($discipline);
        }

        $manager->flush();
    }

    private function createDiscipline(string $name, string $image)
    {
        $discipline = new Discipline();
        $discipline->setName($name);
        $discipline->setImage($image);

        return $discipline;
    }
}
