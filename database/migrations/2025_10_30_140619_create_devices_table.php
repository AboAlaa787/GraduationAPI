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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->string('imei')->nullable();
            $table->string('code')->unique();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('client_priority')->nullable();
            // $table->integer('manager_priority')->nullable();
            // $table->unique(['manager_priority','user_id']);
            $table->unique(['client_priority','client_id']);
            $table->text('info')->nullable();
            $table->string('problem')->nullable();
            $table->double('cost_to_client')->nullable();
            $table->double('cost_to_customer')->nullable();
            $table->text('fix_steps')->nullable();
            $table->enum('status',DeviceStatus::values())->default(DeviceStatus::NotStarted);
            $table->boolean('client_approval')->nullable();
            $table->dateTime('date_receipt')->default(now());
            $table->dateTime('Expected_date_of_delivery')->nullable();
            $table->date('client_date_warranty')->nullable();
            $table->boolean('deliver_to_client')->default(false);
            $table->boolean('deliver_to_customer')->default(false);
            $table->boolean('repaired_in_center')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
