<?php

namespace App\Form;

use App\Entity\Job;
use App\Entity\Hobby;
use App\Entity\Profile;
use App\Entity\Personne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('age')
            ->add('created_at')
            ->add('updated_at')
            ->add('job', EntityType::class, [
                'class' => Job::class,
                'expanded' => true
            ])
            ->add('profile', EntityType::class, [
                'class' => Profile::class,
                'expanded' => true,
                'multiple' => false,
                'required' => false
            ])
            ->add('hobbies', EntityType::class, [
                'class' => Hobby::class,
                'expanded' => true,
                'multiple' => true,
                'choice_label' => 'designation'
            ])

            ->add('image', FileType::class, [
                'label' => 'Selectionner les fichiers images  (Uniquement les fichiers images)',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                            'image/jpeg',
                            'image/gif'
                        ],
                        'mimeTypesMessage' => 'Selectionner un fichier image s\'il vous plait !',
                    ])
                ],
            ])

            ->add("Soumettre", SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
