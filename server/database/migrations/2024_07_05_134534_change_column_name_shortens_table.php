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
            $table->renameColumn('short_url', 'hash');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        //
    }
};
