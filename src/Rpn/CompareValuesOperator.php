<?php declare(strict_types=1);

namespace gipfl\RrdGraph\Rpn;

abstract class CompareValuesOperator extends Operator
{
    protected ?int $parameterCount = 2;
}
