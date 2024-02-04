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
            $table->integer('client_priority');
            $table->integer('manager_priority');
            $table->unique(['manager_priority','user_id']);
            $table->unique(['client_priority','client_id']);
            $table->text('info')->nullable();
            $table->string('problem')->nullable();
            $table->double('cost')->nullable();
            $table->text('fix_steps')->nullable();
            $table->enum('status',DeviceStatus::values())->default(DeviceStatus::NotStarted);
            $table->boolean('client_approval');
            #$table->foreignId('center_id')->constrained()->cascadeOnDelete();
            $table->date('date_receipt')->default(now());
            $table->integer('warranty_days')->default(7);
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
