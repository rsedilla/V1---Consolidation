<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'birthday',
        'email',
        'phone',
        'address',
        'status_id',
        'member_type_id',
        'g12_leader_id',
        'consolidator'
    ];

    public function memberType()
    {
        return $this->belongsTo(MemberType::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function g12Leader()
    {
        return $this->belongsTo(G12Leader::class);
    }

    public function sundayServices()
    {
        return $this->hasMany(SundayService::class);
    }

    public function cellGroups()
    {
        return $this->hasMany(CellGroup::class);
    }

    public function startUpYourNewLife()
    {
        return $this->hasMany(StartUpYourNewLife::class);
    }
}
