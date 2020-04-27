<?php

declare(strict_types=1);


namespace App\Validation;

/** Безобразно упрощенный валидатор, просто чтоб показать намеряния. */
class Validator implements ValidationInterface
{
    /**
     * @param string $category
     * @param string $type
     * @throws ValidationException
     */
    public function validate(string $category): void
    {
        if (!preg_match('/[0-9]{5}/', $category) || (int)$category <= 0) {
            throw new ValidationException('Category is not valid');
        }
    }

}