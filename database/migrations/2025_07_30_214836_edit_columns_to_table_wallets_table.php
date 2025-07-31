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
        Schema::table('wallets', function (Blueprint $table) {
            $table->renameColumn('curency', 'currency');
            $table->boolean('is_default')->default(false)->after('currency');
            $table->text('note')->nullable()->after('is_default');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wallets', function (Blueprint $table) {
            $table->renameColumn('currency', 'curency');
            $table->dropColumn(['is_default', 'note']);
        });
    }
};
