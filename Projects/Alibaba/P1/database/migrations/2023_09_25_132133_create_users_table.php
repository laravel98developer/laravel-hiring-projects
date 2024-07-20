<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile')->nullable()->unique();
            $table->string('verification_code')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('mobile_verified_at')->nullable();
            $table->string('password');
            $table->boolean('verified')->default(false);
            $table->rememberToken();
            $table->index("email");
            $table->timestamps();
            $table->softDeletes();
        });

        \Illuminate\Support\Facades\DB::table('users')->insert([
            ['name' => 'super_admin',"email"=>"super_admin@gmail.com","password"=>bcrypt('123456789'),
                'verification_code' => null,
                'email_verified_at' => now(),
                'mobile_verified_at' => now(),],
            ['name' => 'admin',"email"=>"admin@gmail.com","password"=>bcrypt('123456789'),
                'verification_code' => null,
                'email_verified_at' => now(),
                'mobile_verified_at' => now(),],
            ['name' => 'client',"email"=>"client@gmail.com","password"=>bcrypt('123456789'),
                'verification_code' => null,
                'email_verified_at' => now(),
                'mobile_verified_at' => now(),]
        ]);
    }

    public function down()
    {
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::dropIfExists('users');
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1');

    }
}
