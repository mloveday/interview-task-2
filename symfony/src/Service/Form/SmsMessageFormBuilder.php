<?php

namespace App\Service\Form;

use App\Entity\RabbitMq\SmsMessage;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormFactoryInterface;

class SmsMessageFormBuilder
{
    /** @var FormFactoryInterface */
    private $formFactory;

    /**
     * SmsMessageFormBuilder constructor.
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function createSmsMessageForm()
    {
        $message = (new SmsMessage())->setBody('')->setRecipient('');
        return $this->formFactory->createNamedBuilder(null, FormType::class, $message, [])
            ->add('recipient', TextType::class)
            ->add('body', TextType::class)
            ->add('send', SubmitType::class, ['label' => 'Send SMS'])
            ->getForm();
    }
}