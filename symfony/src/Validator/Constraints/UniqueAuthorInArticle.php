<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class UniqueAuthorInArticle extends Constraint
{
    public $message = 'This Author is already associated with the article.';
}
