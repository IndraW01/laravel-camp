<?php

use App\Models\Discount;
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
    public function up()
    {
        Schema::table('checkouts', function (Blueprint $table) {
            $table->foreignIdFor(Discount::class)->nullable()->after('camp_id')->constrained('discounts');
            $table->unsignedInteger('discount_percentage')->after('midtrans_booking_code')->nullable();
            $table->unsignedInteger('total')->default(0)->after('discount_percentage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('checkouts', function (Blueprint $table) {
            $table->dropForeignIdFor(Discount::class);
            $table->dropColumn('discount_id');
            $table->dropColumn('discount_percentage');
            $table->dropColumn('total');
        });
    }
};
