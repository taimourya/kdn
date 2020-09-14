<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Service;
use App\Entity\Template;
use App\Entity\Caracteristique;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');
        
        $mail = new Caracteristique();
        $mail->setLibele('E-mail professionel');

        $manager->persist($mail);

        $admin = new Caracteristique();
        $admin->setLibele('Admin Panel');

        $manager->persist($admin);
        
        $maintenance = new Caracteristique();
        $maintenance->setLibele('Maintenance 2 Semaine Gratuite');

        $manager->persist($maintenance);


        $service = new Service();
        $service->setName('Site Blog')
                ->setDescription('publication périodique et régulière d\'articles')
                ->setPrice(1500)
                ->setPageNumber(5)
                ->addCaracteristique($mail)
                ->addCaracteristique($admin)
                ->addCaracteristique($maintenance)
        ;

        $manager->persist($service);


        for($i = 1; $i<=$faker->numberBetween(5, 15); $i++)
        {
                $template = new Template();
                $template->setName($faker->word)
                         ->setDescription($faker->paragraph)
                         ->setService($service)
                         ->setPreviewUrl("https://www.softsevenart.com")
                         ->setImage("template1.JPG");
                ;

                $manager->persist($template);
        }

        $service = new Service();
        $service->setName('Site Vitrine')
                ->setDescription('Un site vitrine est un site Web qui présente un catalogue')
                ->setPrice(1500)
                ->setPageNumber(5)
                ->addCaracteristique($mail)
                ->addCaracteristique($admin)
                ->addCaracteristique($maintenance)
        ;

        $manager->persist($service);

        for($i = 1; $i<=$faker->numberBetween(5, 15); $i++)
        {
                $template = new Template();
                $template->setName($faker->word)
                         ->setDescription($faker->paragraph)
                         ->setService($service)
                         ->setPreviewUrl("https://www.softsevenart.com")
                         ->setImage("template1.JPG");
                ;

                $manager->persist($template);
        }

        
        $service = new Service();
        $service->setName('Site Blog/vitrine')
                ->setDescription('Une fusion d\'un site blog et vitrine')
                ->setPrice(2500)
                ->setPageNumber(7)
                ->addCaracteristique($mail)
                ->addCaracteristique($admin)
                ->addCaracteristique($maintenance)
        ;

        $manager->persist($service);

        for($i = 1; $i<=$faker->numberBetween(5, 15); $i++)
        {
                $template = new Template();
                $template->setName($faker->word)
                         ->setDescription($faker->paragraph)
                         ->setService($service)
                         ->setPreviewUrl("https://www.softsevenart.com")
                         ->setImage("template1.JPG");
                ;

                $manager->persist($template);
        }

        $user = new User();
        $user->setUsername('admin')
              ->setPassword($this->encoder->encodePassword($user, "admin"))
             ->setEmail('taimouriya@gmail.com')
             ->setFirstname('yahya')
             ->setLastname('taimourya')
             ->setCreatedAt(new \DateTime('now'))
        ;

        $manager->persist($user);

        $manager->flush();
    }
}
