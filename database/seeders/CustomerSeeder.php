<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use Illuminate\Support\Str;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('th_TH');

        Customer::truncate(); // ลบข้อมูลเก่า (กันซ้ำ)

        foreach (range(1, 100) as $i) {

            $isCompany = $faker->boolean(40); // 40% เป็นบริษัท

            // ===== ชื่อ =====
            if ($isCompany) {
                $companyName = $faker->company();
                $name = $companyName;
            } else {
                $name = $faker->name();
                $companyName = null; // ใช้ null ดีกว่า '-'
            }

            // ===== เบอร์โทร (ให้สมจริงขึ้น) =====
            $phonePrefix = $faker->randomElement(['06', '08', '09']);
            $phone = $phonePrefix . $faker->numerify('########');

            // ===== เลขผู้เสียภาษี 13 หลัก (กันซ้ำ) =====
            $taxNumber = $faker->unique()->numerify('#############');

            Customer::create([
                'customer_code' => 'CUST' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'name' => $name,
                'company_name' => $companyName,
                'tax_number' => $taxNumber,
                'phone' => $phone,
                'email' => $faker->unique()->safeEmail(),
                'address' => $faker->address(),
            ]);
        }
    }
}
