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
        Schema::create(config('payments.models.deadline.table'), function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('invoice_id');
            $table->uuid('passpartout_id')->nullable();
            $table->string('passpartout_account', 12)->nullable();
            $table->date('due_date')->nullable();
            $table->decimal('income', 12, 2)->default(0);
            $table->decimal('vat', 12, 2)->default(0);
            $table->decimal('total_cost', 12, 2)->default(0);
            $table->uuid('exported_by');
            $table->boolean('sent_payment')->default(false);
            $table->boolean('payment_confirmed')->default(false);
            $table->timestamp('exported_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('invoice_id')
                ->references('id')
                ->on(config('payments.models.invoice.table'))
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('payments.models.deadline.table'));
    }
};
