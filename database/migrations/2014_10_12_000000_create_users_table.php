<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('branch', 10)->nullable();
            $table->string('username')->unique();
            $table->string('status', 2)->default('00');
            $table->string('password');
            $table->string('usertype',5)->default('U001');
            $table->rememberToken();
            $table->timestamps();
        });

        User::create([
            'name' => 'Edmund Managuit',
            'email' => 'admin@app.com',
            'branch' => 'MAIN',
            'username' => 'admin',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);

        User::create([
            'name' => 'Christian',
            'email' => 'chris@app.com',
            'branch' => 'CEB',
            'username' => 'chris',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);

        User::create([
            'name' => 'Stephanie',
            'email' => 'step@app.com',
            'branch' => 'ILO',
            'username' => 'step',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
