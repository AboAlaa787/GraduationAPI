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
            $table->string('imei')->nullable();
            $table->string('code')->unique();
            $table->foreignId('client_id')->nullable()->constrained()->nullOnDelete();
            $table->string('client_name');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('user_name');
            $table->text('info')->nullable();
            $table->string('problem');
            $table->double('cost')->nullable();
            $table->enum('status',DeviceStatus::values());
            #$table->foreignId('center_id')->constrained()->cascadeOnDelete();
            $table->text('fix_steps')->nullable();
            $table->date('date_receipt');
            $table->date('date_delivery')->default(now());
            $table->date('date_warranty')->default(now()->addDays(7));
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
