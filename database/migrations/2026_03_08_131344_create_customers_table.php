<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {

            $table->id();

            $table->string('business_name')->nullable(); // ชื่อผู้ประกอบการ
            $table->string('fullname')->nullable(); // ชื่อ นามสกุล

            $table->string('building')->nullable(); // อาคาร
            $table->string('room_no')->nullable(); // ห้อง
            $table->string('floor')->nullable(); // ชั้น
            $table->string('village')->nullable(); // หมู่บ้าน

            $table->string('house_no')->nullable(); // เลขที่
            $table->string('moo')->nullable(); // หมู่
            $table->string('soi')->nullable(); // ซอย
            $table->string('junction')->nullable(); // แยก
            $table->string('road')->nullable(); // ถนน

            $table->string('subdistrict')->nullable(); // ตำบล
            $table->string('district')->nullable(); // อำเภอ
            $table->string('province')->nullable(); // จังหวัด
            $table->string('postcode')->nullable(); // รหัสไปรษณีย์

            $table->string('tax_id')->nullable(); // เลขผู้เสียภาษี
            $table->string('phone')->nullable(); // เบอร์ติดต่อ

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};

