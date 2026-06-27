<?php
declare(strict_types=1);
namespace Tests\Unit;
use PHPUnit\Framework\TestCase;
use App\Container;
use App\Service\PaymentGatewayServiceInterface;
use App\Service\EmailService;
use App\Service\InvoiceService;


class ContainerTest extends TestCase
{

    public function test_it_can_bind_and_check_if_entry_exists(): void
    {
        $container = new Container();
        $container->set(EmailService::class, fn() => new EmailService());
        $this->assertTrue($container->has(EmailService::class));
    }


    public function test_it_can_get_a_manually_set_string_entry(): void
    {
        $container = new Container();
        $container->set(EmailService::class, fn() => new EmailService());
        $this->assertEquals(new EmailService(), $container->get(EmailService::class));
    }



    public function test_it_can_autowire_a_class_without_dependencies(): void
    {
        $container = new Container();
        $this->assertEquals(new Service(), $container->get(Service::class));
    }

    public function test_it_can_automatically_resolve_a_class_with_its_dependencies(): void
    {
        $container = new Container();
        $this->assertEquals(new client(new Service()), $container->resolve(client::class));
    }

    /**
     * Goal 6: Test exception handling for invalid targets.
     * What to do: Attempt to resolve something invalid (like an Interface that cannot be instantiated, 
     * or a class with missing type-hints). Assert that your custom `ContainerException` is thrown.
     */
    public function test_it_throws_container_exception_if_class_is_not_instantiable_or_has_invalid_params(): void
    {
        $container = new Container();
        $this->expectException(\App\Exceptions\Container\ContainerException::class);
        $container->resolve(index::class);
    }

}
class Service implements srInterface
{

}

class client
{
    public function __construct(private Service $service)
    {

    }
}
interface srInterface
{

}
class index
{
    public function __construct(private srInterface $service)
    {

    }
}

