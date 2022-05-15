<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PostType extends AbstractType
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
            ->add('title')
            ->add('mini_title')
            ->add('One_word_pov',ChoiceType::class,[
                'choices'  => [
                  'Good' => 'Good',
                  'Average' => 'Average',
                  'Bad' => 'Bad',
                ],])
            ->add('mark',ChoiceType::class,[
                'choices' => [
                  '10'=> '10',
                  '5' =>'5',
                  '1'=> '1',
                ]
              ,])
            ->add('location')
            ->add('review_article',TextareaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
