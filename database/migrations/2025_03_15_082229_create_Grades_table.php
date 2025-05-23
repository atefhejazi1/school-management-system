<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateGradesTable extends Migration
{

    public function up()
    {
        Schema::create('Grades', function (Blueprint $table) {
            $table->id();
            $table->string('Name');
            $table->longText('Notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('Grades');
    }
}
