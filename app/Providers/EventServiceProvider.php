<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use App\User;
use App\DealOrder;
use App\UserCarry;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        User::created(function($user){
            User::createdCallback($user);
        });

        // DealOrder::created(function($dealOrder){
        //     // 计算收益
        //     DealOrder::createdCallback($dealOrder);
        // });

        DealOrder::saved(function($dealOrder){
            if( $dealOrder->isDirty('status') ){
                DealOrder::savedCallback($dealOrder);
            }
        });

        UserCarry::created(function($carry){
            // var_dump('created call');
            UserCarry::createdCallback($carry);
        });
        UserCarry::updated(function($carry){
            // var_dump('saved call');
            UserCarry::updatedCallback($carry);
        });
    }
}
