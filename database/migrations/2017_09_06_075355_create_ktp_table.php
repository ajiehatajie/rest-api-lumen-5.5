<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKtpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kecamatans', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
            $table->index('name');
        });

        Schema::create('ktps', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->integer('kecamatan_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('total');
            $table->text('notes_create');
            $table->text('notes_update');
            $table->timestamp('date_submission')->unique();//pengajuan buat nya
            $table->boolean('status')->default(0);
            $table->timestamps();
            $table->index('date_submission','kecamatan_id');
        });

        Schema::create('users', function (Blueprint $table) {
            //$table->engine = 'MyISAM';
            $table->increments('id');
            $table->string('email')->unique();
            $table->integer('kecamatan_id')->unsigned();
            $table->string('password');
            $table->string('api_token');
            $table->boolean('status')->default(0);//0 nonaktif
            $table->enum('roles', ['user', 'admin'])->default('user');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kecamatans');
        Schema::dropIfExists('ktps');
        Schema::dropIfExists('users');
    }
}
