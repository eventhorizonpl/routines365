<?php

declare(strict_types=1);

namespace App\Tests\Doctrine;

use App\Doctrine\RandFunction;
use App\Tests\AbstractTestCase;
use Doctrine\ORM\Query\{Parser, SqlWalker};

/**
 * @internal
 */
final class RandFunctionTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $randFunction = new RandFunction('RAND');
        $this->assertInstanceOf(RandFunction::class, $randFunction);
    }

    public function testGetSql(): void
    {
        $randFunction = new RandFunction('RAND');
        $sqlWalker = $this->getMockBuilder(SqlWalker::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $this->assertIsString($randFunction->getSql($sqlWalker));
    }

    public function testParse(): void
    {
        $randFunction = new RandFunction('RAND');
        $parser = $this->getMockBuilder(Parser::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $this->assertNull($randFunction->parse($parser));
    }
}
