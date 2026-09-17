<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\VRequest;
use App\Models\Vanancy;

class VacancyController extends Controller
{
    public function index()
    {
        $closedVacancies = Vacancy::where('is_open', false)->latest()->get();
        $openVacancies = Vacancy::where('is_open', true)->latest()->get();

        return view('vacancies.index', compact('closedVacancies', 'openVacancies'));
    }

    public function store(VacancyRequest $request)
    {
        $data = $request->validated();
        $data['is_open'] = false;

        Vacancy::create($data);

        return redirect()->route('vacancies.index')
            ->with('success', 'Vaga adicionada ');
    }

    public function toggle(Vacancy $vacancy)
    {
        $vacancy->is_open = ! $vacancy->is_open;
        $vacancy->save();

        return redirect()->route('vacancies.index')
            ->with('success', 'Status da vaga atualizado');
    }

    public function destroy(Vacancy $vacancy)
    {
        $vacancy->delete();

        return redirect()->route('vacancies.index')
            ->with('success', 'Vaga excluída');
    }
}


