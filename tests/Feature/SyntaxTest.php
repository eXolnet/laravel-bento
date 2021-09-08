<?php

namespace Exolnet\Bento\Tests\Feature;

use Exolnet\Bento\Facades\Bento;
use Exolnet\Bento\Feature;
use Exolnet\Bento\Strategy\AimsStrategies;
use Exolnet\Bento\Strategy\AimsStrategy;
use Exolnet\Bento\Strategy\Strategy;
use Exolnet\Bento\Strategy\Stub;
use Exolnet\Bento\Tests\TestCase;

class SyntaxTest extends TestCase
{
    /**
     * @return void
     */
    public function testBasic(): void
    {
        $feature = Bento::feature('basic')
            ->everyone();

        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertEquals(1, $feature->countStrategies());
        $this->assertIsBool($feature->launch());
    }

    /**
     * @return void
     */
    public function testAndSyntax(): void
    {
        $feature = Bento::feature('and')
            ->user()
            ->date('2020-01-01', '>=');

        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertEquals(2, $feature->countStrategies());
        $this->assertIsBool($feature->launch());
    }

    /**
     * @return void
     */
    public function testAndSyntaxAlternative(): void
    {
        $feature = Bento::feature('and')->all(function (AimsStrategies $aims) {
            $aims
                ->environment(['local', 'testing'])
                ->date('2020-01-01');
        });

        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertEquals(1, $feature->countStrategies());
        $this->assertIsBool($feature->launch());
    }

    /**
     * @return void
     */
    public function testOrSyntax(): void
    {
        $feature = Bento::feature('or')->any(function (AimsStrategies $aims) {
            $aims
                ->environment(['local', 'testing'])
                ->date('2020-01-01');
        });

        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertEquals(1, $feature->countStrategies());
        $this->assertIsBool($feature->launch());
    }

    /**
     * @return void
     */
    public function testNotAimSyntax(): void
    {
        $feature = Bento::feature('not')->not('environment', 'production');

        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertEquals(1, $feature->countStrategies());
        $this->assertIsBool($feature->launch());
    }

    /**
     * @return void
     */
    public function testNotHigherOrderSyntax(): void
    {
        $feature = Bento::feature('not')->not->environment('production');

        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertEquals(1, $feature->countStrategies());
        $this->assertIsBool($feature->launch());
    }

    /**
     * @return void
     */
    public function testNotCallbackSyntax(): void
    {
        $feature = Bento::feature('not')->not(function (AimsStrategy $aims) {
            $aims->environment('production');
        });

        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertEquals(1, $feature->countStrategies());
        $this->assertIsBool($feature->launch());
    }

    /**
     * @return void
     */
    public function testCallback(): void
    {
        $feature = Bento::feature('callback')->callback(function () {
            return true;
        });

        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertEquals(1, $feature->countStrategies());
        $this->assertIsBool($feature->launch());
    }

    /**
     * @return void
     */
    public function testCustomStrategy(): void
    {
        $feature = Bento::feature('custom')
            ->aim(new Stub(true));

        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertEquals(1, $feature->countStrategies());
        $this->assertIsBool($feature->launch());
    }

    /**
     * @return void
     */
    public function testCustomAnonymousStrategy(): void
    {
        $feature = Bento::feature('custom')
            ->aim(new class implements Strategy {
                /**
                 * @return bool
                 */
                public function launch(): bool
                {
                    return true;
                }
            });

        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertEquals(1, $feature->countStrategies());
        $this->assertIsBool($feature->launch());
    }

    /**
     * @return void
     */
    public function testComplexStrategy(): void
    {
        $feature = Bento::feature('complex')->any(function (AimsStrategies $aims) {
            $aims
                ->environment(['local', 'testing'])
                ->all(function (AimsStrategies $aims) {
                    $aims
                        ->environment('production')
                        ->date('2020-01-01', '>=');
                });
        });

        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertEquals(1, $feature->countStrategies());
        $this->assertIsBool($feature->launch());
    }
}
