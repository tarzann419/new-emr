<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Tenant::create([
            'name' => 'House Teaching Hospital',
            'tenant_id' => '111000',
            'prefix' => 'HTH',
            'email' => 'house@test.com',
        ]);
        
    }
}
