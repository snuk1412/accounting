<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
{
    Account::insert([

        /** ================== สินทรัพย์ (Assets) ================== */
        ['code' => '1000', 'name' => 'เงินสด', 'type' => 'asset'],
        ['code' => '1010', 'name' => 'เงินฝากธนาคาร', 'type' => 'asset'],
        ['code' => '1100', 'name' => 'ลูกหนี้การค้า', 'type' => 'asset'],
        ['code' => '1200', 'name' => 'ภาษีซื้อ', 'type' => 'asset'],
        ['code' => '1300', 'name' => 'สินค้า', 'type' => 'asset'],
        ['code' => '1500', 'name' => 'อุปกรณ์สำนักงาน', 'type' => 'asset'],
        ['code' => '1600', 'name' => 'ค่าเสื่อมราคาสะสม', 'type' => 'asset'],

        /** ================== หนี้สิน (Liabilities) ================== */
        ['code' => '2000', 'name' => 'เจ้าหนี้การค้า', 'type' => 'liability'],
        ['code' => '2100', 'name' => 'ภาษีขาย', 'type' => 'liability'],
        ['code' => '2200', 'name' => 'เงินกู้ยืม', 'type' => 'liability'],
        ['code' => '2300', 'name' => 'ค่าใช้จ่ายค้างจ่าย', 'type' => 'liability'],

        /** ================== ส่วนของเจ้าของ (Equity) ================== */
        ['code' => '3000', 'name' => 'ทุน', 'type' => 'equity'],
        ['code' => '3100', 'name' => 'กำไรสะสม', 'type' => 'equity'],

        /** ================== รายได้ (Income) ================== */
        ['code' => '4000', 'name' => 'รายได้จากการขาย', 'type' => 'income'],
        ['code' => '4100', 'name' => 'รายได้อื่น ๆ', 'type' => 'income'],

        /** ================== ค่าใช้จ่าย (Expenses) ================== */
        ['code' => '5000', 'name' => 'ต้นทุนขาย', 'type' => 'expense'],
        ['code' => '5100', 'name' => 'ค่าเช่า', 'type' => 'expense'],
        ['code' => '5200', 'name' => 'ค่าน้ำ', 'type' => 'expense'],
        ['code' => '5300', 'name' => 'ค่าไฟฟ้า', 'type' => 'expense'],
        ['code' => '5400', 'name' => 'เงินเดือนพนักงาน', 'type' => 'expense'],
        ['code' => '5500', 'name' => 'ค่าใช้จ่ายเบ็ดเตล็ด', 'type' => 'expense'],

    ]);
}
}
