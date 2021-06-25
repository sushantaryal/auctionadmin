<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullOnDelete()->nullable();
            $table->string('name');
            $table->string('slug');
            $table->decimal('initial_price', 10, 2);
            $table->decimal('price', 10, 2);
            $table->decimal('closing_price', 10, 2);
            $table->boolean('auto_increment')->default(0);
            $table->decimal('min_increment', 8, 2);
            $table->integer('bid_credit');
            $table->dateTime('starts_at');
            $table->dateTime('expire_at');
            $table->longText('description')->nullable();
            $table->longText('features')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
