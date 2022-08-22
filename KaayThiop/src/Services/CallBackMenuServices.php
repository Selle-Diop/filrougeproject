<?php

namespace App\Services;

use Symfony\Component\Validator\Context\ExecutionContextInterface;


class CallBackMenuServices
{

    public static function validate($object, ExecutionContextInterface $context, $payload)
{
    // somehow you have an array of "fake names"
    // $fakeNames = [/* ... */];

    // check if the name is actually a fake name
    if (empty($object->getMenuTailles()[0]) && empty($object->getFriteBoissons()[0])) {
        

        $context->buildViolation('This menu must contains au moins one complement ')
            // ->atPath('firstName')
            ->addViolation()
        ;
    }
}

}
