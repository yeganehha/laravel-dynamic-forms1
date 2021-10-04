<?php

namespace Yeganehha\DynamicForms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fieldsvalue extends Model
{
    protected $fillable = ['field_id','fieldable_id','value'];


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if ( $this->field()->get()->toArray() != null ){
            dd($this->field()->get()->toArray());
            $this->attributes['fieldable_type'] = $this->field()->get()->form()->get()->model ;
        }
    }

    public function field(){
        return $this->belongsTo(Fields::class);
    }

    public function fieldable(){
        return $this->morphTo();
    }
}
