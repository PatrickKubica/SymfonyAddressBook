<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ContactType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'attr' => ['class' => 'control mb-4'],
                'label_attr' => ['class' => 'label mb-0'],
            ])
            ->add('lastname', TextType::class, [
                'attr' => ['class' => 'control mb-4'],
                'label_attr' => ['class' => 'label mb-0'],
            ])
            ->add('street', TextType::class, [
                'label' => 'Street and number',
                'attr' => ['class' => 'control mb-4'],
                'label_attr' => ['class' => 'label mb-0'],
            ])
            ->add('zip', IntegerType::class, [
                'attr' => ['class' => 'control mb-4'],
                'label_attr' => ['class' => 'label mb-0'],
            ])
            ->add('city', TextType::class, [
                'attr' => ['class' => 'control mb-4'],
                'label_attr' => ['class' => 'label mb-0'],
            ])
            ->add('country', TextType::class, [
                'attr' => ['class' => 'control mb-4'],
                'label_attr' => ['class' => 'label mb-0'],
            ])
            ->add('phoneNumber', IntegerType::class, [
                'attr' => ['class' => 'control mb-4'],
                'label_attr' => ['class' => 'label mb-0'],
            ])
            ->add('birthday', BirthdayType::class, [
                'attr' => ['class' => 'control mb-4'],
                'label_attr' => ['class' => 'label mb-0'],
            ])
            ->add('emailAddress', EmailType::class, [
                'attr' => ['class' => 'control mb-4'],
                'label_attr' => ['class' => 'label mb-0'],
            ])
            ->add('picture', FileType::class, [
                'attr' => ['class' => 'control mb-4'],
                'label_attr' => ['class' => 'label mb-0'],
                'mapped' => false,
                'required' => false,
                //Improvement idea: define more constrains to limit filetypes user can upload
                'constraints' => [
                    new File([
                        'maxSize' => '4096k',
                    ]),
                ],
            ]);
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Contact',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_contact';
    }
}
