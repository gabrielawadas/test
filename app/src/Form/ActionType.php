<?php
/**
 * Action Type.
 */

namespace App\Form;
use App\Entity\Action;
use App\Entity\Wallet;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormTypeInterface;




/**
 * Class ActionType.
 */
class ActionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'name',
            TextType::class,
            ['label'=>'label_name']);
        $builder->add(
            'amount',
            TextType::class,
            ['label'=>'label_amount']
            );
        $builder->add(
            'wallet',
            EntityType::class,
            ['label'=>'label_wallet',
                'class' => Wallet::class,
                'choice_label' => 'name',
                'placeholder'=>'']
            );
        $builder->add(
            'category',
            EntityType::class,
            ['label'=>'label_category',
                'class' => Category::class,
                'choice_label' => 'name',
                'placeholder'=>'']
        );


        $builder->add(
            'date',
            DateType::class,
            ['label'=>'label_date']

        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Action::class,
        ]);
    }
}
