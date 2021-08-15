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
		Schema::create('products', function (Blueprint $table) {
			$table->id();
			$table->string("title");
			$table->text("description")->nullable();
			$table->decimal('price', 8, 2)->nullable();
			$table->integer('quantity');
			$table->string("images")->nullable();
			$table->integer("discount")->nullable();
			$table->integer("cod_bars")->nullable();
			$table->boolean("active")->default(true);
			$table->unsignedBigInteger('user_id')->nullable();
			$table->unsignedBigInteger('category_id')->nullable();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
		Schema::dropIfExists('products');
	}
}
