<?php
/**
 * Created by PhpStorm.
 * User: Jean-baptiste
 * Date: 06/06/2019
 * Time: 17:30
 */

namespace App\Form;

use App\Entity\Livraison;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivraisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('adresse', TextType::class,array(
                'label'=>false,
                'attr' => array('placeholder' => 'Adresse')
            ))
            ->add('codepostal', IntegerType::class,array(
                'label'=>false,
                'attr' => array('placeholder' => 'Description')
            ))
            ->add('ville', TextType::class,array(
                'label'=>false,
                'attr' => array('placeholder' => 'Ville')
            ))
            ->add('tel', TextType::class,array(
                'label'=>false,
                'attr' => array('placeholder' => 'Téléphone')
            ))
            ->add('complement', TextareaType::class,array(
                'label'=>false,
                'attr' => array('placeholder' => 'Complément'),
                'required' => false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Livraison::class,
            'translation_domain' => 'forms'
        ]);
    }
}