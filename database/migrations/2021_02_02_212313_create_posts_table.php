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
        Schema::create(Post::TABLE, function (Blueprint $table) {
            $table->id();
            $table->foreignId(Post::USER_ID)->index()->constrained()->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreignId(Post::CATEGORY_ID)->index()->nullable()->constrained()->onUpdate('CASCADE')->onDelete('SET NULL');
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
        Schema::dropIfExists(Post::TABLE);
    }
}
