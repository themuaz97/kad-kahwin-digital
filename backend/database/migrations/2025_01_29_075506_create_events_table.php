<?php

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
        Schema::create('events', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('title');
            $table->text('introduction');
            $table->text('greeting');
            $table->date('date');
            $table->time('start_at');
            $table->time('end_at');
            $table->string('venue_name');
            $table->string('venue_address');
            $table->text('google_map_url');
            $table->string('phone_no_1'); // no fon waris 1 / makayah
            $table->string('phone_no_2')->nullable(); // no fon waris 2 / makayah
            $table->string('phone_no_3')->nullable();
            $table->string('phone_no_4')->nullable();
            $table->enum('status', ['draft', 'confirmed', 'completed', 'cancelled'])->default('draft');
            $table->foreignId('organiser_id')->constrained()->cascadeOnDelete();
            $table->uuid('created_by');
            $table->uuid('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Define foreign key constraints explicitly
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
