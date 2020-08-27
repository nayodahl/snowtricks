<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IsYoutubeUrl extends Constraint
{
    public $message = 'Adresse invalide "{{ string }}" : l\'url de la vidéo doit être au format embed';
}
