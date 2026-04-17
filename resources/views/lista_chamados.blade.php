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
                                    <span
                                        class="badge rounded-pill {{ $bg_color }}">
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
                                            <div class="col-12">
                                                <label class="fw-bold text-muted small text-uppercase">Título</label>
                                                <p class="fs-5">{{ $chmd->titulo }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="fw-bold text-muted small text-uppercase">Solicitante</label>
                                                <p>{{ $chmd->solicitante }}</p>
                                            </div>
                                            <div class="col-12">
                                                <hr class="my-2">
                                                <label class="fw-bold text-muted small text-uppercase">Descrição</label>
                                                <div class="bg-light p-3 rounded mt-1">
                                                    {{ $chmd->descricao }}
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex justify-content-between mt-3 small text-muted">
                                                <span><strong>Abertura:</strong>
                                                    {{ \Carbon\Carbon::parse($chmd->data_de_abertura)->format('d/m/Y') }}</span>
                                                <span><strong>Fechamento:</strong>
                                                    {{ $chmd->data_de_fechamando ? \Carbon\Carbon::parse($chmd->data_de_fechamando)->format('d/m/Y') : 'Em andamento' }}</span>
                                            </div>
                                        </div>
                                    </x-modals.info>

                                    {{-- Modal Excluir --}}
                                    <x-modals.delete id="del_modal_{{ $chmd->id }}" title="Confirmar Exclusão">
                                        <p class="mb-0">Deseja realmente excluir o chamado
                                            <strong>#{{ $chmd->id }}</strong>?</p>
                                        <x-slot:footer>
                                            <form action="{{ route('delete_chamado', $chmd->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancelar</button>
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
                <input name="titulo" type="text" class="form-control" id="input_titulo" placeholder="Título">
                <label for="input_titulo">Título</label>
            </div>
            <div class="form-floating mb-3">
                <input name="solicitante" type="text" class="form-control" id="input_solicitante"
                    placeholder="Solicitante">
                <label for="input_solicitante">Solicitante</label>
            </div>
            <div class="form-floating mb-3">
                <textarea name="descricao" class="form-control" placeholder="Descrição" id="input_descricao" style="height: 120px"></textarea>
                <label for="input_descricao">Descrição da solicitação</label>
            </div>
            <div class="modal-footer px-0 pb-0">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success">Salvar Chamado</button>
            </div>
        </form>
    </x-modals.create>

@endsection
