<?php

namespace App\DataFixtures;

use App\Entity\Property;
use App\Entity\TypeProperty;
use App\Entity\Disponibility;
use App\DataFixtures\TypePropertyFixtures;
use App\DataFixtures\UserFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PropertyFixtures extends Fixture implements DependentFixtureInterface
{
    public const CABANES = 'cabane-arbre';
    public const CABANES_EAU = 'cabane-eau';
    public const tipis = 'tipi';
    public const roulottes = 'roulottes';
    public const bulles = 'bulles';
    public const yourtes = 'yourtes';
    public const bateaux = 'bateaux';
    public const chalets = 'chalets';
    public const inclassables = 'inclassables';

    public function load(ObjectManager $manager)
    {
        $cabane = new Property();
        $cabane->setTitle('cabane dans les abres')
            ->setDescription('très belle cabane dans les arbres. Sit amet jelly beans pie apple pie chupa chups candy. I love candy I love pie bear claw chocolate bar sweet tootsie roll I love..')
            ->setAccessHandicap(true)
            ->setWater('eau courante')
            ->setElectricity(true)
            ->setSurface(150)
            ->setRate(95.50)
            ->setNbrRoom(3)
            ->setMaxTravelers(3)
            ->setTax(0.20)
            ->setAddress($this->getReference(AddressFixture::adresse_bien))
            ->addPicture($this->getReference(PicturesFixtures::picture_bien));
            
            $this->addReference(self::CABANES,$cabane);
            
            $manager->persist($cabane);
            
            // disponibilités pour les cabanes
            for($i=0; $i<20; $i++){
                $disponibility = new Disponibility();
                $disponibility->setjourDispo(new \DateTime("today + ".$i."days"))
                ->setProperty($cabane);
                $manager->persist($disponibility);
            }

             // 30 cabanes
                for($i=0; $i<30; $i++){
                    $cabane1 = new Property();
                    $cabane1->setTitle('cabane dans les abres '.$i)
                    ->setDescription('très belle cabane dans les arbres. Sit amet jelly beans pie apple pie chupa chups candy. I love candy I love pie bear claw chocolate bar sweet tootsie roll I love..')
                    ->setAccessHandicap(true)
                    ->setWater('eau courante')
                    ->setElectricity(true)
                    ->setSurface(150)
                    ->setRate(95.50)
                    ->setNbrRoom(3)
                    ->setMaxTravelers(3)
                    ->setTax(0.20)
                    ->setUser($this->getReference(UserFixtures::PROP_USER_REFERENCE))
                    ->setTypeProperty($this->getReference(TypePropertyFixtures::cabane_arbre))
                    ->addPicture($this->getReference(PicturesFixtures::picture_bien));
                    $disponibility1 = new Disponibility();
                    $disponibility1->setjourDispo(new \DateTime("today + ".$i."days"))
                    ->setProperty($cabane1);
                    $manager->persist($disponibility1);
                    $manager->persist($cabane1);
                }
                
                $cabaneEau = new Property();
                $cabaneEau->setTitle('cabane sur l\'eau')
                ->setDescription('très belle cabane sur l\'eau. Sit amet jelly beans pie apple pie chupa chups candy. I love candy I love pie bear claw chocolate bar sweet tootsie roll I love..')
                ->setAccessHandicap(false)
                ->setWater('eau courante')
                ->setElectricity(true)
                ->setSurface(30)
                ->setRate(95.50)
                ->setNbrRoom(3)
                ->setMaxTravelers(3)
                ->setTax(0.20)
                ->setTypeProperty($this->getReference(TypePropertyFixtures::CABANE_EAU_REF))
                ->setUser($this->getReference(UserFixtures::PROP1_USER_REFERENCE))
                ->setAddress($this->getReference(AddressFixture::adr_cabane_eau))
                ->addPicture($this->getReference(PicturesFixtures::picture_bien));
            
        $this->addReference(self::CABANES_EAU,$cabaneEau);
        $manager->persist($cabaneEau);
        
        for($i=0; $i<30; $i++){
            $cabane1 = new Property();
            $cabane1->setTitle('cabane sur l\'eau '.$i)
            ->setDescription('très belle cabane sur l\'eau. Sit amet jelly beans pie apple pie chupa chups candy. I love candy I love pie bear claw chocolate bar sweet tootsie roll I love..')
            ->setAccessHandicap(true)
            ->setWater('eau courante')
            ->setElectricity(true)
            ->setSurface(150)
            ->setRate(95.50)
            ->setNbrRoom(3)
            ->setMaxTravelers(3)
            ->setTax(0.20)
            ->setUser($this->getReference(UserFixtures::PROP1_USER_REFERENCE))
            ->setTypeProperty($this->getReference(TypePropertyFixtures::cabane_arbre))
            ->addPicture($this->getReference(PicturesFixtures::picture_bien));
            $disponibilityEau = new Disponibility();
            $disponibilityEau->setjourDispo(new \DateTime("+".$i."month now"))
                            ->setProperty($cabane1);
            $manager->persist($disponibilityEau);
            $manager->persist($cabane1);
        }

        // dispo tous les 1ers du mois
        for($i=0; $i<20; $i++){
                $disponibilityEau = new Disponibility();
                $disponibilityEau->setjourDispo(new \DateTime("+".$i."month now"))
                            ->setProperty($cabaneEau);
                $manager->persist($disponibilityEau);
        }

            $bulle = new Property();
            $bulle->setTitle('bulle')
            ->setDescription('très belle cabane sur l\'eau. Sit amet jelly beans pie apple pie chupa chups candy. I love candy I love pie bear claw chocolate bar sweet tootsie roll I love..')
            ->setAccessHandicap(false)
            ->setWater('eau courante')
            ->setElectricity(true)
            ->setSurface(30)
            ->setRate(95.50)
            ->setNbrRoom(3)
            ->setMaxTravelers(3)
            ->setTax(0.20)
            ->setUser($this->getReference(UserFixtures::PROP1_USER_REFERENCE))
            ->setTypeProperty($this->getReference(TypePropertyFixtures::BULLE_REF))
            ->setAddress($this->getReference(AddressFixture::adr_bulle))
            ->addPicture($this->getReference(PicturesFixtures::picture_bien));
            
            $this->addReference(self::bulles,$bulle);
            $manager->persist($bulle);
            
            for($i=0; $i<30; $i++){
                $cabane1 = new Property();
                $cabane1->setTitle('bulle'.$i)
                ->setDescription('très belle bulle. Sit amet jelly beans pie apple pie chupa chups candy. I love candy I love pie bear claw chocolate bar sweet tootsie roll I love..')
                ->setAccessHandicap(true)
                ->setWater('eau courante')
                ->setElectricity(true)
                ->setSurface(150)
                ->setRate(95.50)
                ->setNbrRoom(3)
                ->setMaxTravelers(3)
                ->setTax(0.20)
                ->setUser($this->getReference(UserFixtures::PROP1_USER_REFERENCE))
                ->setTypeProperty($this->getReference(TypePropertyFixtures::cabane_arbre))
                ->addPicture($this->getReference(PicturesFixtures::picture_bien));
                $disponibilityEau = new Disponibility();
                $disponibilityEau->setjourDispo(new \DateTime("today + ".$i."days"))
                                ->setProperty($cabane1);
                $manager->persist($disponibilityEau);
                $manager->persist($cabane1);
            }

            $tipi = new Property();
            $tipi->setTitle('tipi')
            ->setDescription('très belle cabane sur l\'eau. Sit amet jelly beans pie apple pie chupa chups candy. I love candy I love pie bear claw chocolate bar sweet tootsie roll I love..')
            ->setAccessHandicap(false)
            ->setWater('eau courante')
            ->setElectricity(false)
            ->setSurface(30)
            ->setRate(95.50)
            ->setNbrRoom(3)
            ->setMaxTravelers(3)
            ->setTax(0.20)
            ->setUser($this->getReference(UserFixtures::PROP1_USER_REFERENCE))
            ->setTypeProperty($this->getReference(TypePropertyFixtures::TIPI_REF))
            ->setAddress($this->getReference(AddressFixture::adr_tipi))
            ->addPicture($this->getReference(PicturesFixtures::picture_bien));
            $this->addReference(self::tipis,$tipi);
            $manager->persist($tipi);
            // même disp cabanes sur l'eau
            for($i=0; $i<20; $i++){
                $disponibilityEau = new Disponibility();
                $disponibilityEau->setjourDispo(new \DateTime("+".$i."month now"))
                            ->setProperty($tipi);
                $manager->persist($disponibilityEau);
            }
            for($i=0; $i<30; $i++){
                $cabane1 = new Property();
                $cabane1->setTitle('bulle'.$i)
                ->setDescription('très belle bulle. Sit amet jelly beans pie apple pie chupa chups candy. I love candy I love pie bear claw chocolate bar sweet tootsie roll I love..')
                ->setAccessHandicap(true)
                ->setWater('eau courante')
                ->setElectricity(true)
                ->setSurface(150)
                ->setRate(95.50)
                ->setNbrRoom(3)
                ->setMaxTravelers(3)
                ->setTax(0.20)
                ->setUser($this->getReference(UserFixtures::PROP1_USER_REFERENCE))
                ->setTypeProperty($this->getReference(TypePropertyFixtures::cabane_arbre))
                ->addPicture($this->getReference(PicturesFixtures::picture_bien));
                $disponibilityEau = new Disponibility();
                $disponibilityEau->setjourDispo(new \DateTime("today + ".$i."days"))
                                ->setProperty($cabane1);
                $manager->persist($disponibilityEau);
                $manager->persist($cabane1);
            }
            $roulottes = new Property();
            $roulottes->setTitle('roulottes')
            ->setDescription('très belle cabane sur l\'eau. Sit amet jelly beans pie apple pie chupa chups candy. I love candy I love pie bear claw chocolate bar sweet tootsie roll I love..')
            ->setAccessHandicap(false)
            ->setWater('eau courante')
            ->setElectricity(true)
            ->setSurface(30)
            ->setRate(95.50)
            ->setNbrRoom(3)
            ->setMaxTravelers(3)
            ->setUser($this->getReference(UserFixtures::PROP1_USER_REFERENCE))
            ->setTypeProperty($this->getReference(TypePropertyFixtures::ROULOTTE_REF))
            ->setAddress($this->getReference(AddressFixture::adr_roulotte))
            ->addPicture($this->getReference(PicturesFixtures::picture_bien))
            ->setTax(0.20);
            $this->addReference(self::roulottes,$roulottes);
            $manager->persist($roulottes);
            
            // même disp cabanes sur l'eau
            for($i=0; $i<20; $i++){
                $disponibilityEau = new Disponibility();
                $disponibilityEau->setjourDispo(new \DateTime("+".$i."month now"))
                ->setProperty($roulottes);
                $manager->persist($disponibilityEau);
            }
            
            $chalets = new Property();
            $chalets->setTitle('chalets')
            ->setDescription('très belle cabane sur l\'eau. Sit amet jelly beans pie apple pie chupa chups candy. I love candy I love pie bear claw chocolate bar sweet tootsie roll I love..')
            ->setAccessHandicap(false)
            ->setWater('eau courante')
            ->setElectricity(true)
            ->setSurface(30)
            ->setRate(95.50)
            ->setNbrRoom(3)
            ->setMaxTravelers(3)
            ->setTax(0.20)
            ->setUser($this->getReference(UserFixtures::PROP_USER_REFERENCE))
            ->setTypeProperty($this->getReference(TypePropertyFixtures::CHALET_REF))
            ->setAddress($this->getReference(AddressFixture::adr_chalets))
            ->addPicture($this->getReference(PicturesFixtures::picture_bien));
            
            for($i=0; $i<10; $i++){
                $chalets = new Property();
                $chalets->setTitle('roulottes')
                ->setDescription('très belle cabane sur l\'eau. Sit amet jelly beans pie apple pie chupa chups candy. I love candy I love pie bear claw chocolate bar sweet tootsie roll I love..')
                ->setAccessHandicap(false)
                ->setWater('eau courante')
                ->setElectricity(true)
                ->setSurface(30)
                ->setRate(95.50)
                ->setNbrRoom(3)
                ->setMaxTravelers(3)
                ->setUser($this->getReference(UserFixtures::PROP1_USER_REFERENCE))
                ->setTypeProperty($this->getReference(TypePropertyFixtures::CHALET_REF))
                ->addPicture($this->getReference(PicturesFixtures::picture_bien))
                ->setTax(0.20);
                $manager->persist($chalets);
            }
            // même disp cabanes sur l'eau
            for($i=0; $i<20; $i++){
                $disponibilityEau = new Disponibility();
                $disponibilityEau->setjourDispo(new \DateTime("+".$i."month now"))
                          ->setProperty($roulottes);
               $manager->persist($disponibilityEau);
            }
        // même dispos que cabanes
        for($i=0; $i<20; $i++){
            $disponibility = new Disponibility();
            $disponibility->setjourDispo(new \DateTime("today + ".$i."days"))
                        ->setProperty($chalets);
            $manager->persist($disponibility);
    }
            $this->addReference(self::chalets,$chalets);
            $manager->persist($chalets);
            
            $yourtes = new Property();
            $yourtes->setTitle('yourtes')
            ->setDescription('très belle cabane sur l\'eau. Sit amet jelly beans pie apple pie chupa chups candy. I love candy I love pie bear claw chocolate bar sweet tootsie roll I love..')
            ->setAccessHandicap(false)
            ->setWater('eau courante')
            ->setElectricity(true)
            ->setSurface(30)
            ->setRate(95.50)
            ->setNbrRoom(3)
            ->setMaxTravelers(3)
            ->setTax(0.20)
            ->setUser($this->getReference(UserFixtures::PROP_USER_REFERENCE))
            ->setTypeProperty($this->getReference(TypePropertyFixtures::YOURTE_REF))
            ->setAddress($this->getReference(AddressFixture::adr_yourte))
            ->addPicture($this->getReference(PicturesFixtures::picture_bien));
            $this->addReference(self::yourtes,$yourtes);
            $manager->persist($yourtes);
    
            // même disp cabanes sur l'eau
            for($i=0; $i<20; $i++){
                  $disponibilityEau = new Disponibility();
                                                    $disponibilityEau->setjourDispo(new \DateTime("+".$i."month now"))
                                                                ->setProperty($yourtes);
                                                    $manager->persist($disponibilityEau);
                                            }
            $inclassables = new Property();
            $inclassables->setTitle('inclassables')
            ->setDescription('très belle cabane sur l\'eau. Sit amet jelly beans pie apple pie chupa chups candy. I love candy I love pie bear claw chocolate bar sweet tootsie roll I love..')
            ->setAccessHandicap(false)
            ->setWater('eau courante')
            ->setElectricity(true)
            ->setSurface(30)
            ->setRate(95.50)
            ->setNbrRoom(3)
            ->setMaxTravelers(3)
            ->setTax(0.20)
            ->setUser($this->getReference(UserFixtures::PROP_USER_REFERENCE))
            ->setTypeProperty($this->getReference(TypePropertyFixtures::INCLASSABLE_REF))
            ->setAddress($this->getReference(AddressFixture::adr_inclassable))
            ->addPicture($this->getReference(PicturesFixtures::picture_bien));
            $this->addReference(self::inclassables,$inclassables);
            $manager->persist($inclassables);
                                                // dispo 10 jours dans l'année
                                                for($i=0; $i<10; $i++){
                                                    $disponibilityEau = new Disponibility();
                                                    $disponibilityEau->setjourDispo(new \DateTime("+".$i."week now"))
                                                                ->setProperty($inclassables);
                                                    $manager->persist($disponibilityEau);
                                            }
            $bateaux = new Property();
            $bateaux->setTitle('bateaux')
            ->setDescription('très belle cabane sur l\'eau. Sit amet jelly beans pie apple pie chupa chups candy. I love candy I love pie bear claw chocolate bar sweet tootsie roll I love..')
            ->setAccessHandicap(false)
            ->setWater('eau courante')
            ->setElectricity(true)
            ->setSurface(30)
            ->setRate(95.50)
            ->setNbrRoom(3)
            ->setMaxTravelers(3)
            ->setTax(0.20)
            ->setUser($this->getReference(UserFixtures::PROP_USER_REFERENCE))
            ->setTypeProperty($this->getReference(TypePropertyFixtures::BATEAU_REF))
            ->setAddress($this->getReference(AddressFixture::adr_bateau))
            ->addPicture($this->getReference(PicturesFixtures::picture_bien));
            
                                                            // dispo 10 jours dans l'année
                                                            for($i=0; $i<10; $i++){
                                                                $disponibilityEau = new Disponibility();
                                                                $disponibilityEau->setjourDispo(new \DateTime("+".$i."week now"))
                                                                            ->setProperty($bateaux);
                                                                $manager->persist($disponibilityEau);
                                                        }
            $this->addReference(self::bateaux,$bateaux);
            $manager->persist($bateaux);

            $manager->flush();
            
        }
        
        public function getDependencies()
        {
            return array(
            UserFixtures::class,
            PicturesFixtures::class,
            TypePropertyFixtures::class,
        );
        }
}