<?php

use App\Consts\GlobalConst;
use App\Consts\TransactionConst;
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
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedInteger('status')->default(TransactionConst::STATUS_PENDING)->after('occurred_at');
            $table->string('receipt_image')->nullable()->after('occurred_at');
            $table->unsignedBigInteger('parent_transaction_id')->nullable()->after('occurred_at');
            $table->boolean('is_reversal')->default(false)->after('occurred_at');
            $table->unsignedInteger('currency')->default(GlobalConst::CURRENCY_VND)->after('occurred_at'); // VND

            $table->index(['parent_transaction_id', 'occurred_at']);
            $table->index(['status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([
                'status',
                'receipt_image',
                'parent_transaction_id',
                'is_reversal',
                'currency',
            ]);
        });
    }
};
