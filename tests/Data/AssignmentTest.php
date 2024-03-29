<?php

namespace gipfl\Tests\RrdGraph\Data;

use gipfl\RrdGraph\Data\Assignment;
use gipfl\RrdGraph\Data\VariableName;
use gipfl\RrdGraph\DataType\IntegerType;
use gipfl\RrdGraph\Rpn\Add;
use gipfl\RrdGraph\Rpn\Multiply;
use gipfl\RrdGraph\Rpn\RpnExpression;
use gipfl\Tests\RrdGraph\TestHelpers;
use PHPUnit\Framework\TestCase;

class AssignmentTest extends TestCase
{
    use TestHelpers;

    public function testDefineAndRenderMultiplication()
    {
        $def = new Assignment('DEF', new VariableName('result'), new RpnExpression(new Multiply(), [5, 6]));
        $this->assertEquals('DEF:result=6,5,*', (string) $def);
    }

    public function testDefineAndRenderNestedExpressionWithRenamedVariables()
    {
        $def = new Assignment('DEF', new VariableName('uptime'), new RpnExpression(new Multiply(), [
            new RpnExpression(new Add(), [
                new IntegerType(10),
                new VariableName('subValue')
            ]),
            new VariableName('test')
        ]));
        $def->getRpnExpression()->renameVariable('test', 'changed')->renameVariable('subValue', 'sub');

        $this->assertEquals('DEF:uptime=changed,sub,10,+,*', (string) $def);
    }

    public function testVariableDefinitionCanBeParsedAndRendered()
    {
        $def = 'VDEF:avg=mydata,AVERAGE';
        $this->parseAndRender($def);
    }

    public function testDataCalculationDefinitionCanBeParsedAndRendered()
    {
        $def = 'CDEF:mydatabits=mydata,8,*';
        $this->parseAndRender($def);
    }

    public function testDataDefinitionCanBeParsedAndRendered()
    {
        $def = 'DEF:ds0=router.rrd:ds0:AVERAGE';
        $this->parseAndRender($def);
    }

    public function testComplexDataDefinitionCanBeParsedAndRendered()
    {
        $def = 'DEF:ds0weekly=router.rrd:ds0:AVERAGE:step=7200:start=11\:00:end=start+1h:daemon=collect1.example.com';
        $this->parseAndRender($def);
    }
}
