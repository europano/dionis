<?php

namespace App\Form;

use App\Entity\Page;
use App\Entity\Document;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;



class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
	        ->add('titre')
	        ->add('contenu', CKEditorType::class, [
                'config' => [
                    'uiColor' => '#ffffff',
                    //...
                ],
            ])
	        ->add('categorie', EntityType::class, [
	            'class' => Categorie::class,
	            "choice_label" => 'titre',
	            'required' => false
	            ])
		    ->add('parent', EntityType::class, [
		        'class' => Page::class,
		        "choice_label" => 'titre',
		        'required' => false
		  	])
			->add('auteur')
		    ->add('createdAt', DateTimeType::class)
		    ->add('jourAt', DateTimeType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Page::class,
        ]);
    }
}
