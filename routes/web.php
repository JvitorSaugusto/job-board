<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [VacancyController::class, 'index'])->name('vacancies.index');

Route::post('/vacancies', [VacancyController::class, 'store'])->name('vacancies.store');

Route::patch('/vacancies/{vacancy}/toggle', [VacancyController::class, 'toggle'])->name('vacancies.toggle');

Route::delete('/vacancies/{vacancy}', [VacancyController::class, 'destroy'])->name('vacancies.destroy');
