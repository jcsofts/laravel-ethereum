<?php
namespace Jcsofts\LaravelEthereum;

use Illuminate\Config\Repository;
use Illuminate\Support\ServiceProvider;
use Jcsofts\LaravelEthereum\Lib\Ethereum;

/**
 * Created by PhpStorm.
 * User: lee
 * Date: 11/12/2017
 * Time: 1:38 PM
 */
class EthereumServiceProvider extends ServiceProvider
{
    protected $defer = true;
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $dist = __DIR__.'/../config/ethereum.php';
        if (function_exists('config_path')) {
            // Publishes config File.
            $this->publishes([
                $dist => config_path('ethereum.php'),
            ]);
        }
        $this->mergeConfigFrom($dist, 'ethereum');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Ethereum::class, function ($app) {
            return $this->createInstance($app['config']);
        });
    }

    public function provides()
    {
        return [Ethereum::class];
    }

    protected function createInstance(Repository $config)
    {
        // Check for ethereum config file.
        if (! $this->hasConfigSection()) {
            $this->raiseRunTimeException('Missing ethereum configuration section.');
        }
        // Check for username.
        if ($this->configHasNo('host')) {
            $this->raiseRunTimeException('Missing ethereum configuration: "host".');
        }
        // check the password
        if ($this->configHasNo('port')) {
            $this->raiseRunTimeException('Missing ethereum configuration: "port".');
        }


        return new Ethereum($config->get('ethereum.host'), $config->get('ethereum.port'));

    }

    /**
     * Checks if has global ethereum configuration section.
     *
     * @return bool
     */
    protected function hasConfigSection()
    {
        return $this->app->make(Repository::class)
            ->has('ethereum');
    }

    /**
     * Checks if Nexmo config does not
     * have a value for the given key.
     *
     * @param string $key
     *
     * @return bool
     */
    protected function configHasNo($key)
    {
        return ! $this->configHas($key);
    }

    /**
     * Checks if ethereum config has value for the
     * given key.
     *
     * @param string $key
     *
     * @return bool
     */
    protected function configHas($key)
    {
        /** @var Config $config */
        $config = $this->app->make(Repository::class);
        // Check for ethereum config file.
        if (! $config->has('ethereum')) {
            return false;
        }
        return
            $config->has('ethereum.'.$key) &&
            ! is_null($config->get('ethereum.'.$key)) &&
            ! empty($config->get('ethereum.'.$key));
    }

    /**
     * Raises Runtime exception.
     *
     * @param string $message
     *
     * @throws \RuntimeException
     */
    protected function raiseRunTimeException($message)
    {
        throw new \RuntimeException($message);
    }
}