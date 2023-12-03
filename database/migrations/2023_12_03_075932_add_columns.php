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
        Schema::table('users', function (Blueprint $table) {
            $table->unique('resisdence_card_number');
            $table->enum('advancement', [1, 2, 3, 4, 5])->default(5)->change();
            $table->enum('black_list', [0, 1, 2])->nullable()->default(null);
            $table->string('black_list_description')->nullable();
            $table->string('real_name')->nullable();
            $table->enum('admin_type', ['admin', 'ceo', 'regular'])->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['black_list', 'black_list_description', 'real_name', 'admin_type']);
        });
    }
};
