<?php

namespace App\Validator;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

class FormValidator
{
    public function nameField(string $string)
    {
        $validator = Validation::createValidator();
        $array = ['name' => $string ];
        $constraints = new Assert\Collection([
            'name' => [new Assert\NotBlank(), new Assert\Length(['min' => 2]), new Assert\Length(['max' => 255])],
        ]);
        $violations = $validator->validate($array, $constraints);
        $errors = [];
        foreach ($violations as $violation) {
            $errors[] = $violation->getMessage();
        }
        
        return $errors;
    }

    public function contentField(string $string)
    {
        $validator = Validation::createValidator();
        $array = ['name' => $string ];
        $constraints = new Assert\Collection([
            'name' => [new Assert\NotBlank(), new Assert\Length(['min' => 2]), new Assert\Length(['max' => 3000])],
        ]);
        $violations = $validator->validate($array, $constraints);
        $errors = [];
        foreach ($violations as $violation) {
            $errors[] = $violation->getMessage();
        }
        
        return $errors;
    }

    public function authorsField(array $array)
    {
        $validator = Validation::createValidator();
        $array = ['authors' => $array ];
        $constraints = new Assert\Collection([
            'authors' => [new Assert\NotBlank()],
        ]);
        $violations = $validator->validate($array, $constraints);
        $errors = [];
        foreach ($violations as $violation) {
            $errors[] = $violation->getMessage();
        }
        
        return $errors;
    }

    public function idField(int $id)
    {
        $validator = Validation::createValidator();
        $array = ['id' => $id ];
        $constraints = new Assert\Collection([
            'id' => [new Assert\Type("integer")],
        ]);
        $violations = $validator->validate($array, $constraints);
        $errors = [];
        foreach ($violations as $violation) {
            $errors[] = $violation->getMessage();
        }
        
        return $errors;
    }
}
