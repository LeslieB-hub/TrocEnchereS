<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Sale;
use App\Entity\Withdrawal;
use phpDocumentor\Reflection\Types\Collection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SaleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $withdrawalPlace = $options['withdrawalPlace'];
        $builder
            ->add('item', null, [
                'label' => 'Article :'
            ])
            ->add('description', TextareaType::class,[
                'label'=> 'Description :'
            ])
            ->add('startDateBid', DateType::class,[
                'label'=> 'Début de l\'enchère :',
                'required'  => true,
                'widget'    => 'single_text',
            ])
            ->add('endDateBid',DateType::class,[
                'label'=> 'Fin de l\'enchère :',
                'required'  => true,
                'widget'    => 'single_text',
            ])
            ->add('initialPrice', NumberType::class, [
                'label'=> 'Mise à prix :'
            ])

            ->add('category', EntityType::class, [
                'label'=> 'Catégorie :',
                'class'=> Category::class,
                'choice_label'=> 'name',
                'placeholder' => 'Sélectionnez une catégorie'
            ])
            ->add('withdrawalPlace', EntityType::class, [
                'label'=> 'Retrait :',
                'class'=> Withdrawal::class,
            ])
            /*->add('seller', EntityType::class, [
                'label' => 'Vendeur :',
                'class' => User::class
            ])
            ->add('salePrice', NumberType::class, [
                'label'=> 'Meilleur offre :'
            ])*/
            //->add('state')
            ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
            ->getForm()
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sale::class,
        ]);
        $resolver->setRequired([
            'withdrawalPlace',
        ]);
    }
}
