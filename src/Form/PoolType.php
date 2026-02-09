<?php

namespace App\Form;

use App\Entity\Personnage;
use App\Repository\PersonnageRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\OptionsResolver\OptionsResolver;


class PoolType extends AbstractType
{
    public function __construct(
        private PersonnageRepository $personnageRepository
    ) {
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('equipeA', EntityType::class, [
                'class' => Personnage::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Équipe A - Choisissez exactement 2 personnages',
                'choices' => $this->personnageRepository->findRandomPool(5),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
