<?php

namespace Exolnet\Bento\Tests\Unit;

use Exolnet\Bento\Facades\Bento as Bento;
use Exolnet\Bento\Tests\Integration\BentoTest;

class BentoServiceProviderTest extends BentoTest
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    private $blade;

    /**
     * @return void
     * @see https://stevegrunwell.com/blog/custom-laravel-blade-directives/
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->blade = resolve('blade.compiler');
    }

    /**
     * @return void
     * @test
     */
    public function testDirectiveLaunch(): void
    {
        Bento::shouldReceive('launch')->once()->andReturn(true);

        $this->assertDirectiveOutput(
            ' ',
            '@launch($expression) @endlaunch',
            ['expression' => 'everyone'],
            'Expected to see " " printed to the screen.'
        );
    }

    /**
     * @return void
     * @test
     */
    public function testDirectiveNoLaunch(): void
    {
        Bento::shouldReceive('launch')->once()->andReturn(false);

        $this->assertDirectiveOutput(
            '',
            '@launch($expression) @endlaunch',
            ['expression' => 'everyone'],
            'Expected to see nothing printed to the screen.'
        );
    }

    /**
     * @return void
     * @test
     */
    public function testDirectiveAwait(): void
    {
        Bento::shouldReceive('await')->once()->andReturn(true);

        $this->assertDirectiveOutput(
            ' ',
            '@await($expression) @endawait',
            ['expression' => 'everyone'],
            'Expected to see " " printed to the screen.'
        );
    }

    /**
     * @return void
     * @test
     */
    public function testDirectiveNotAwait(): void
    {
        Bento::shouldReceive('await')->once()->andReturn(false);

        $this->assertDirectiveOutput(
            '',
            '@await($expression) @endawait',
            ['expression' => 'everyone'],
            'Expected to see nothing printed to the screen.'
        );
    }

    /**
     * Evaluate a Blade expression with the given $variables in scope.
     *
     * @param string $expected   The expected output.
     * @param string $expression The Blade directive, as it would be written in a view.
     * @param array  $variables  Variables to extract() into the scope of the eval() statement.
     * @param string $message    A message to display if the output does not match $expected.
     * @see https://stevegrunwell.com/blog/custom-laravel-blade-directives/
     */
    protected function assertDirectiveOutput(
        string $expected,
        string $expression = '',
        array $variables = [],
        string $message = ''
    ): void {
        $compiled = $this->blade->compileString($expression);

        /*
         * Normally using eval() would be a big no-no, but when you're working on a templating
         * engine it's difficult to avoid.
         */
        ob_start();
        extract($variables);
        eval(' ?>' . $compiled . '<?php ');
        $output = ob_get_clean();

        $this->assertEquals($expected, $output, $message);
    }
}
