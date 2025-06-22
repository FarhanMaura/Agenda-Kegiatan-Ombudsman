<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->string('day');
            $table->date('date');
            $table->string('time');
            $table->string('start_time');
            $table->string('end_time');
            $table->text('activity');
            $table->string('institution');
            $table->string('person_in_charge');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};
