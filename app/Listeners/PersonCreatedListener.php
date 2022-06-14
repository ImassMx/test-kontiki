<?php namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class PersonCreatedListener
{

    public function __construct()
    {

    }

    public function handle($event): void
    {
       Log::info(sprintf('El registro ha sido generado con el id: %d', $event->person->id));
    }
}
