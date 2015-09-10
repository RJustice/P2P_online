<?php namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mews\Captcha
 */
class Sms extends Facade {

    protected static function getFacadeAccessor() { return 'sms'; }

}