<?php

namespace Vault\CourierTcg\Services\Checkout\Order;

use App\Helpers\TheCourierGuyParcelPerfectAPI\OrderException;
use App\Models\Basket;


class GetOrder
{
  private $cart;
  private $orderId;

  public $model;

  
  public function __construct( $orderId )
  {
    $this->model = ( new \App\Models\Basket )->query();

    $this->setOrderId( $orderId );
    $this->getOrder( $this->getOrderId() );

    return $this;
  }

  public function getOrder( $orderId )
  {
    if ( $orderId === 0 ) {
      OrderException::orderIdZeroIntegerException();
    } elseif ( $orderId < 0 ) {
      OrderException::orderIdNegativeIntegerException();
    }

    $this->setOrderId( $orderId );
    $cart = $this->shoppingCart( $this->getOrderId() );

    return $cart->getCart();
  }


  public function getOrderId()
  {
    if ( NULL == $this->orderId ) return;

    return $this->orderId;
  }

  public function setOrderId( $orderId )
  {
    $this->orderId = $orderId;

    return $this;
  }

  public function getCart()
  {
    if ( NULL == $this->cart ) return;

    return $this->cart;
  }

  public function setCart( Basket $cart )
  {
    if ( NULL == $cart || ! isset( $cart ) ) {
      OrderException::orderException( 'Must provide a valid instance of \App\Models\Basket.', 24 );
    }

    if ( ! $cart instanceof \App\Models\Basket ) {
      OrderException::orderException( 'Must be an instance of \App\Models\Basket.', 25 );
    }

    if ( ! $cart->exists ) OrderException::orderHasNoProductsException();
    // if ( $cart->products->count() > 0 ) OrderException::orderException( 'Must be an instance of \App\Models\Basket.', 25 );

    $this->cart = $cart;

    return $this;
  }

  private function shoppingCart( $orderId )
  {
    if ( ! $orderId || ! is_integer( $orderId ) ) {
      OrderException::orderIdNotSetException();
    }

    $this->setOrderId( $orderId );

    $basket = new \App\Models\Basket();
    try {
      $basket = $basket->findOrFail( $this->getOrderId() );
    } catch ( \Exception $error ) {}

    $cart = $this->setCart( $basket )->getCart();

    return $this;
  }


}