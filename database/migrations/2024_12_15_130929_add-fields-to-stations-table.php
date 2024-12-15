<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('stations', function (Blueprint $table) {
            $table->string('project_id')->nullable();
            $table->string('branch_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stations', function (Blueprint $table) {
            $table->dropColumn('project_id');
            // $table->dropUnique(index: ['project_id']); // Drop unique constraint
            $table->dropColumn('branch_id');
            // $table->dropUnique(['branch_id']); // Drop unique constraint

        });
    }
};
