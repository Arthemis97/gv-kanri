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
        Schema::create('relations', function (Blueprint $table) {
            $table->id('id');
            $table->string('name')->nullable();
            $table->string('furigana')->nullable();
            $table->boolean('gender')->default(false);
            $table->string('resisdence_card_number')->nullable();
            $table->string('my_number')->nullable();
            $table->string('dependent')->nullable();
            $table->integer('user_id');
            $table->timestamps();
        });
        Schema::create('prefectures', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->timestamps();
        });
        Schema::create('work_places', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->timestamps();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->string('nick_name')->nullable();
            $table->string('resisdence_card_number')->nullable();
            $table->string('my_number')->nullable();
            $table->boolean('dependent')->default(false);
            $table->string('start_date')->nullable();
            $table->enum('manager', [1, 2, 3, 4, 5, 6])->nullable();
            $table->string('registred_day')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->integer('prefecture_id')->nullable();
            $table->integer('work_place_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nick_name',
                'resisdence_card_number',
                'my_number',
                'dependent',
                'start_date',
                'manager',
                'registred_day',
                'emergency_contact_name',
                'prefecture_id',
                'work_place_id'
            ]);
        });
        Schema::dropIfExists('relations');
        Schema::dropIfExists('prefectures');
        Schema::dropIfExists('work_places');
    }
};
