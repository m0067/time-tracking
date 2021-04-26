<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add(
                'comment',
                TextareaType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'date',
                DateType::class,
                [
                    'input' => 'datetime_immutable',
                ]
            )
            ->add(
                'timeSpent',
                IntegerType::class,
                [
                    'label' => 'Time spent (in minutes)',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Task::class,
            ]
        );
    }
}
