<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    const PROGRAM = [
        'Game of Thrones' => [
            'Winter is coming' => 'category_Fantastique',
        ],
        'Lord of the rings' => [
            'One ring to govern them all' => 'category_Fantastique',
        ],
        'Handmaids Tale' => [
            'USA goes crazy' => 'category_Action',
        ],
        'Friends' => [
            'The life of 6 friends in NYC' => 'category_Comédie',
        ]
    ];

    public function load(ObjectManager $manager)
    {

        foreach (self::PROGRAM as $name => $content) {
            foreach ($content as $key => $value) {

        $program = new Program();
        $program->setTitle($name);
        $program->setSynopsis($key);
        $program->setCategory($this->getReference($value));
        $manager->persist($program);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
