<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'user_type',
        'first_name',
        'last_name',
        'business_type',
        'company_legal_name',
        'phone',
        'whatsapp',
        'website',
        'resale_business_type',
        'hear_about_us',
        'monthly_purchasing_ability',
        'billing_address1',
        'billing_address2',
        'billing_city',
        'billing_state',
        'billing_zip',
        'billing_country',
        'same_as_billing',
        'shipping_address1',
        'shipping_address2',
        'shipping_city',
        'shipping_state',
        'shipping_zip',
        'shipping_country',
        'account_first_name',
        'account_last_name',
        'account_phone',
        'account_email',
        'account_same_as_primary_contact',
        'shipping_first_name',
        'shipping_last_name',
        'shipping_phone',
        'shipping_email',
        'shipping_same_as_primary_contact',
        'payment_method',
        'bank_name',
        'account_title',
        'security_deposit',
        'business_license',
        'address_proof',
        'owner_eid',
        'security_deposit_slip',
        'tra_certificate',
        'r2_certificate',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }
}
