<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->ulid()->index();
            $table->foreignIdFor(User::class)->constrained();
            $table->string('full_name');
            $table->string('phone');
            $table->text('address_1');
            $table->text('address_2')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('zipcode', 6)->nullable();
            $table->boolean('default_address');
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
        Schema::dropIfExists('user_addresses');
    }
};
