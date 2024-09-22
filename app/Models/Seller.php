<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seller extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'user_type',
        'company_name',
        'contact_phone',
        'first_name',
        'last_name',
        'linkedIn',
        'whatsapp',
        'website',
        'hear_about_us',
        'company_address',
        'company_city',
        'company_state',
        'company_zip',
        'company_country',
        'bank_name',
        'bank_address',
        'bank_benificiary_name',
        'account_number',
        'iban_number',
        'swift_code',
        'business_type',
        'business_license',
        'address_proof',
        'owner_eid',
        'tra_certificate',
        'bank_swift_letter',
        'company_cont_address',
        'company_terms_conditions',
        'company_grading_policy',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }

    public function gradingPolicies()
    {
        return $this->hasMany(SellerGradingPolicy::class, 'seller_id', 'id');
    }
}
