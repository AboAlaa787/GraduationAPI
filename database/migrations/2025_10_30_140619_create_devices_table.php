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
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('client_piority');
            $table->integer('manager_piority');
            $table->unique(['manager_piority','user_id']);
            $table->unique(['client_piority','client_id']);
            $table->text('info')->nullable();
            $table->string('problem')->nullable();
            $table->double('cost')->nullable();
            $table->text('fix_steps')->nullable();
            $table->enum('status',DeviceStatus::values())->default(DeviceStatus::NotStarted);
            $table->boolean('client_approval');
            $table->foreignId('center_id')->constrained()->cascadeOnDelete();
            $table->date('date_receipt')->default(now());
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
