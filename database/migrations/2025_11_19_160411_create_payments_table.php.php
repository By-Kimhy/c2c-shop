<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('order_id')->nullable();
            $table->string('merchant_account')->nullable(); // merchant identifier (from bank)
            $table->string('khqr_payload')->nullable();
            $table->string('qr_path')->nullable(); // path to generated QR image
            $table->decimal('amount', 14, 2)->default(0);
            $table->string('currency', 3)->default('KHR');
            $table->string('status')->default('pending'); // pending, paid, failed
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}