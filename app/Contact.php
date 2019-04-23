<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ContactUser;
class Contact extends Model
{
    protected $fillable = [
        'first_name','middle_name','last_name', 'primary_phone_no','secondary_phone_no','email', 'contact_image'
    ];
   
}
