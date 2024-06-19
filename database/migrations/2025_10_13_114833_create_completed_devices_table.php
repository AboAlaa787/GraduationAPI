<?php

use App\Enums\DeviceStatus;
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
        Schema::create('completed_devices', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->string('imei',15)->nullable();
            $table->string('code')->unique();
            $table->foreignId('client_id')->nullable()->constrained()->nullOnDelete();
            $table->string('client_name');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('user_name');
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->text('info')->nullable();
            $table->string('problem')->nullable();
            $table->double('cost_to_client')->nullable();
            $table->double('cost_to_customer')->nullable();
            $table->enum('status',DeviceStatus::values());
            $table->text('fix_steps')->nullable();
            $table->boolean('deliver_to_client')->default(true);
            $table->boolean('deliver_to_customer')->default(false);
            $table->date('date_receipt')->nullable();
            $table->date('date_receipt_from_customer');
            $table->date('date_delivery_client')->default(now());
            $table->date('date_delivery_customer')->nullable();
            $table->date('client_date_warranty')->nullable();
            $table->date('customer_date_warranty')->nullable();
            $table->boolean('repaired_in_center')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('completed_devices');
    }
};
