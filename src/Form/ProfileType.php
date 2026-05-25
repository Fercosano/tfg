<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Nombre de Jugador (Alias)',
                'required' => false,
                'attr' => ['class' => 'input-gamer', 'placeholder' => 'Ej: Neo, Trinity, Morpheus...']
            ])
            ->add('avatar', ChoiceType::class, [
                'label' => 'Elige tu Avatar',
                'choices'  => [
                    '🤖 Robot Clásico' => 'bottts',
                    '🐱 Gato Cibernético' => 'bottts-1',
                    '👁️ Cíclope' => 'bottts-2',
                    '💀 Calavera Hacker' => 'bottts-3',
                    '👾 Alienígena' => 'bottts-4',
                    '👤 Humano' => 'avataaars',
                    '🧑‍🎤 Rebelde' => 'avataaars-1',
                    '🕵️ Agente Especial' => 'avataaars-2',
                ],
                'required' => false,
                'expanded' => false,
                'multiple' => false,
                'attr' => ['class' => 'input-gamer bg-[#1f2833] text-white p-3 rounded-lg border border-[#45a29e] w-full mt-2']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
