<?php

namespace CauseBundle\Form;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class DonneurType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Donneur',TextType::class,[
            'required'=>false,
        ])

            ->add('cin',TextType::class,[
                'required'=>false,
            ])
            ->add('nom',TextType::class,[
                'required'=>false,
            ])

            ->add('prenom',TextType::class,[
                 'required'=>false,
            ])
            ->add('mail', EmailType::class, [
                'label' => 'mail',
                'required'=>true,
            ])
            ->add('don',MoneyType::class,[
                'required'=>false,
            ])
            ->add('numcarte',TextType::class,[
                'required'=>false,
            ])



            ->add('Donneur',EntityType::class,array(
                    'class'=>'CauseBundle:Donneur',
                    'multiple'=>false)
            );
    }/**
 * {@inheritdoc}
 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CauseBundle\Entity\Donneur'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'CauseBundle_Donneur';
    }


}
