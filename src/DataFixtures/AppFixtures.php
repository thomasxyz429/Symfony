<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use  App\Entity\Entreprise;
use  App\Entity\Formation;
use  App\Entity\Stage;
class AppFixtures extends Fixture
{
  public function load(ObjectManager $manager)
  {
    $faker = \Faker\Factory::create('fr_FR');
    $tabEntreprises = array();
    $tabFormations = array();
    // GENERATION DES DONNEES ENTREPRISES
    $tabNomEntreprise = array ("IBM"=>"https://upload.wikimedia.org/wikipedia/commons/5/51/IBM_logo.svg",
    "Safran"=>"https://www.infodreamgroup.fr/wp-content/uploads/2016/04/logo-safran-320x320-1.jpg",
    "Ubisoft"=>"https://upload.wikimedia.org/wikipedia/commons/6/6c/New_Ubisoft_Logo.jpg");
    $tabMileuEntreprise = array ("Programmation","Technologie embarqué","Réseau","Base de donnée","Industrie fine","Automatisation");
    $y=0;
    foreach ($tabNomEntreprise as $nomEntreprise => $logo) {
      $entreprise = new Entreprise();
      $entreprise->setIdEntreprise ($y);
      $entreprise->setNom ($nomEntreprise);
      $entreprise->setLogo($logo);
      $entreprise->setMilieu($faker->randomElement($tabMileuEntreprise));
      $entreprise->setAdresse($faker->address);
      $manager->persist($entreprise);
      $tabEntreprises[]=$entreprise;
      $y++;
    }
    // GENERATION DES DONNEES FORMATIONS
    $tabNomFormation = array ("Dut Info"=>"Bac + 2","LP Métier du Numerique"=>"bac + 3","Dut GIM"=>"Bac + 2");
    $i=0;
    foreach ($tabNomFormation as  $nomBac=>$niveauBac) {
      $formation = new Formation();
      $formation->setIdFormation ($i);
      $formation->setIntitule ($nomBac);
      $formation->setNiveau ($niveauBac);
      $formation->setVille($faker->city);
      $manager->persist($formation);
      $i++;
      $tabFormations[]=$formation;
    }


    // GENERATION DES DONNEES DE STAGE

    $tabIntitule = array ("Offre de stage","Stage pour Etudiant","Proposition de stage","Stage rémunéré");
    $tabDuree = array("5 semaines", "10 semaines","1 an" );
    $tabCompetence = array ("aucune","Base de donnee","C++","JAVA","PHP","Reseau","Android","Mecanique","Automatisation","Electronique");
    $tabExperience = array ("aucune","aumoins 1 mois","aumoins 1 ans", "plus d'un an");
    for ($i=0; $i <20 ; $i++) {
      $stage = new Stage ();
      //INITIALISATION DE CHAQUE STAGE
      $stage->setIdStage($i);
      $stage->setIntitule($faker->randomElement($tabIntitule));
      $stage->setDuree($faker->randomElement($tabDuree));
      $stage->setCompetencesRequises($faker->randomElement($tabCompetence));
      $stage->setExperienceRequise($faker->randomElement($tabExperience));
      $stage->setDateDebut($faker->date);
      $stage->setDescription($faker->realText($maxNbChars = 200, $indexSize = 2));
      //GESTION DES CLES ETRANGERES
      $numEntreprise = $faker->numberBetween($min=0,$max=2);
      $numFormation = $faker->numberBetween($min,$max);
      $stage->setEntreprise($tabEntreprises[$numEntreprise]);
      $stage->setFormation($tabFormations[$numFormation]);
      $tabEntreprises[$numEntreprise]->addStage($stage);
      $tabFormations[$numFormation]->addStage($stage);

      //ENREGISTREMENT DES MODIFICATION POUR LES CLES ETRANGERES
      $manager->persist($stage);
      $manager->persist($tabEntreprises[$numEntreprise]);
      $manager->persist($tabFormations[$numFormation]->addStage($stage));

    }
    $manager->flush();
  }
}
