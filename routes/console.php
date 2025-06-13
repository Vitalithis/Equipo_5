<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('setup', function () {
    $this->comment('🔧 Ejecutando composer install...');
    passthru('composer install', $code);
    if ($code !== 0) return $this->error('❌ Composer falló.');

    $this->comment('📦 Ejecutando npm install...');
    passthru('npm install', $code);
    if ($code !== 0) return $this->error('❌ NPM falló.');

    $this->comment('🎨 Ejecutando npm run build...');
    passthru('npm run build', $code);
    if ($code !== 0) return $this->error('❌ Build falló.');

    $this->comment('🗃️ Ejecutando migraciones...');
    Artisan::call('migrate', ['--force' => true]);

    if (app()->isProduction()) {
        if ($this->confirm('⚠️ Estás en producción. ¿Ejecutar db:seed?')) {
            Artisan::call('db:seed', ['--force' => true]);
        }
    } else {
        $this->comment('🌱 Ejecutando seeds...');
        Artisan::call('db:seed', ['--force' => true]);
    }

    if (app()->isProduction()) {
        $this->comment('🧹 Limpiando y cacheando...');
        Artisan::call('optimize:clear');
        Artisan::call('config:cache');
        Artisan::call('route:cache');
        Artisan::call('view:cache');
    }
    $this->comment('🔗 Verificando symlink public/storage...');
    $publicStorage = public_path('public/storage');
    if (File::exists($publicStorage)) {
        File::deleteDirectory($publicStorage); // elimina si es una carpeta
        $this->comment('📁 Eliminado public/storage existente.');
    }
    Artisan::call('storage:link');
    $this->comment('🔗 Symlink creado.');

    $this->info('✅ Setup completo.');
})->purpose('Configuración completa del sistema (composer, npm, migraciones, seed, cache)');
