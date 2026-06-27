<?php
namespace Tests\Unit;
use App\router;
use PHPUnit\Framework\TestCase;
class routerTest extends TestCase
{
    protected router $routert;
    public function setUp(): void
    {
        parent::setUp();
        $this->routert = new router();
    }
    public function test_the_registor_method()
    {

        $this->routert->registor('get', '/User', ['User', 'index']);
        $expected = [
            'get' => [
                '/User' => ['User', 'index']
            ]
        ];
        $this->assertEquals($expected, $this->routert->routes());
    }

    /** @test*/
    public function test_the_get_method()
    {
        $this->routert->get('/User', ['User', 'index']);
        $expected = [
            'get' => [
                '/User' => ['User', 'index']
            ]
        ];
        $this->assertEquals($expected, $this->routert->routes());
    }

    public function test_the_post_method()
    {

        $this->routert->post('/User', ['User', 'store']);
        $expected = [
            'post' => [
                '/User' => ['User', 'store']
            ]
        ];
        $this->assertEquals($expected, $this->routert->routes());
    }

    public function test_there_is_no_routes_avaliable_before_initializing()
    {
        $routert = new router();
        $this->assertEmpty($routert->routes());
    }
    #[\PHPUnit\Framework\Attributes\Test]
    #[\PHPUnit\Framework\Attributes\DataProviderExternal(\Tests\DataProvider\RouterDataProvider::class, 'routeNotFoundCases')]
    public function route_not_found_exception(string $requestUri, string $requestMethod): void
    {
        $User = new class () {
            public static function delete(): bool
            {
                return true;
            }
        };
        $this->routert->post('/User', [$User::class, 'store']);
        $this->routert->get('/User', ['User', 'index']);

        $this->expectException(\App\Exceptions\RouteNotFoundException::class);
        $this->routert->resolve($requestUri, $requestMethod);
    }
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_resolve_route_by_call_it(): void
    {
        $this->routert->get('/User', fn() => [1, 2, 3]);
        $this->assertEquals([1, 2, 3], $this->routert->resolve('/User', 'get'));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_resolve_route(): void
    {
        $User = new class () {
            public static function index(): array
            {
                return [1, 2, 3];
            }
        };
        $this->routert->get('/User', [$User::class, 'index']);
        $this->assertEquals([1, 2, 3], $this->routert->resolve('/User', 'get'));

    }
}