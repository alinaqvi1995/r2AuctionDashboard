<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Seller;

class SellerSeeder extends Seeder
{
    public function run()
    {
        Seller::create([
            'user_id' => 2, // adjust as needed
            'company_name' => 'Jane Smith Supplies',
            'contact_phone' => '987-654-3210',
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'business_type' => 'Electronics',
            'website' => 'http://janesmithsupplies.com',
        ]);
    }
}
