<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Category::TABLE, function (Blueprint $table) {
            $table->id();
            $table->foreignId(Category::USER_ID)->index()->constrained()->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string(Category::SLUG)->unique();
            $table->string(Category::NAME);
            $table->integer(Category::SORT)->default(0);
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
        Schema::dropIfExists(Category::TABLE);
    }
}
