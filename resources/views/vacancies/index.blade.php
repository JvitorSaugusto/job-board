<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RH Connect - Mural de Vagas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5" style="max-width: 1000px;">
        <header class="pb-3 mb-4 border-bottom d-flex justify-content-between align-items-center">
            <h1 class="fs-4 fw-bold text-dark mb-0">
                <i class="bi bi-briefcase-fill text-primary me-2"></i>RH Connect — Mural de Oportunidades
            </h1>
            <span class="badge bg-primary px-3 py-2 fs-6">Painel de Vagas</span>
        </header>

        <!-- Mensagens Flash de Sucesso -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Formulário de Cadastro de Nova Vaga -->
        <div class="card shadow-sm mb-5 border-0">
            <div class="card-body p-4">
                <h5 class="card-title mb-3 fw-bold text-secondary">
                    <i class="bi bi-plus-circle me-1"></i>Cadastrar Nova Oportunidade
                </h5>
                <form action="{{ route('vacancies.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="title" class="form-label fw-bold">Título do Cargo / Vaga <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" placeholder="Ex: Estágio em Desenvolvimento Web">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="company" class="form-label">Empresa Contratante <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('company') is-invalid @enderror" id="company" name="company" value="{{ old('company') }}" placeholder="Ex: Tech Solutions">
                            @error('company')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="type" class="form-label">Tipo de Contrato <span class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type">
                                <option value="" selected disabled>Selecione...</option>
                                <option value="Estágio" {{ old('type') == 'Estágio' ? 'selected' : '' }}>Estágio</option>
                                <option value="CLT" {{ old('type') == 'CLT' ? 'selected' : '' }}>CLT</option>
                                <option value="PJ" {{ old('type') == 'PJ' ? 'selected' : '' }}>PJ</option>
                                <option value="Meio Período" {{ old('type') == 'Meio Período' ? 'selected' : '' }}>Meio Período</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="requirements" class="form-label">Requisitos e Descrição da Vaga <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('requirements') is-invalid @enderror" id="requirements" name="requirements" rows="3" placeholder="Descreva os conhecimentos necessários, benefícios e diferenciais da vaga...">{{ old('requirements') }}</textarea>
                            @error('requirements')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-send-fill me-1"></i> Publicar Vaga
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row g-4">
            <!-- Coluna 1: Vagas Abertas -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-success bg-opacity-10 border-0 py-3 d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0 text-success fw-bold">
                            <i class="bi bi-check-circle-fill me-2"></i>Vagas Abertas / Ativas
                        </h6>
                        <span class="badge bg-success rounded-pill fs-6">{{ $openVacancies->count() }}</span>
                    </div>
                    <div class="card-body p-3">
                        @forelse($openVacancies as $vacancy)
                            <div class="card border mb-3 shadow-sm">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="fw-bold text-dark mb-1">{{ $vacancy->title }}</h6>
                                            <span class="text-muted small"><i class="bi bi-building me-1"></i>{{ $vacancy->company }}</span>
                                        </div>
                                        <span class="badge bg-primary">{{ $vacancy->type }}</span>
                                    </div>
                                    <p class="text-secondary small mb-3">{{ $vacancy->requirements }}</p>
                                    <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                        <small class="text-muted" style="font-size: 0.75rem;">
                                            Publicado em: {{ $vacancy->created_at->format('d/m/Y H:i') }}
                                        </small>
                                        <div class="d-flex gap-1">
                                            <!-- Form para Encerrar Vaga -->
                                            <form action="{{ route('vacancies.toggle', $vacancy->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-warning" title="Encerrar Vaga">
                                                    <i class="bi bi-dash-circle me-1"></i>Encerrar
                                                </button>
                                            </form>
                                            <!-- Form para Excluir -->
                                            <form action="{{ route('vacancies.destroy', $vacancy->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir Vaga" onclick="return confirm('Tem certeza que deseja remover esta vaga?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-4 small">
                                Nenhuma vaga aberta no momento.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Coluna 2: Vagas Encerradas -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-secondary bg-opacity-10 border-0 py-3 d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0 text-secondary fw-bold">
                            <i class="bi bi-archive-fill me-2"></i>Vagas Encerradas / Inativas
                        </h6>
                        <span class="badge bg-secondary rounded-pill fs-6">{{ $closedVacancies->count() }}</span>
                    </div>
                    <div class="card-body p-3">
                        @forelse($closedVacancies as $vacancy)
                            <div class="card border mb-3 bg-light opacity-75">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="fw-bold text-muted text-decoration-line-through mb-1">{{ $vacancy->title }}</h6>
                                            <span class="text-muted small"><i class="bi bi-building me-1"></i>{{ $vacancy->company }}</span>
                                        </div>
                                        <span class="badge bg-secondary">{{ $vacancy->type }}</span>
                                    </div>
                                    <p class="text-muted small mb-3 text-decoration-line-through">{{ $vacancy->requirements }}</p>
                                    <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                        <small class="text-muted" style="font-size: 0.75rem;">
                                            Encerrada
                                        </small>
                                        <div class="d-flex gap-1">
                                            <!-- Form para Reabrir Vaga -->
                                            <form action="{{ route('vacancies.toggle', $vacancy->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-success" title="Reabrir Vaga">
                                                    <i class="bi bi-arrow-counterclockwise me-1"></i>Reabrir
                                                </button>
                                            </form>
                                            <!-- Form para Excluir -->
                                            <form action="{{ route('vacancies.destroy', $vacancy->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir Vaga" onclick="return confirm('Tem certeza que deseja remover esta vaga?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-4 small">
                                Nenhuma vaga encerrada até o momento.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>