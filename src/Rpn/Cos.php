<?php declare(strict_types=1);

namespace gipfl\RrdGraph\Rpn;

/**
 * Cosine (input in radians)
 */
class Cos extends ArithmeticOperator
{
    const NAME = 'COS';

    protected ?int $parameterCount = 1;
}
