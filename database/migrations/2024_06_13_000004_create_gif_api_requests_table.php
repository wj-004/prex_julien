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
        Schema::create('gif_api_requests', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('api_service_type_id');
            $table->json('request_data');
            $table->integer('response_status');
            $table->json('response_data')->nullable();
            $table->string('ip_client');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('api_service_type_id')->references('id')->on('gif_service_types');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gif_api_requests');
    }
};
