<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\AddListTable;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;


class AddTablesToDB2
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(AddListTable $event)
    {
        $this -> createTables($event -> email);
    }

    function createTables($email)
    {
        info($email->name);
        if (!Schema::connection('pgsql2')->hasTable($email->name)) {
                Schema::connection('pgsql2')->create($email->name, function (Blueprint $table) {
                    $table->id();
                    $table->string('email')->nullable(false)->unique();
                    $table->string('email_md5')->nullable(false);
                    $table->timestamps();
                });
            }
    }
}
