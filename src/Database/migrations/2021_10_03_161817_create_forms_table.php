<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('model');
            $table->boolean('external_table')->default(0);
            $table->timestamps();
        });
        Schema::create('fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('forms_id');
            $table->foreign('forms_id')->on('forms')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->string('label');
            $table->text('description')->nullable();
            $table->text('font_icon')->nullable();
            $table->text('values')->nullable();
            $table->text('validate')->nullable();
            $table->string('type_variable')->default('text');
            $table->enum('status',['show','hidden','required'])->default('show');
            $table->integer('order_number')->default(0);
            $table->timestamps();
        });

        Schema::create('fieldsvalues', function (Blueprint $table) {
            $table->unsignedBigInteger('field_id');
            $table->foreign('field_id')->on('fields')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('fieldable_id');
            $table->string('fieldable_type');
            $table->text('value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fieldsvalues');
        Schema::dropIfExists('fields');
        Schema::dropIfExists('forms');
    }
}
