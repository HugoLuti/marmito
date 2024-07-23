<?php

namespace App\Form;

use App\Entity\Recette;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\String\Slugger\AsciiSlugger;

class RecetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'required' => false
            ])
            ->add('slug', TextType::class, [
                'required' => false
            ])
            ->add('temps', NumberType::class, [
                'required' => false
            ])
            ->add('nbPersonne', IntegerType::class, [
                'attr' => [
                    'min' => 1,
                    'max' => 50,
                ],
                'required' => false
            ])
            ->add('difficulte', ChoiceType::class, [
                'choices' => [
                    'Très Facile' => 1,
                    'Facile' => 2,
                    'Intermédiaire' => 3,
                    'Difficile' => 4,
                    'Expert' => 5,

                ],
                'required' => false
            ])
            ->add('description', TextareaType::class, [
                'required' => false
            ])
            ->add('prix', NumberType::class, [
                'required' => false
            ])
            ->add('favorie', CheckboxType::class, [
                'required' => false
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, $this->autoSlug(...));
    }

    public function autoSlug(PreSubmitEvent $event)
    {
        $data = $event->getData();
        if (empty($data['slug'])) {
            $slugger = new AsciiSlugger();
            $slug = $slugger->slug($data['nom'])->lower();
            $data['slug'] = $slug;

            $event->setData($data);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recette::class,
        ]);
    }
}
