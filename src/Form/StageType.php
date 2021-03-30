<?php

namespace App\Form;

use App\Entity\Stage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Formation;
use App\Entity\Entreprise;
class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idStage')
            ->add('intitule')
            ->add('dateDebut')
            ->add('duree')
            ->add('competencesRequises')
            ->add('experienceRequise')
            ->add('description')
            ->add ('formation', EntityType::class,array(
                'class' => Formation::class,
                'choice_label' => 'intitule',
                'multiple' => false,
                'expanded' => true,
              ))
            ->add('entreprise',EntrepriseType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
