<?php
namespace App;
use App\database;
use App\CustomMailer;
use Symfony\Component\Mailer\MailerInterface;
use App\Service\PaymentGatewayServiceInterface;
use App\Service\PaymentGatewayService;
use Dotenv\Dotenv;
class myApp
{
    private static database $db;
    private Config $config;
    public function __construct(
        protected Container $container,
        protected ?router $Routers = null,
        protected array $method = []
    ) {
    }
    public function boot(): static
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();
        $this->config = new Config($_ENV);
        static::$db = new database($this->config->db);
        $this->container->set(PaymentGatewayServiceInterface::class, PaymentGatewayService::class);
        $this->container->set(MailerInterface::class, fn() => new CustomMailer($this->config->Mailer['dsn']));
        return $this;
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