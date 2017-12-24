<?php

namespace Pyrech\DoNotExposeYourSymfony\Tests\functional;

use Pyrech\DoNotExposeYourSymfony\Tests\functional\fixtures\src\Kernel;
use Symfony\Component\HttpFoundation\Request;

class TestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_does_something()
    {
        $kernel = new Kernel('prod', true);
        $kernel->boot();

        $request = Request::create('/');
        $response = $kernel->handle($request);

        self::assertSame(404, $response->getStatusCode());
    }
}
