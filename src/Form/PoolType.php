<?php

namespace App\Form;

use App\Entity\Personnage;
use Doctrine\ORM\QueryBuilder;
use App\Repository\PersonnageRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class PoolType extends AbstractType
{
    public function __construct(
        private PersonnageRepository $personnageRepository,
        private RequestStack $requestStack
    ) {
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $poolSession = 'personnages_pool';
        $session = $this->requestStack->getSession();
        $pool = $session->get($poolSession);

        if ($pool === null) {
            $pool = $this->personnageRepository->findRandomPool(5);
            $session->set($poolSession, $pool);
        }

        $builder
            ->add('equipeA', EntityType::class, [
                'class' => Personnage::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Équipe A - Choisissez exactement 3 personnages',
                'choices'       => $pool,
                'choice_value'  => 'id',
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
