<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',null, ['label'=>'Pseudo'])
            ->add('firstname', TextType::class, ['label'=> 'Prénom'])
            ->add('lastname', TextType::class, ['label'=> 'Nom'])
            ->add('email', EmailType::class, ['label'=>'Email'])
            ->add('telephone', TextType::class, ['label'=>'Téléphone'])
            ->add('street', TextType::class, ['label'=>'Rue'])
            ->add('postcode', TextType::class, ['label'=>'Code postal'])
            ->add('city', TextType::class, ['label'=>'Ville'])
            ->add('password', RepeatedType::class, [
                'type'=>PasswordType::class,
                'first_options'=>['label'=>'Mot de passe'],
                'second_options'=>['label'=>'Confirmation'],
                'required'=>true,
                'invalid_message'=>'les mots de passe doivent être identiques'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
