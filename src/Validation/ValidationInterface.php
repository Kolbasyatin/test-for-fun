<?php


namespace App\Validation;

interface ValidationInterface
{
    /**
     * @param string $category
     * @return mixed
     * @throws ValidationException
     */
    public function validate(string $category);
}