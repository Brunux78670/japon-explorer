<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('japon:hello', function (): void {
    $this->comment('Japon Explorer est prêt.');
})->purpose('Vérifie le chargement des commandes Japon Explorer');
