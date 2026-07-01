<?php
namespace App;
use App\database;
use App\CustomMailer;
use Symfony\Component\Mailer\MailerInterface;
use App\Service\PaymentGatewayServiceInterface;
use App\Service\PaymentGatewayService;
use Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
class myApp
{
   // private static database $db;
    private Config $config;
    public function __construct(
        protected \Illuminate\Container\Container $container,
        protected ?router $Routers = null,
        protected array $method = []
    ) {
    }
    public function boot(): static
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();
        $this->config = new Config($_ENV);
        //static::$db = new database($this->config->db); in eloquent use next one
        $this->intDb($this->config->db);
        //for laravel container change from set to bind
        $this->container->bind(PaymentGatewayServiceInterface::class, PaymentGatewayService::class);
        $this->container->bind(MailerInterface::class, fn() => new CustomMailer($this->config->Mailer['dsn']));
        return $this;
    }

    private function intDb(array $config)
    {
        $capsule = new Capsule;

        $capsule->addConnection($config );
        $capsule->setEventDispatcher(new Dispatcher($this->container));
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

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

    /*
    public static function DB()
    {
        return self::$db;

    }*/
}