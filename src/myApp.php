<?php
namespace App;
use App\database;
class myApp
{
    private static database $db;
    // public static Container $Container;
    public function __construct(protected Container $container, protected router $Routers, protected array $method, protected Config $config)
    {
        static::$db = new database($config->db);
        $this->container->set(
            Service\PaymentGatewayServiceInterface::class,
            Service\PaymentGatewayService::class
            //fn(Container $c) => $c->get(Service\PaymentGatewayService::class)
        );


        /*  static::$Container = new Container;
          static::$Container->set(Service\InvoiceService::class, function (Container $c) {
              return new Service\InvoiceService(
                  $c->get(Service\SalesTaxService::class),
                  $c->get(Service\PaymentGatewayService::class),
                  $c->get(Service\EmailService::class)
              );
          });

          static::$Container->set(Service\SalesTaxService::class, fn() => new Service\SalesTaxService());
          static::$Container->set(Service\PaymentGatewayService::class, fn() => new Service\PaymentGatewayService());
          static::$Container->set(Service\EmailService::class, fn() => new Service\EmailService());*/

    }

    public static function DB()
    {
        return self::$db;

    }

    public function run()
    {
        try {
            echo $this->Routers->resolve(
                $this->method['uri'],
                strtolower(
                    $this->method['req']
                )
            );
        } catch (RouteNotFoundException) {
            //header("HTTP/1.0 404 Not Found");
            http_response_code(404);
            echo View::make('Errors/404')->render();
        }

    }
}