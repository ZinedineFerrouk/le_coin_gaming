<?php

namespace App\DataFixtures;

use App\Entity\Plateforme;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PlateformeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $tableau = [
            1 => [
                'titre' => 'Playstation',
                'image' => 'assets/images/plateforme/play.png',
            ],

            2 => [
                'titre' => 'Xbox',
                'image' => 'assets/images/plateforme/xbox.png',
            ],

            3 => [
                'titre' => 'Nintendo',
                'image' => 'assets/images/plateforme/nintendo.png',
            ],

            4 => [
                'titre' => 'Windows',
                'image' => 'assets/images/plateforme/windows.png',
            ],
        ];

        foreach ($tableau as $key => $value) {
            $platforme = new Plateforme();
            $platforme->setTitre($value['titre']);
            $platforme->setLogo($value['image']);
            $manager->persist($platforme);

            $this->addReference('plateforme_' . $key, $platforme);
        }

        $manager->flush();
    }
}
