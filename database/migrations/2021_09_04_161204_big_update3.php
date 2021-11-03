<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BigUpdate3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Users', function (Blueprint $table) {
            $table->integer('matricule')->nullable()->unique();
            $table->bigInteger('discord_id')->nullable()->unique();
            $table->json('sanctions')->nullable();
            $table->json('materiel')->nullable();
            $table->json('note')->nullable();
            $table->json('formations')->nullable();
            $table->bigInteger('last_service_update')->nullable();
            $table->softDeletes();
        });

        Schema::table('Grades', function (Blueprint $table) {
            $a = 27;
            while ($a <= 40){
                $table->boolean('perm_'.$a)->default(false);
                $a++;
            }
        });

        Schema::create('ServiceStatesLogs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('state_id');
            $table->timestamps();
        });

        Schema::create('PouderTests', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('patient_id');
            $table->string('lieux_prelevement');
            $table->boolean('on_skin_positivity')->default(false);
            $table->boolean('on_clothes_positivity')->default(false);
            $table->timestamps();
        });

        Schema::table('Patients', function (Blueprint $table) {
            $table->date('naissance')->nullable();
            $table->string('living_place')->nullable();
        });

        Schema::create('Primes', function (Blueprint $table) {
            $table->id();
            $table->integer('item_id');
            $table->integer('user_id');
            $table->integer('week_number');
            $table->boolean('accepted')->default(false);
            $table->timestamps();
        });

        Schema::create('PrimeItems', function (Blueprint $table) {
            $table->id();
            $table->integer('montant');
            $table->string('name');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('ModifyServiceReqs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('week_number');
            $table->string('reason');
            $table->boolean('adder'); //true add time / false remove time
            $table->bigInteger('time_quantity'); // in Sec
            $table->boolean('acceped')->nullable()->default(null); //null : non traitré
            $table->integer('admin_id')->nullable()->default(null);
            $table->string('admin_reason')->nullable()->default(null);
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
        //
    }
}
