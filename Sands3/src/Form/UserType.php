<?php
/**
 * Created by PhpStorm.
 * User: Jean-baptiste
 * Date: 31/05/2019
 * Time: 20:14
 */

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,array(
                'label'=>false,
                'attr' => array('placeholder' => 'Name')
            ))
            ->add('prenom', TextType::class,array(
                'label'=>false,
                'attr' => array('placeholder' => 'Prénom')
            ))
            ->add('email', EmailType::class,array(
                'label'=>false,
                'attr' => array('placeholder' => 'Email')
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array('label' => false,'attr' => array('placeholder' => 'Mot de passe')),
                'second_options' => array('label' => false,'attr' => array('placeholder' => 'Confirmation du mot de passe')),
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'translation_domain' => 'forms'
        ]);
    }
}