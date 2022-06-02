<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        {{-- BOOTSTRAP DO GOOGLE --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        {{-- FONTE DO GOOGLE --}}
        <link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">

        {{-- STYLES --}}
        <link href="/css/estilo.css" rel="stylesheet"> {{-- VEM DA PASTA PUBLIC --}}
        <script src="/js/meuScript.js"></script> {{-- VEM DA PASTA PUBLIC --}}

    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="collapse navbar-collapse" id="navbar">
                    <a href="/" class="nav-brand">
                        <img src="/img/logo.png"/>
                    </a>
                    <ul class="navbar-nav">
                        <li class="navbar-item">
                            <a href="/" class="nav-link">Eventos</a>
                        </li>
                        <li class="navbar-item">
                            <a href="/events/create" class="nav-link">Criar eventos</a>
                        </li>
                        @auth {{-- MOSTRA SE TIVER AUTENTICADO --}}    
                        <li class="navbar-item">
                            <a href="/dashboard" class="nav-link">Meus eventos</a>
                        </li>   
                        <li class="navbar-item">
                            <form action="/logout" method="POST">
                                @csrf
                                <a href="/logout" class="nav-link" onclick="event.preventDefault(); 
                                   this.closest('form').submit();">Sair</a>
                            </form>                            
                        </li>                          
                        @endauth
                        @guest {{-- REMOVE SE TIVER AUTENTICADO --}}
                        <li class="navbar-item">
                            <a href="/login" class="nav-link">Entrar</a>
                        </li>
                        <li class="navbar-item">
                            <a href="/register" class="nav-link">Registrar</a>
                        </li>    
                        @endguest
                    </ul>
                </div>
            </nav>
        </header>
        <main>
            <div class="container-fluid">
                <div class="row">
                    @if(session('msg'))  {{-- VERIFICA SE EXISTE MSG NA SESSÃO --}}
                        <p class="msg">{{ session('msg')}}</p>
                    @endif
                    @yield('content') {{-- CONTEUDO DAS PAGINAS --}}
                </div>
            </div>
        </main>
        
        <footer>
            <p>ALISON RODAPÉ 2022</p>
        </footer>

        {{-- SCRIPT DE ICONS --}}
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    </body>
</html>
