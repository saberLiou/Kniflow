<?php

use App\Models\Post;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId(Post::USER_ID)->index()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger(Post::CATEGORY_ID)->index()->nullable();
            $table->string(Post::SLUG)->unique();
            $table->string(Post::TITLE);
            $table->longText(Post::CONTENT);
            $table->tinyInteger(Post::STATUS)->default(1);
            $table->timestamp(Post::PUBLISHED_AT);
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
        Schema::dropIfExists('posts');
    }
}
