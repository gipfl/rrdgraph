<?php declare(strict_types=1);

namespace gipfl\RrdGraph\Rpn;

abstract class BooleanOperator extends Operator
{
    protected ?int $parameterCount = 2;
}
