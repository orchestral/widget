<?php

namespace Orchestra\Widget\Tests\Unit;

use Orchestra\Widget\WidgetServiceProvider;
use PHPUnit\Framework\TestCase;

class WidgetServiceProviderTest extends TestCase
{
    /** @test */
    public function it_deferred_the_service_registration()
    {
        $stub = new WidgetServiceProvider(null);

        $this->assertTrue($stub->isDeferred());
    }

    /** @test */
    public function it_provides_expected_services()
    {
        $stub = new WidgetServiceProvider(null);

        $this->assertContains('orchestra.widget', $stub->provides());
    }
}
