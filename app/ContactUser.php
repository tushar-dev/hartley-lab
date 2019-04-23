<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactUser extends Model
{
    protected $fillable = [
        'user_id', 'contact_id', 'is_shared'
    ];
    
    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function contact(){
        return $this->belongsTo(Contact::class);
    }
}
