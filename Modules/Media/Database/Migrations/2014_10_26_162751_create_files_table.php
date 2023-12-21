<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_folder')->default(false);
            $table->foreignId('folder_id')->nullable();
            $table->morphs("entity");
            $table->string('filename')->index()->nullable();
            $table->string('disk')->nullable();
            $table->string('path')->nullable();
            $table->string('extension')->nullable();
            $table->string('mime')->nullable();
            $table->string('size')->nullable();
            $table->timestamps();

            $table->foreign('folder_id')->references('id')->on('files')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
};
