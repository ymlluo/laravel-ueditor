<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upload_resources', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->default('');
            $table->string('original')->default('');
            $table->string('filename')->default('');
            $table->string('path', 500)->default('');
            $table->string('thumbnail', 2048)->default('');
            $table->string('url', 2048)->default('');
            $table->string('sha1')->default('');
            $table->string('extension')->default('');
            $table->string('mime_type')->default('');
            $table->unsignedInteger('file_type')->default(0);
            $table->unsignedInteger('width')->default(0);
            $table->unsignedInteger('height')->default(0);
            $table->unsignedInteger('size')->default(0);
            $table->string('extend', 1000)->default('[]');
            $table->integer('creator_uid')->default(0);
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->index('sha1');
            $table->index(['file_type']);
            $table->index(['path', 'extension']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('upload_resources');
    }
}
