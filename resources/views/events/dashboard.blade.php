@extends('layouts.template')  {{-- USA O LAYOUT PADRÃO --}}
@section('title', 'Painel') {{-- TITULO DA PAGE --}}

@section('content') {{-- CONTEUDO DA PAGE - INICIO --}}

<div class="container">

    <div class="col-mod-10 offset-md-1 dashboard-title-container">
        <h1>Meus eventos</h1>
    </div>
    <div class="col-mod-10 offset-md-1 dashboard-events-container">
        @if(count($events) > 0)  {{-- EVENTOS DO USUARIO --}}
        <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nome</th>
                <th scope="col">Paricipantes</th>
                <th scope="col">Ações</th>

              </tr>
            </thead>
            <tbody>
            @foreach ($events as $event)
                <tr>
                    <td>{{ $loop->index + 1}}</td> {{-- NUMERO CRESCENTE PARA CONTAR QUANTIDADES --}}
                    <td><a href="/events/{{ $event->id }}">{{ $event->titulo}}</a></td> {{-- MOSTRA O EVENTO EM LINK --}}
                    <td>{{ count($event->users)}} participantes</td>  {{-- NUMERO VEM DO METODO DE USER NO MODEL DE EVENT --}}
                    <td>
                        <a class="btn btn-warning" href="/events/edit/{{ $event->id }}"><ion-icon name="create-outline"></ion-icon> Editar</a>
                        <form action="/events/{{ $event->id }}" method="post" style="display: inline-block">
                            @csrf
                            @method('DELETE')  {{-- NECESSARIO PARA DELETAR NO BD --}}
                            <button class="btn btn-danger" type="submit"><ion-icon name="trash-outline"></ion-icon> Excluir</button>
                        </form>
                         
                    </td>
                </tr>

            @endforeach
              
            </tbody>
          </table>
        @else
            <p>Você não possui nenhum evento, <a href="/events/create">criar evento</a></p>
        @endif
    </div>

    <div class="col-mod-10 offset-md-1 dashboard-title-container">
        <h1>Eventos confirmados</h1>
    </div>
    <div class="col-mod-10 offset-md-1 dashboard-events-container">
    
        @if(count($eventsAsParticipant) > 0)  {{-- EVENTOS DO USUARIO CNFIRMADOS --}}
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Paricipantes</th>
                    <th scope="col">Ações</th>

                </tr>
                </thead>
                <tbody>
                @foreach ($eventsAsParticipant as $event)
                    <tr>
                        <td>{{ $loop->index + 1}}</td> {{-- NUMERO CRESCENTE PARA CONTAR QUANTIDADES --}}
                        <td><a href="/events/{{ $event->id }}">{{ $event->titulo}}</a></td> {{-- MOSTRA O EVENTO EM LINK --}}
                        <td>{{ count($event->users)}} participantes</td>  {{-- NUMERO VEM DO METODO DE USER NO MODEL DE EVENT --}}
                        <td>                            
                            <form action="/events/cancelarParticipacao/{{ $event->id }}" method="post" style="display: inline-block">
                                @csrf
                                @method('DELETE')  {{-- NECESSARIO PARA DELETAR NO BD --}}
                                <button class="btn btn-danger" type="submit"><ion-icon name="trash-outline"></ion-icon>Cancelar Participação</button>
                            </form>
                        </td>
                    </tr>

                @endforeach
                
                </tbody>
            </table>
        @else
            <p>Você não está participando de nenhum evento,  <a href="/">veja todos os eventos</a></p>
        @endif

    </div>
    
</div>
@endsection {{-- CONTEUDO DA PAGE - FIM --}}
