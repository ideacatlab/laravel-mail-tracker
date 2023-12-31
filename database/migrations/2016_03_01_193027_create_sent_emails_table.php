<?php

use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Schema\Blueprint;
use jdavidbakr\MailTracker\MailTracker;
use Illuminate\Support\Facades\DB;
use jdavidbakr\MailTracker\Model\SentEmail;


class CreateSentEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

         Schema::connection(MailTracker::sentEmailModel()->getConnectionName())->create('sent_emails', function (Blueprint $table) {
            if (config('mail-tracker.use_uuids')) {
                $table->uuid('id')->primary();
            } else {
                $table->increments('id');
            }
            $table->char('hash', 32)->unique();
            $table->text('headers')->nullable();
            $table->string('subject')->nullable();
            $table->text('content')->nullable();
            $table->integer('opens')->nullable();
            $table->integer('clicks')->nullable();
            $table->timestamps();
        });
        if (config('mail-tracker.use_uuids')) {
            DB::statement('ALTER TABLE sent_emails ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(MailTracker::sentEmailModel()->getConnectionName())->drop('sent_emails');
    }
}
