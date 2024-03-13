<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueAuthorInArticleValidator extends ConstraintValidator
{
    
    public function validate($value, Constraint $constraint)
    {
        $articles = $value->getNews();

        foreach ($articles as $article) {
            if ($article->getId() === $constraint->news->getId()) {
                $this->context->buildViolation($constraint->message)
                    ->addViolation();
                break;
            }
        }
    }
}