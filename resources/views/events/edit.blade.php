@extends('layouts.template')  {{-- USA O LAYOUT PADRÃO --}}
@section('title', 'Editar evento') {{-- TITULO DA PAGE --}}

@section('content') {{-- CONTEUDO DA PAGE - INICIO --}}
    <div id="event-create-container" class="col-md-6 offset-md-3">
        <h1>Edirando evento: {{ $event->titulo }}</h1>
        <form action="/events/update/{{ $event->id }}" method="POST" enctype="multipart/form-data">
            @csrf {{-- NECESSARIO PARA REALIZAR A EDIÇÃO DO FORM NO BD --}}
            @method('PUT') {{-- NECESSARIO PARA REALIZAR A EDIÇÃO DO FORM NO BD --}}
            <div class="form-group">
                <label for="image">Imagen do evento:</label>
                <input type="file" class="form-control-file" id="image" name="image">
                <img src="/img/events/{{$event->image}}" class="img-preview">
            </div>
            <div class="form-group">
                <label for="titulo">Evento:</label>
                <input type="txt" class="form-control" id="titulo" name="titulo" value="{{$event->titulo}}" required>
            </div>
            <div class="form-group">
                <label for="titulo">Data do Evento:</label>
                <input type="date" class="form-control" id="date" name="date" value="{{$event->date->format('Y-m-d')}}" required>
            </div>
            <div class="form-group">
                <label for="cidade">Cidade:</label>
                <input type="txt" class="form-control" id="cidade" name="cidade" value="{{$event->cidade}}" required>
            </div>
            <div class="form-group">
                <label for="privato">O evento é privato?</label>
                <select name="privato" id="privato" class="form-control" required>
                    <option value="0">Não</option>
                    <option value="1" {{$event->private == 1 ? "selected='selected'" : ""}}>Sim</option>
                </select>
            </div>
            <div class="form-group">
                <label for="titulo">Descrição do evento:</label>
                <textarea name="descricao" id="descricao" class="form-control">{{$event->descricao}}</textarea>
            </div>
            <div class="form-group">
                <label for="titulo">Itens do evento:</label>
                <div class="form-group">
                    <input type="checkbox" name="items[]" value="Cadeiras">Cadeiras
                </div>
                <div class="form-group">
                    <input type="checkbox" name="items[]" value="Palco">Palco
                </div>
                <div class="form-group">
                    <input type="checkbox" name="items[]" value="Cerveja grátis">Cerveja grátis
                </div>
                <div class="form-group">
                    <input type="checkbox" name="items[]" value="omida grátis">Comida grátis
                </div>
                <div class="form-group">
                    <input type="checkbox" name="items[]" value="Som">Som
                </div>
            </div>

            <br />
            <input type="submit" class="btn btn-primary" value="Editar evento">
        </form>
    </div>

@endsection  {{-- CONTEUDO DA PAGE - FIM --}}