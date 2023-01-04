<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskNoteAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_note_attachments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('task_note_id');
            $table->foreign('task_note_id')->references('id')->on('task_notes');
            
            $table->string('file')->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_note_attachments');
    }
}
