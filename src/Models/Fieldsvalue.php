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
        $this->attributes['fieldable_type'] = $this->field()->form()->model ;
        dd($this->field()->form()->model);
    }

    public function field(){
        return $this->belongsTo(Fields::class);
    }

    public function fieldable(){
        return $this->morphTo();
    }
}
