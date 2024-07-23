<?php

namespace App\Form;

use App\Entity\Recipe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\String\Slugger\AsciiSlugger;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'required' => false,
            ])
            ->add('slug', TextType::class, [
                'label' => 'Slug',
                'required' => false,
            ])
            ->add('temps', NumberType::class, [
                'label' => 'Temps de préparation',
                'required' => false,
            ])
            ->add('personnes', NumberType::class, [
                'label' => 'Pour combien de personnes',
                'required' => false,
            ])
            ->add('difficulty', ChoiceType::class, [
                'choices' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                ],
                'label' => 'Niveau de difficulté',
                'required' => false,
            ])
            ->add('description', TextType::class, [
                'required' => false
            ])
            ->add('price', NumberType::class, [
                'label' => 'Prix',
                'required' => false,
            ])
            ->add('favorite', CheckboxType::class, [
                'label' => 'Favori',
                'required' => false,
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, $this->autoSlug(...)) // ... declarer al fonction sans l'éxecuter
        ;
    }

    public function autoSlug(PreSubmitEvent $event)
    {
        $data = $event->getData(); // recupere un tableau avec les valeurs du formulaire
        if (empty($data['slug'])) {
            $slugger = new AsciiSlugger();
            $slug = $slugger->slug($data['name']);
            $data['slug'] = $slug;

            $event->setData($data);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
