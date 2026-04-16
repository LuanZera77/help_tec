@extends('layout.index')
@section('title', 'Chamados')
@section('content')

    <section>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formAdd">
            Adicionar
        </button>
        <x-modals.create id="formAdd" title="Adicionar">
            @csrf
            <form action="{{ route('create_chamado') }}" method="post">
                @csrf
                <div class="form-floating mb-3">
                    <input name="titulo" type="text" class="form-control" id="input_titulo">
                    <label for="input_titulo">Título</label>
                </div>
                <div class="form-floating mb-3">
                    <input name="solicitante" type="text" class="form-control" id="input_solicitante">
                    <label for="input_solicitante">Solicitante</label>
                </div>
                <div class="form-floating">
                    <textarea name="descricao" class="form-control" placeholder="Leave a comment here" id="input_descricao"
                        style="height: 100px"></textarea>
                    <label for="input_descricao">Descreva a solicitação</label>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Confirmar</button>
                </div>
            </form>
        </x-modals.create>
    </section>
    <section>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Título</th>
                    <th scope="col">Solicitante</th>
                    <th scope="col">Data de Abertura</th>
                    <th scope="col">Data de Fechamento</th>
                    <th scope="col">Status</th>
                    <th scope="col">Descrição</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($chamados as $key => $chmd)
                    <tr>
                        <td>{{ $chmd->id }}</td>
                        <td>{{ $chmd->titulo }}</td>
                        <td>{{ $chmd->solicitante }}</td>
                        <td>{{ \Carbon\Carbon::parse($chmd->data_de_abertura)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($chmd->data_de_fechamando)->format('d/m/y') }}</td>
                        <td>{{ $chmd->status }}</td>
                        <td>{{ $chmd->descricao }}</td>
                        <td>
                            {{-- Excluir --}}
                            <section>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#{{ $chmd->id }}">
                                    Excluir Chamado
                                </button>

                                <x-modals.confirm-action id="{{ $chmd->id }}" title="Confirmar Exclusão">
                                    Tem certeza que deseja apagar este registro? Esta ação é irreversível.

                                    <x-slot:footer>
                                        <form action="{{ route('delete_chamado', $chmd->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Excluir</button>
                                        </form>
                                    </x-slot:footer>
                                </x-modals.confirm-action>
                            </section>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>

@endsection
