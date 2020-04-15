<?php

namespace CauseBundle\Form;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class CauseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Cause',TextType::class,[
            'required'=>false,
        ])

            ->add('description',TextType::class,[
                'required'=>false,
            ])
            ->add('goals',MoneyType::class,[
                'required'=>false,
            ])
            ->add('etat',ChoiceType::class,
                array('choices'=>array
                (   'disponible'=>"disponible",
                    'non disponible'=>"non disponible",

                ),))
            ->add('img', VichFileType::class, [
                'required' => false,
                'allow_delete' => true,
                'download_link' => true
            ])
            ->add('Cause',EntityType::class,array(
                    'class'=>'CauseBundle:Cause',
                    'multiple'=>false)
            );
    }/**
 * {@inheritdoc}
 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CauseBundle\Entity\Cause'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'CauseBundle_Cause';
    }


}
