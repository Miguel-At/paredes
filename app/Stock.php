<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
const UPDATED_AT = null;
   protected $table=('llx_product_stock');
 public $timestamps = false; 
}
