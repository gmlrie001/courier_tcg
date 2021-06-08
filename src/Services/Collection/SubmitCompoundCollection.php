<?php

namespace Vault\CourierTcg\Services\Collection;

use \App\Helpers\TheCourierGuyParcelPerfectAPI\Services\Auth\GetSecureToken;
use \App\Helpers\TheCourierGuyParcelPerfectAPI\Services\Auth\GetSalt;

use \App\Helpers\TheCourierGuyParcelPerfectAPI\Utilities\CourierTraits;
use App\Helpers\TheCourierGuyParcelPerfectAPI\TheCourierGuyPPAPI;

// use App\Helpers\SimpleClient;
use App\Models\Basket;


class SubmitCompoundCollection extends TheCourierGuyPPAPI
{
    use CourierTraits;

    public $email;
    public $password;

    public $base;

    public $class;
    public $method;
    public $salt;


    public function __construct($base = null)
    {
        parent::__construct();

        $this->customHeaders = [
        'Content-Type: application/json',
        'Accept: */*',
      ];

        $this->base = ('' != $base || null != $base) ? $base : $this->testBase;

        $this->email    = $this->shipmentConfig['accountInfo']['email'];
        $this->password = $this->shipmentConfig['accountInfo']['password'];
        $this->service  = $this->shipmentConfig['accountInfo']['serviceType'];
        $this->accountNumber = $this->shipmentConfig['accountInfo']['accountNumber'];
      
        return $this;
    }
}
