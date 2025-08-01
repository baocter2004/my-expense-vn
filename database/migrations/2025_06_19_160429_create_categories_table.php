<?php

use App\Consts\GlobalConst;
use App\Models\Group;
use App\Models\User;
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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(Group::class)->nullable()->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('descriptions')->nullable();
            $table->boolean('is_active')->default(GlobalConst::ACTIVE);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
