<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class IsYoutubeUrlValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof IsYoutubeUrl) {
            throw new UnexpectedTypeException($constraint, IsYoutubeUrl::class);
        }

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) take care of that
        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            // throw this exception if your validator cannot handle the passed type so that it can be marked as invalid
            throw new UnexpectedValueException($value, 'string');
            // separate multiple types using pipes
            // throw new UnexpectedValueException($value, 'string|int');
        }
        // regex : ^https\:\/\/www\.youtube\.com\/embed\/[a-zA-Z0-9_-]{11}$
        // to have an adresse of this type only : https://www.youtube.com/embed/JKgkWrinKqc

        if (!preg_match('/^https\:\/\/www\.youtube\.com\/embed\/[a-zA-Z0-9_-]{11}$/', $value, $matches)) {
            // the argument must be a string or an object implementing __toString()
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }
}
