<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Wallet\Internal\Gateway\ClientGateway;
use Wallet\Internal\Gateway\AccountGateway;
use Wallet\Integration\Events\EventDispatcher;
use App\Repositories\Transaction\DBTransaction;
use Wallet\Internal\Gateway\TransactionGateway;
use App\Repositories\Elloquent\ClientElloquentRepository;
use Wallet\Integration\Events\Contracts\IEventDispatcher;
use App\Repositories\Elloquent\AccountElloquentRepository;
use App\Repositories\Elloquent\TransactionElloquentRepository;
use Wallet\Internal\Gateway\Transaction\DBTransactionInterface;

class WalletProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->bindRepositories();

        $this->app->singleton(
            DBTransactionInterface::class,
            DBTransaction::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    private function bindRepositories()
    {
        $this->app->singleton(
            AccountGateway::class,
            AccountElloquentRepository::class
        );

        $this->app->singleton(
            ClientGateway::class,
            ClientElloquentRepository::class
        );

        $this->app->singleton(
            TransactionGateway::class,
            TransactionElloquentRepository::class
        );

        $this->app->singleton(
            IEventDispatcher::class,
            EventDispatcher::class
        );
    }
}
