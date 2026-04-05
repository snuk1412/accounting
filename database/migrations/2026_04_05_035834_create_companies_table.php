<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up()
{
    Schema::create('companies', function (Blueprint $table) {
        $table->id();

        $table->string('name');
        $table->string('tax_id', 13)->unique();

        // 🔥 แก้ตรงนี้
        $table->string('business_type');   // company, partnership, freelance, individual
        $table->string('industry_type');   // service, retail, manufacturing, other

        $table->string('product_type')->nullable();
        $table->integer('employee_count')->default(0);

        $table->text('address')->nullable();
        $table->string('phone')->nullable();
        $table->string('email')->nullable();

        $table->string('logo')->nullable();
        $table->boolean('is_default')->default(false);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
