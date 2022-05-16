<?php

namespace App\Form;

use App\Entity\Plan;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PlanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageFile', VichImageType::class, [
                'label' => 'Insert Image place here',
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'delete',
                'download_uri' => false,
                'image_uri' => true,
                'imagine_pattern' => 'squard_sm'
            ])
            ->add('name')
            ->add('title')
            ->add('description',TextareaType::class)
            ->add('type',ChoiceType::class,[
                'choices'  => [
                    'Restaurant' => 'Restaurant',
                    'Museum' => 'Museeum',
                    'Park' => 'Park',
                    'Shopping' => 'Shopping'
                ],])
            ->add('rating')
            ->add('longitude')
            ->add('latitude')
            ->add('location')
            ->add('number')
            ->add('email')
            ->add('website')
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Plan::class,
        ]);
    }
}
