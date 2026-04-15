@extends('layout.index')
@section('title', 'Chamados')
@section('content')

    <section>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formAdd">
            Adicionar
        </button>
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
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="formAdd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Understood</button>
                </div>
            </div>
        </div>
    </div>

@endsection
