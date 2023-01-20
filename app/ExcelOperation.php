<?php
 
namespace App;
 
use Illuminate\Database\Eloquent\Model;
 
class ExcelOperation extends Model
{
	protected $table = 'order_custom_table';
    public $guarded = [];
    public $timestamps=false;
}