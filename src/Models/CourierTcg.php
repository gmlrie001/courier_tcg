<?php

namespace Vault\CourierTcg\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use App\Traits\LocalScopes;

class CourierTcg extends Model
{
    use SoftDeletes, LocalScopes;

    public $orderable = true;
    public $orderField = 'order';
    public $titleField = 'title';
    public $statusField = 'status';
    public $hasStatus = true;
    public $orderDirection = 'order';
    public $parentOrder = '';
    public $parentTable = '';
    public $orderOptions = ['created_at', 'title', 'order'];
    public $relationships = [
      'courier_tcg_addresses'      => 'addresses', 
      'courier_tcg_accounts'       => 'accounts', 
      'courier_tcg_pickup_details' => 'pickupdetails', 
    ];
    public $mainDropdownField = '';
    public $imageDropdownField = '';

    /**
     * The relationships that should be eagerly loaded.
     *
     * @var array
     */
    protected $with = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    
    public $fields = [
      // ['field_name', 'label', 'field_type', 'options_model', 'options_relationship', 'width', 'height', 'container_class', 'can_remove'],
      /**
       * For all possible fields check: resources/views/includes/vault/fields/...
       *   eg. Add a text_input field with name of title:
       *       ['title', 'Title/Placeholder', 'text', '', '', '', '', 'col-xs-12 col-md-6', ''],
       */
    ];

    /**
     * Relationship addresses
     */
    public function addresses()
    {
      return $this->hasMany( CourierTcgAddress::class, 'courier_tcg_id' );
    }

    /**
     * Relationship accounts
     */
    public function accounts()
    {
      return $this->hasMany( CourierTcgAccount::class, 'courier_tcg_id' );
    }

    /**
     * Relationship pickupdetails
     */
    public function pickupdetails()
    {
      return $this->hasMany( CourierTcgPickup::class, 'courier_tcg_id' );
    }

     /**
      * Model mutator functions
      */
    // public function {{mutator}}()
    // {
    //   return $this->first_name . ' ' . $this->last_name;
    // }

    /**
     * Model accessor functions
     */
     // public function {{accessor}}( $modelColumnName )
     // {
     //   return $this->attributes['{$modelColumnName}'];
     // }

    /**
     * Model event/booting functions:
     *  Events include:
     *    -> creating, 
     *    -> created,  
     *    -> saving, 
     *    -> saved, 
     *    -> deleting, 
     *    -> deleted, 
     */
    // public static function booting()
    // {
    //   return;
    // }

}
