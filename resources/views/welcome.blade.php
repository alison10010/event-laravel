@extends('layouts.template')  {{-- USA O LAYOUT PADRÃO --}}
@section('title', 'Eventos') {{-- TITULO DA PAGE --}}

@section('content') {{-- CONTEUDO DA PAGE - INICIO --}}

<div id="search-container" class="col-md-12">
    <h1>Busque um evento</h1>
    <form action="/" method="GET">
        <input type="txt" id="search" name="search" class="form-control" placeholder="Pesquisar evento" />
    </form>
</div>

<div class="container">

    <div id="events-container" class="col-md-12">
        @if($search)
            <h2>Busca por: {{$search}}</h2> {{-- QUANDO HÁ BUSCA ESPECIFICA --}}
        @else 
            <h2>Próximos eventos</h2> {{-- QUANDO NÃO HÁ BUSCA --}}
        @endif
        <p class="subtitle">Veja os eventos dos próximos dias</p>
        <div id="cards-container" class="row">
            @foreach ($events as $event)    {{-- LISTA DE EVENTOS DO BD --}}        
            <div class="card col-md-3">
                <img src="/img/events/{{ $event->image }}" alt="{{ $event->titulo }}" />
                <div class="card-body">
                    <p class="card-date">{{ date('d/m/Y'), strtotime($event->date) }}</p>
                    <h5 class="card-title">{{ $event->titulo }}</h5>
                    <p class="card-participants">{{ count($event->users)}} participantes</p> {{-- NUMERO VEM DO METODO DE USER NO MODEL DE EVENT --}}
                    <a href="/events/{{ $event->id }}" class="btn btn-primary">Saber mais</a>
                </div>
            </div>
            @endforeach
            @if(count($events) == 0 && $search)
                <p>Não foi possivel encontrar nenhum evento com {{ $search }}! <a href="/">Ver todos!</a> !</p>
            @elseif(count($events) == 0) {{-- VERIFICA SE HÁ EVENTOS NA LISTA --}}
                <p>Não há eventos disponiveis no momento!</p>            
            @endif
        </div>
    </div>

</div>
@endsection  {{-- CONTEUDO DA PAGE - FIM --}}