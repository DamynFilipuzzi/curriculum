<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('optional_priorities', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('op_subdesc')->nullable();
            $table->foreign('op_subdesc')->references('op_subdesc')->on('optional_priorities_subdescriptions')->onDelete('cascade')->onUpdate('cascade');
            $table->dropColumn('isCheckable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('optional_priorities', function (Blueprint $table) {
            //
        });
    }
};
