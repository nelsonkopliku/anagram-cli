<?php

namespace App\Validator;

use App\AnagramSource;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AnagramSourceValidator
 * @package App\Validator
 */
class AnagramSourceValidator
{

    private const MAX_LENGTH = 1024;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * AnagramSourceValidator constructor.
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param AnagramSource $source
     * @return ConstraintViolationListInterface
     */
    public function validate(AnagramSource $source) : ConstraintViolationListInterface
    {
        return $this->validator->validate($source->getInput(), [
            new Length(['max' => static::MAX_LENGTH, 'maxMessage' => 'Argument too long, maximum allowed {{ limit }}']),
        ]);
    }
}