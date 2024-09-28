<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();

            $table->string("title");
            $table->string("slug");

            $table->text("body");
            $table->string("image")->nullable();

            $table->string("tags")->nullable();
            $table->boolean("status")->default(0);
            
            $table->integer("view_count")->default(0);
            $table->integer("like_count")->default(0);
            $table->integer("read_time")->default(0);

            $table->dateTime("publish_date")->nullable();
            $table->string("seo_keywords")->nullable();
            $table->string("seo_description")->nullable();
            
            $table->timestamps();

            $table->unsignedBigInteger("category_id");
            $table->unsignedBigInteger("user_id");

            $table->foreign("user_id")->on("users")->references("id")->onDelete("cascade");
            $table->foreign("category_id")->on("categories")->references("id")->onDelete("cascade");
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
