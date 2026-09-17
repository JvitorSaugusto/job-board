<?php

namespace App\Http\Controllers;

use App\Http\Requests\VacancyRequest;
use App\Models\Vacancy;

class VacancyController extends Controller
{
    public function index()
    {
        $openVacancies = Vacancy::where('is_open', true)
            ->latest()
            ->get();

        $closedVacancies = Vacancy::where('is_open', false)
            ->latest()
            ->get();

        return view(
            'vacancies.index',
            compact('openVacancies', 'closedVacancies')
        );
    }

    public function store(VacancyRequest $request)
    {
        $data = $request->validated();
        $data['is_open'] = true;

        Vacancy::create($data);

        return redirect()
            ->route('vacancies.index')
            ->with('success', 'Vaga adicionada com sucesso.');
    }

    public function toggle(Vacancy $vacancy)
    {
        $vacancy->is_open = ! $vacancy->is_open;
        $vacancy->save();

        return redirect()
            ->route('vacancies.index')
            ->with('success', 'Status da vaga atualizado com sucesso.');
    }

    public function destroy(Vacancy $vacancy)
    {
        $vacancy->delete();

        return redirect()
            ->route('vacancies.index')
            ->with('success', 'Vaga excluída com sucesso.');
    }
}