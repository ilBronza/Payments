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
    public function up()
    {
        Schema::create(config('payments.models.invoiceDetail.table'), function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('invoice_id');
            $table->string('description', 255)->nullable();
            $table->unsignedInteger('sorting_index')->nullable();
            $table->decimal('quantity', 12, 4)->nullable();
            $table->decimal('unit_price', 12, 2)->nullable();
            $table->decimal('total_price', 12, 2)->nullable();
            $table->decimal('vat_rate', 5, 2)->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('invoice_id')
                ->references('id')
                ->on(config('payments.models.invoice.table'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('payments.models.invoiceDetail.table'));
    }
};
