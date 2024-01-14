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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Название');
            $table->text('description')->nullable()->default(null)->comment('Описание');
            $table->dateTime('start')->nullable()->default(null)->comment('Время начала выполнения');
            $table->dateTime('end')->nullable()->default(null)->comment('Время конца выполнения');
            $table->integer('state')->default(1)->comment('Состояние');
            $table->unsignedBigInteger('create_user_id')->comment('Создавший пользователь');
            $table->foreign('create_user_id')
                ->references('id')->on('users');
            $table->unsignedBigInteger('make_user_id')->nullable()->default(null)->comment('Выполняет пользователь');
            $table->foreign('make_user_id')
                ->references('id')->on('users');
            $table->unsignedBigInteger('project_id')->comment('Относится к проекту');
            $table->foreign('project_id')
                ->references('id')->on('projects')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
