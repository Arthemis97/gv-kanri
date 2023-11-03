<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();

            $table->enum('is_employee', ['admin', 'employee', 'worker'])->default('employee');
            $table->longText('picture')->nullable();
            $table->string('furigana')->nullable();
            $table->date('dob')->nullable();
            $table->boolean('gender')->default(false);
            $table->string('address')->nullable();
            $table->string('pos')->nullable();
            $table->date('pos_date')->nullable();
            $table->enum('driver_license', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11])->nullable()->default(null);
            $table->enum('working_place', [1, 2, 3, 4, 5])->nullable()->default(null);
            $table->enum('working_plan', [1, 2, 3, 4])->nullable()->default(null);
            $table->string('introduce')->nullable();
            $table->integer('nationality')->nullable();
            $table->enum('visa_type', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19])->nullable()->default(null);
            $table->boolean('work_restrictions')->nullable()->default(null);
            $table->enum('advancement', [1, 2, 3])->default(null);
            $table->enum('japanese_level', [1, 2, 3, 4, 5])->default(null);
            $table->string('urgent_contact')->nullable();
            $table->string('custom_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
