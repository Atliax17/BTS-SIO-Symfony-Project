<?php
/**
 * Created by PhpStorm.
 * User: Jean-baptiste
 * Date: 02/06/2019
 * Time: 15:09
 */

namespace App\Form;

use App\Entity\ArticleSearch;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prixMin', IntegerType::class, [
                'required' => false,
                'label' => false,
                'attr' => array('placeholder' => 'Prix minimal')
            ])
            ->add('prixMax', IntegerType::class, [
                'required' => false,
                'label' => false,
                'attr' => array('placeholder' => 'Prix maximal')
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ArticleSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}