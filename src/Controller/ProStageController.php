<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Entity\Formation;
use App\Entity\Entreprise;
use App\Repository\StageRepository ;
use App\Repository\FormationRepository ;
use App\Repository\EntrepriseRepository ;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\EntrepriseType;
use App\Form\StageType;
class ProStageController extends AbstractController
{
  /**
  * @Route("/", name="pro_stage")
  */
  public function index(StageRepository $repositoryStages, FormationRepository $repositoryFormation ,EntrepriseRepository $repositoryEntreprises): Response
  {
      $NomFormations=$repositoryFormation->findByNom();
      $NomEntreprises=$repositoryEntreprises->findByNom();
    //RECUERER LES STAGES
    $stages=$repositoryStages->findByAccueilEtEntreprise();
    //ENVOYER LES STAGES
    return $this->render('pro_stage/index.html.twig', ["stages"=>$stages,"nomFormations"=> $NomFormations,"nomEntreprises"=>$NomEntreprises]);
  }

    /**
    * @Route("/entreprises/{idEntreprise}", name="pro_stage_entreprises_avec_id")
    */
    public function affichageEntreprisesAvecId(StageRepository $repositoryStages, $idEntreprise): Response
    {
      $stages=$repositoryStages->findByEntreprise($idEntreprise);
      return $this->render('pro_stage/affichageEntreprises.html.twig', [
        'stages'=>$stages ,'idEntreprise'=>$idEntreprise]);
    }
      /**
      * @Route("/formations/{idFormation}", name="pro_stage_formations_avec_id")
      */
      public function affichageFormationsAvecId(StageRepository $repositoryStages, $idFormation): Response
      {
      $stages = $repositoryStages->findByFormation($idFormation);
        return $this->render('pro_stage/affichageFormations.html.twig', [
          'idFormation'=>$idFormation, 'stages'=>$stages ]);
      }

        /**
        * @Route("/stages/{id}", name="pro_stage_stages")
        */
        public function affichageStages(Stage $stage): Response
        {
          return $this->render('pro_stage/affichageStages.html.twig', ['stage'=>$stage]);
        }

        /**
        * @Route("/admin/entreprise/ajouter", name="pro_stage_ajouterentreprise")
        */
        public function ajouterEntreprise( Request $request, EntityManagerInterface $manager)
        {
          // Creation d'une entreprise vierge qui sera remplie par le Formulaire
          $entreprise = new Entreprise();

          //Creation d'un formulaire
          $formulaireEntreprise= $this->createForm(EntrepriseType::class, $entreprise);

          $formulaireEntreprise->handleRequest($request);
          if ($formulaireEntreprise->isSubmitted()&& $formulaireEntreprise->isValid()) {
          //Enregistrer en Base de Données
          $manager->persist($entreprise);
          $manager->flush();
          //Rediriger sur la page d'acceuil
          return $this->redirectToRoute('pro_stage');
          }
          //afficher la page presentant le formulaire pour ajouter une entreprise
          return $this->render('pro_stage/ajouterModifierEntreprise.html.twig',['vueFormulaireEntreprise' => $formulaireEntreprise->createView(),'objectif'=>"d'ajout"]);
        }


        /**
        * @Route("/entreprise/modifier/{id}", name="pro_stage_modifierentreprise")
        */
        public function modifierEntreprise( Request $request, EntityManagerInterface $manager , Entreprise $entreprise)
        {

          //Reecuperer en bd la sessource a modifier
          //Creation d'un formulaire
          $formulaireEntreprise= $this->createForm(EntrepriseType::class,$entreprise);
          $formulaireEntreprise->handleRequest($request);
          if ($formulaireEntreprise->isSubmitted()&& $formulaireEntreprise->isValid()) {
          //Enregistrer en Base de Données
          $manager->persist($entreprise);
          $manager->flush();

          //Rediriger sur la page d'acceuil
          return $this->redirectToRoute('pro_stage');
          }


          //afficher la page presentant le formulaire pour ajouter une entreprise
          return $this->render('pro_stage/ajouterModifierEntreprise.html.twig',['vueFormulaireEntreprise' => $formulaireEntreprise->createView(),'objectif'=>"de modification"]);
        }

        /**
        * @Route("/entreprises", name="pro_stage_entreprises")
        */
        public function affichageToutesEntreprises(EntrepriseRepository $repositoryEntreprises): Response
        {
          $Entreprises=$repositoryEntreprises->findall();
          return $this->render('pro_stage/affichageAllEntreprises.html.twig', [
            'Entreprises'=>$Entreprises ]);
        }

        /**
        * @Route("/admin/stage/ajout", name="pro_stage_stages_ajout")
        */
        public function ajouterStage(Request $request, EntityManagerInterface $manager): Response
        {

          // Creation d'une entreprise vierge qui sera remplie par le Formulaire
          $stage = new Stage();
          //Creation d'un formulaire
          $formulaireStage= $this->createForm(StageType::class, $stage);

          $formulaireStage->handleRequest($request);
          if ($formulaireStage->isSubmitted()&& $formulaireStage->isValid()) {
          //Enregistrer en Base de Données
          $manager->persist($stage);
          $manager->flush();
          //Rediriger sur la page d'acceuil
          return $this->redirectToRoute('pro_stage');
          }
          //afficher la page presentant le formulaire pour ajouter une entreprise

          return $this->render('pro_stage/ajouterStage.html.twig', ['vueFormulaireStage' => $formulaireStage->createView()]);
        }
}
