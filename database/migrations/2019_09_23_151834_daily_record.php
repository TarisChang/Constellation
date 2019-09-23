<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DailyRecord extends Migration
{

    private $table = 'daily_record';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->string('name', 11)->default('');
            $table->tinyInteger('total_n')->default(0);
            $table->string('total_d')->default('');
            $table->tinyInteger('love_n')->default(0);
            $table->string('love_d')->default('');
            $table->tinyInteger('work_n')->default(0);
            $table->string('work_d')->default('');
            $table->tinyInteger('money_n')->default(0);
            $table->string('money_d')->default('');

            $table->timestamps();

            $table->index(['date', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
