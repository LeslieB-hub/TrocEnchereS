<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Sale;
use App\Entity\State;
use App\Entity\User;
use App\Entity\Withdrawal;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        echo 'Création des fixtures';

        /**
         * User
         */
        for ($i = 0; $i < 20; $i++){
            $user = new User();

            $user->setFirstname($faker->firstName);
            $user->setLastname($faker->lastName);
            $user->setUsername($this->makeUsername($user));
            $user->setRoles(['ROLE_USER']);

            $password = $this->passwordEncoder->encodePassword($user, 'azerty');
            $user->setPassword($password);

            $user->setEmail($user->getUsername().'@example.org');
            $user->setTelephone($faker->phoneNumber);
            $user->setStreet($faker->streetAddress);
            $user->setPostcode($faker->postcode);
            $user->setCity($faker->city);
            $user->setBalance($faker->numberBetween(30, 1000));
            $manager->persist($user);
        }
        $manager->flush();

        $users = $manager->getRepository(User::class);

        /**
         * Categories
         */
        $categoryNames = ['Animalerie','Bricolage','Ameublement','Décoration','Jouets et jeux','Livres',
                            'Informatique','Vêtements et accessoires','Jeux vidéo et consoles','Vélo'];
        foreach ($categoryNames as $categoryName){
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
        }
        $manager->flush();

        $categories = $manager->getRepository(Category::class);

        /**
         * States
         */
        $stateList = [State::CREATED, State::ONGOING, State::CLOSED, State::CANCELED, State::WITHDREW];
        foreach ($stateList as $stateName) {
            $state = new State();
            $state->setName($stateName);
            $manager->persist($state);
        }
        $manager->flush();

        $states = $manager->getRepository(State::class);


        /**
         * Withdrawal
         */
        /*for ($i = 0; $i < 15; $i++)
        {
            $withdrawal = new Withdrawal();
            $withdrawal->setStreet($faker->streetAddress);
            $withdrawal->setCity($faker->city);
            $withdrawal->setPostcode($faker->postcode);
            $manager->persist($withdrawal);
        }
        $manager->flush();
        $withdrawals = $manager->getRepository(Withdrawal::class);
        */

        /**
         * Sales
         */
        /*
        for ($i = 0; $i < 25; $i++){
            $sale = new Sale();

            $sale->setItem($faker->word);
            $sale->setDescription($faker->sentence(10, true));

            $sale->setStartdatebid($faker->date('Y-m-d', 'now'));
            $endDateTime = $faker->dateTimeBetween('-60 days', 'now', 'Europe/Paris');
            //$endDateTime->format('Y-m-d')
            $sale->setEndDateBid($faker->dateTimeBetween('now', '+60', 'Europe/Paris'));
            $sale->setInitialPrice($faker->numberBetween(30, 100));
            //$sale->setSalePrice();
            $sale->setCategory($categories[rand(0, count($categories)-1)]);
            $sale->setSeller($users[rand(0, count($users)-1)]);
            $sale->setWithdrawalPlace($withdrawals[rand(0, count($withdrawals)-1)]);
            //$sale->setBuyer();
            //$sale->setState();
            $manager->persist($sale);
        }
        $manager->flush();
        */

    }

    private function remove_accents($str, $charset='utf-8')
    {
        $str = htmlentities($str, ENT_NOQUOTES, $charset);

        $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
        $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
        $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères

        return $str;
    }

    private function makeUsername(User $user):string
    {
        $username = substr($user->getFirstname(), 0, 1).$user->getLastname();
        return $this->remove_accents($username);
    }
}
