<?php

namespace App\Form;

use DateTime;
use App\Entity\Space;

use App\Entity\Reservation;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;



class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateArrivee', DateType::class, [
                'widget' => 'single_text',
                /*'format' => 'yyyy-MM-dd',*/
                /*'constraints' => [
                    new NotBlank(),
                    new DateTime(),
                ]*/
                'data' => new DateTime(),
                'attr' => [
                    'min' => (new DateTime())->format('yyyy-MM-dd')
                ]
                ])
            ->add('dateDepart', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd'
                /*'constraints' => [
                    new NotBlank(),
                    new DateTime(),
                    new Callback(function($object, ExecutionContextInterface $context) {
                        $start = $context->getRoot()->getData()['dateArrivee'];
                        $stop = $object;
        
                        if (is_a($start, DateTime::class) && is_a($stop, DateTime::class)) {
                            if ($stop->format('U') - $start->format('U') < 1) {
                                $context
                                    ->buildViolation('La date de départ doit être supérieure à la date d\'arrivée')
                                    ->addViolation();
                            }
                        }
                    }),
                ],*/
                /*'attr' => [
                    'min' => date('now')
                ]*/
                ])
            ->add('nbPersonnes', IntegerType::class, [
                'attr' => [
                    'min' => 1,
                    'max' => 200
                ]
            ])
            ->add('space', EntityType::class, [
                'class' => Space::class,
                'placeholder' => "Choississez un espace",
                'choice_label' => 'nom'
                ])
            ->add('envoyer', SubmitType::class, [
                'label' => "Réserver"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
