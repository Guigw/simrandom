<?php

namespace Yrial\Simrandom\Framework\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Yrial\Simrandom\Domain\Entity\RandomizerResult;
use Yrial\Simrandom\Framework\Form\Input\ResultListDTO;

class ResultList extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('resultList', EntityType::class, [
                'class' => RandomizerResult::class,
                'multiple' => true,
                'mapped' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ResultListDTO::class,
            'csrf_protection' => false,
        ]);
    }
}