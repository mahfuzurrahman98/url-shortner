<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('shortens', function (Blueprint $table) {
            $table->text('original_url', 2048)->change();
            $table->text('normalized_url', 2048)->change();
            $table->string('short_url', 255)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        //
    }
};
