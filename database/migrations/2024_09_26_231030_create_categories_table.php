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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string("name", 60);
            $table->string("slug", 150);
            $table->string("description", 250)->nullable();
            $table->unsignedBigInteger("parent_id")->nullable();
            $table->boolean("status")->default(0);
            $table->boolean("feature_status")->default(0);
            $table->integer("order")->default(0);
            $table->string("seo_description")->nullable();
            $table->string("seo_keywords")->nullable();
            $table->unsignedBigInteger("user_id");
            $table->timestamps();

            // foreign key alan parent_id'ye karşılık gelecek
            // referans id'den
            $table->foreign("parent_id")->on("categories")->references("id")->onDelete("cascade");
            // categories tablosunda oluşturduğumuz user_id, 
            // users tablosundaki id sütunundaki id'ye denk gelecek
            $table->foreign("user_id")->on("users")->references("id")->onDelete("cascade");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
