<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Special\Resource_;

final class Resource_Test extends TestCase
{
    public function test_construct()
    {
        $resource = @\fopen('php://memory', 'rb');
        $res      = new Resource_($resource);
        $this->assertSame($resource, $res->getValue());
    }

    public function test_get_type()
    {
        $resource = @\fopen('php://memory', 'rb');
        $res      = new Resource_($resource);
        $this->assertSame(get_resource_type($resource), $res->get_type());
    }

    public function test_construct_exception()
    {
        $this->expectException(\ErrorException::class);
        $blah = new Resource_(new stdClass());
    }
}
