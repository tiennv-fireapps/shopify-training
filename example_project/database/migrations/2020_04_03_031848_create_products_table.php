<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->bigInteger('shop_id')->nullable();
            $table->bigInteger('shopify_id')->nullable();
            $table->string('title')->nullable();
            $table->text('body_html')->nullable();
            $table->string('vendor')->nullable();
            $table->string('product_type')->nullable();
            $table->timestamp('shopify_created_at')->nullable();
            $table->string('handle')->nullable();
            $table->timestamp('shopify_updated_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->string('template_suffix')->nullable();
            $table->string('published_scope')->nullable();
            $table->string('tags')->nullable();
            $table->string('admin_graphql_api_id')->nullable();
            $table->json('variants')->nullable();
            $table->json('options')->nullable();
            $table->json('images')->nullable();
            $table->json('image')->nullable();
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
