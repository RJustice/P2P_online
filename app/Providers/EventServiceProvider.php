<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use App\User;
use App\DealOrder;
use App\UserCarry;
use App\OrderToRedeem;

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

        session(['count'=>1]);

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
            if( $dealOrder->isDirty('order_status') && $dealOrder->order_status == \App\DealOrder::ORDER_STATUS_FINISHED ){
                DealOrder::OrderStatusCallback($dealOrder);
            }
        });

        UserCarry::created(function($carry){
            UserCarry::createdCallback($carry);
        });
        
        UserCarry::updated(function($carry){
            if( $carry->isDirty('status') ){
                UserCarry::updatedCallback($carry);
            }
        });

        OrderToRedeem::created(function($orderToRedeem){
            OrderToRedeem::createdCallback($orderToRedeem);
        });

        OrderToRedeem::saved(function($orderToRedeem){
            if( $orderToRedeem->isDirty('status') && $orderToRedeem->status == OrderToRedeem::STATUS_PASSED ){
                OrderToRedeem::passedCallback($orderToRedeem);
            }
            if( $orderToRedeem->isDirty('status') && $orderToRedeem->status == OrderToRedeem::STATUS_UNPASSED ){
                OrderToRedeem::unpassCallback($orderToRedeem);
            }
        });
    }
}
