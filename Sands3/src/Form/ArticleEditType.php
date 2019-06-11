<?php
/**
 * Created by PhpStorm.
 * User: Jean-baptiste
 * Date: 03/06/2019
 * Time: 10:46
 */

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('name', TextType::class,array(
                'label'=>false,
                'attr' => array('placeholder' => 'Nom')
            ))
            ->add('description', TextareaType::class,array(
                'label'=>false,
                'attr' => array('placeholder' => 'Description')
            ))
            ->add('category', EntityType::class, array(
                'class' => Category::class,
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => false
            ))
            ->add('price', MoneyType::class,array(
                'currency' => false,
                'label'=>false,
                'attr' => array('placeholder' => 'Prix')
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            'translation_domain' => 'forms'
        ]);
    }
}