<?php

namespace App\Form;

use App\Entity\Personnage;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PoolType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('equipeA', EntityType::class, [
                'class' => Personnage::class,
                'choice_label' => 'name',          // ou 'getName()' si c'est une méthode
                'multiple' => true,
                'expanded' => true,            // → checkboxes !
                'label' => 'Équipe A - Choisissez exactement 2 personnages',
                'constraints' => [
                    new Count([
                        'min' => 2,
                        'max' => 2,
                        'minMessage' => 'Il faut exactement 2 personnages',
                        'maxMessage' => 'Il faut exactement 2 personnages',
                    ]),
                ],
                'attr' => ['class' => 'equipe-checkboxes'],
            ])

            ->add('equipeB', EntityType::class, [
                'class' => Personnage::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Équipe B - Choisissez exactement 2 personnages',
                'constraints' => [
                    new Count([
                        'min' => 2,
                        'max' => 2,
                        'minMessage' => 'Il faut exactement 2 personnages',
                        'maxMessage' => 'Il faut exactement 2 personnages',
                    ]),
                ],
                'attr' => ['class' => 'equipe-checkboxes'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,  // pas de data_class car on n'a pas d'objet
        ]);
    }
}
