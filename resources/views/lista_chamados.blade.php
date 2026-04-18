@extends('layout.index')
@section('title', 'Chamados')
@section('content')

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 mb-0 text-secondary">Gestão de Chamados</h2>
            <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#formAdd">
                <i class="bi bi-plus-circle me-2"></i>Novo Chamado
            </button>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-body">
                    <form action="{{ route('home') }}" method="GET" class="row g-3 align-items-center">
                        <div class="col-auto">
                            <label class="fw-bold text-muted small">FILTRAR POR STATUS:</label>
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">Todos os Chamados</option>
                                <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendente
                                </option>
                                <option value="em_andamento" {{ request('status') == 'em_andamento' ? 'selected' : '' }}>Em
                                    Andamento</option>
                                <option value="finalizado" {{ request('status') == 'finalizado' ? 'selected' : '' }}>
                                    Finalizado</option>
                            </select>
                        </div>
                        @if (request('status'))
                            <div class="col-auto">
                                <a href="{{ route('home') }}"
                                    class="btn btn-sm btn-link text-decoration-none text-danger">Limpar Filtro</a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 80px;">ID</th>
                            <th>Título</th>
                            <th>Solicitante</th>
                            <th>Status</th>
                            <th class="text-center" style="width: 200px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($chamados as $chmd)
                            <tr>
                                <td class="ps-4 fw-bold text-muted">#{{ $chmd->id }}</td>
                                <td>{{ $chmd->titulo }}</td>
                                <td>{{ $chmd->solicitante }}</td>
                                <td>
                                    @php
                                        $bg_color = match ($chmd->status) {
                                            'em_andamento' => 'bg-primary',
                                            'pendente' => 'bg-secondary',
                                            'finalizado' => 'bg-success',
                                        };
                                    @endphp
                                    <span class="badge rounded-pill {{ $bg_color }}">
                                        {{ $chmd->status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                                            data-bs-target="#info_{{ $chmd->id }}">
                                            Detalhes
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#del_modal_{{ $chmd->id }}">
                                            Excluir
                                        </button>
                                    </div>

                                    <x-modals.info id="info_{{ $chmd->id }}" title="Chamado #{{ $chmd->id }}">
                                        <div class="row g-3">
                                            <div class="col-12 d-flex justify-content-between align-items-center">
                                                <label class="fw-bold text-muted small text-uppercase">Status Atual</label>
                                                <span
                                                    class="badge {{ $chmd->status == 'em_andamento' ? 'bg-info' : ($chmd->status == 'finalizado' ? 'bg-success' : 'bg-warning text-dark') }}">
                                                    {{ str_replace('_', ' ', ucfirst($chmd->status)) }}
                                                </span>
                                            </div>

                                            <div class="col-12">
                                                <label class="fw-bold text-muted small text-uppercase">Título</label>
                                                <p class="fs-5">{{ $chmd->titulo }}</p>
                                            </div>

                                            <div class="col-12">
                                                <label class="fw-bold text-muted small text-uppercase">Descrição</label>
                                                <div class="bg-light p-3 rounded border">
                                                    {{ $chmd->descricao }}
                                                </div>
                                            </div>

                                            <hr class="my-3">

                                            <div class="col-12">
                                                <label class="fw-bold text-muted small text-uppercase d-block mb-2">Alterar
                                                    Status para:</label>
                                                <div class="d-flex flex-wrap gap-2">

                                                    @if ($chmd->status != 'pendente')
                                                        <form action="{{ route('update_status', $chmd->id) }}"
                                                            method="POST">
                                                            @csrf @method('PATCH')
                                                            <input type="hidden" name="status" value="pendente">
                                                            <button type="submit"
                                                                class="btn btn-sm btn-outline-warning">Pendente</button>
                                                        </form>
                                                    @endif

                                                    @if ($chmd->status != 'em_andamento')
                                                        <form action="{{ route('update_status', $chmd->id) }}"
                                                            method="POST">
                                                            @csrf @method('PATCH')
                                                            <input type="hidden" name="status" value="em_andamento">
                                                            <button type="submit" class="btn btn-sm btn-outline-info">Em
                                                                Andamento</button>
                                                        </form>
                                                    @endif

                                                    @if ($chmd->status != 'finalizado')
                                                        <form action="{{ route('update_status', $chmd->id) }}"
                                                            method="POST">
                                                            @csrf @method('PATCH')
                                                            <input type="hidden" name="status" value="finalizado">
                                                            <button type="submit"
                                                                class="btn btn-sm btn-outline-success">Finalizar
                                                                Chamado</button>
                                                        </form>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-12 mt-3 small text-muted border-top pt-2">
                                                <strong>Aberto em:</strong>
                                                {{ \Carbon\Carbon::parse($chmd->data_de_abertura)->format('d/m/Y H:i') }}
                                                <div class="col-12 mt-3 pt-3 border-top">
                                                    <label
                                                        class="fw-bold text-muted small text-uppercase d-block mb-1">
                                                        TEMPO
                                                    </label>

                                                    @if ($chmd->status === 'finalizado' && $chmd->data_de_fechamento)
                                                        @php
                                                            $abertura = \Carbon\Carbon::parse($chmd->data_de_abertura);
                                                            $fechamento = \Carbon\Carbon::parse(
                                                                $chmd->data_de_fechamento,
                                                            );
                                                            $totalSegundos = $abertura->diffInSeconds($fechamento);
                                                            $minutos = floor($totalSegundos / 60);
                                                            $segundos = $totalSegundos % 60;
                                                        @endphp
                                                        <div class="alert alert-secondary py-2 mb-0">
                                                            <i class="bi bi-stopwatch me-2"></i>
                                                            Tempo total para finalização:
                                                            <strong>{{ $minutos }}m {{ $segundos }}s</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </x-modals.info>
                                    {{-- Modal Excluir --}}
                                    <x-modals.delete id="del_modal_{{ $chmd->id }}" title="Confirmar Exclusão">
                                        <p class="mb-0">Deseja realmente excluir o chamado
                                            <strong>#{{ $chmd->id }}</strong>?
                                        </p>
                                        <x-slot:footer>
                                            <form action="{{ route('delete_chamado', $chmd->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Excluir</button>
                                            </form>
                                        </x-slot:footer>
                                    </x-modals.delete>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <x-modals.create id="formAdd" title="Adicionar Novo Chamado">
        <form action="{{ route('create_chamado') }}" method="post">
            @csrf
            <div class="form-floating mb-3">
                <input name="titulo" type="text" class="form-control" id="input_titulo" placeholder="Título" required>
                <label for="input_titulo">Título</label>
            </div>
            <div class="form-floating mb-3">
                <input name="solicitante" type="text" class="form-control" id="input_solicitante"
                    placeholder="Solicitante" required>
                <label for="input_solicitante">Solicitante</label>
            </div>
            <div class="form-floating mb-3">
                <textarea name="descricao" class="form-control" placeholder="Descrição" id="input_descricao" style="height: 120px" required></textarea>
                <label for="input_descricao">Descrição da solicitação</label>
            </div>
            <div class="modal-footer px-0 pb-0">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success">Salvar Chamado</button>
            </div>
        </form>
    </x-modals.create>

@endsection
