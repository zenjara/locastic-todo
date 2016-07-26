<?php
/**
 * Created by PhpStorm.
 * User: IvanMatas
 * Date: 7/18/2016
 * Time: 8:56 PM
 * []{}@
 */

namespace MtsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("email", EmailType::class)
            ->add("plainPassword", PasswordType::class,array("label"=>"Password"))
            ->add("firstName", TextType::class)
            ->add("lastName", TextType::class);

    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            "data_class" => 'MtsBundle\Entity\Korisnik',
        ));
    }
}