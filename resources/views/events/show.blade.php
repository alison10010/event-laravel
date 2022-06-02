@extends('layouts.template')  {{-- USA O LAYOUT PADRÃO --}}
@section('title', $event->titulo) {{-- TITULO DA PAGE --}}

@section('content') {{-- CONTEUDO DA PAGE - INICIO --}}

<div class="container">

    <div class="col-md10 offset-md-1">
        <div class="row">
            <div id="image-container" class="col-md-6">
                <img src="/img/events/{{ $event->image }}" class="img-fluid" alt="{{$event->titulo}}" />
            </div>
            <div id="info-container" class="col-md-6">
                <h2>{{$event->titulo}}</h2>
                <p class="event-city"><ion-icon name="location-outline"></ion-icon> {{$event->cidade}}</p>
                <p class="event-city"><ion-icon name="calendar-outline"></ion-icon> {{ date('d/m/Y'), strtotime($event->date) }}</p>
                <p class="events-participants"><ion-icon name="people-outline"></ion-icon> {{ count($event->users)}} participantes</p> {{-- NUMERO VEM DO METODO DE USER NO MODEL DE EVENT --}}
                <p class="event-owner"><ion-icon name="star-outline"></ion-icon>{{ $event->user->name }}</p> {{-- CRIADOR DO EVENTO ATRAVES DO ID--}}
                
                @if (!$participantaEvento) {{-- VERIFICA SE ESTÁ PARTICIPANDO DO EVENTO --}}
                    <form action="/events/join/{{ $event->id }}" method="POST">
                        @csrf {{-- NECESSARIO PARA REALIZAR A CONFIRMACAO DE FORM --}}
                        <a href="/events/join/{{ $event->id }}" class="btn btn-primary" id="event-submit"
                            onclick="event.preventDefault(); 
                            this.closest('form').submit();">Confirmar presença</a>
                    </form>
                @else
                    <br />
                    <p class="event-owner"><ion-icon name="checkmark-done-outline"></ion-icon>Você está participando deste evento!</p>
                @endif
                    <br />
                <h3>O evento conta com:</h3>
                <ul id="items-list">
                    @foreach($event->items as $item)
                       <li><ion-icon name="play-outline"></ion-icon> <span>{{ $item }}</span></li>  
                    @endforeach
                </ul>
            </div>
            <div id="descricao-container" class="col-md-12">
                <h3>Sobre o evento</h3>
                <p class="event-description">{{$event->descricao}}</p>
            </div>
        </div>
    </div>

 </div>
@endsection {{-- CONTEUDO DA PAGE - FIM --}}