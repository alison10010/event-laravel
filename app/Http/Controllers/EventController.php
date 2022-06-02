<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\User;

class EventController extends Controller
{
    public function index(){

        $search = request('search'); // PESQUISA EVENTO

        if($search){ // SE FOR PESQUISADO ALGO RETORNA RESULTO, SENÃO, TRAZ TODOS OS EVENTOS DA LISTA
            
            $events = Event::where([
                ['titulo', 'like', '%'.$search.'%']
            ])->get(); // BUSCA O NOME DO TITULO NO BD

        }else{
            $events = Event::all(); // PEGA TODOS OS REGISTROS DO BD DA TABELA EVENTO
        }
        
        return view('welcome',['events' => $events, 'search' => $search]); // RETORNA PARA A PAGE WELCOME
    }

    public function create(){
        return view('events.create');
    }

    public function store(Request $request){
       
        $event = new Event;

        $event->titulo = $request->titulo;
        $event->date = $request->date; //  (ESPECIFICA NO MODEL)
        $event->cidade = $request->cidade;
        $event->privato = $request->privato;
        $event->descricao = $request->descricao;
        $event->items = $request->items; // ARRAY (ESPECIFICA NO MODEL)

        // IMAGE UPLOAD
        if($request->hasFile('image') && $request->file('image')->isValid()){
           
            $requestImage = $request->image;
           
            $extension = $requestImage->extension(); // EXTENSAO DA IMAGE

            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." .$extension; // GERA NOME UNICO P/ IMAGE 

            $requestImage->move(public_path('img/events'), $imageName); // SALVA IMAGE NA PASTA PUBLIC EVENTS

            $event->image = $imageName; // O Q SERÁ SALVO NO BD
        }

        $user = auth()->user(); // PEGA O USER LOGADO E ATRIBUI EM VARIAVEL

        $event->user_id = $user->id; // ATRIBUI O ID DO USUARIO LOGADO NO USER_ID DO POSTO

        $event->save();  // SALVA NO BD

        return redirect('/')->with('msg', 'Evento criado com sucesso!'); // REDIRECIONA PARA A HOME COM MSG

    }

    // BUSCA POR UM EVENTO ESPECIFICO PELO ID
    public function show($id){
        $event = Event::findOrFail($id);

        $user = auth()->user(); // PEGA USER LOGADO

        $participantaEvento = false;

        if($user){
            $userEvents = $user->eventsAsParticipant->toArray();  // EVENTOS QUE O USER ESTÁ PARTICIPANDO 
            
            foreach($userEvents as $userEvent){  // EVENTOS QUE O USER PARTICIPA
                if($userEvent['id'] == $id){  // VERIFICA SE ID DO EVENTO PASSADO VIA PARAMETRO ESTÁ NA LISTA
                    $participantaEvento = true;  // USUARIO JA PARTICIPA DO EVENTO
                }
            }
        }

        return view('events.show', ['event' => $event, 'participantaEvento' => $participantaEvento]); // PASSANDO AS VARIAVEIS
        
    }

    // BUSCA POR EVENTOS CADASTRADOS DO USUARIO
    public function dashboard(){

        $user = auth()->user(); // PEGA USER LOGADO

        $events = $user->events;  // EVENTOS CRIADOS PELO USER

        $eventsAsParticipant = $user->eventsAsParticipant; // EVENTOS QUE O USER ESTÁ PARTICIPANTO

        return view('events.dashboard', ['events' => $events, 'eventsAsParticipant' => $eventsAsParticipant]);
    }

    // DELETA UM EVENTO PELO ID
    public function destroy($id){
        
        $event = Event::findOrFail($id)->delete(); 

        return redirect('/dashboard')->with('msg', 'Evento excluido com sucesso!'); // REDIRECIONA PARA A DASHBOARD COM MSG
    }

    // PASSA VALORES PARA EDIÇÃO NO BD
    public function edit($id){

        $user = auth()->user(); // PEGA O USER LOGADO
        
        $event = Event::findOrFail($id); 

        if($user->id != $event->user_id){  // CASO O EVENTO A SER EDITADO NAO SEJA DO USER LOGADO
            return redirect('/dashboard');
        }

        return view('events.edit', ['event' => $event]); // PASSANDO AS VARIAVEIS
    }

    // DELETA UM EVENTO PELO ID
    public function update(Request $request){

        $data = $request->all();

        // IMAGE UPLOAD
        if($request->hasFile('image') && $request->file('image')->isValid()){
           
            $requestImage = $request->image;
           
            $extension = $requestImage->extension(); // EXTENSAO DA IMAGE

            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." .$extension; // GERA NOME UNICO P/ IMAGE 

            $requestImage->move(public_path('img/events'), $imageName); // SALVA IMAGE NA PASTA PUBLIC EVENTS

            $data ['image'] = $imageName; // O Q SERÁ SALVO NO BD
        }
        
        $event = Event::findOrFail($request->id)->update($data); // ATUALIZA TODOS OS DADOS DO EVENTO (MODIFICAR NO MODEL TBÉM)

        return redirect('/dashboard')->with('msg', 'Evento editado com sucesso!'); // REDIRECIONA PARA A DASHBOARD COM MSG
    }

    // CONFIMA PARTICIPACAO EM EVENTO
    public function joinEvent($id){

        $user = auth()->user();

        $user->eventsAsParticipant()->attach($id); // INSERE O ID DO USER E ID DO EVENTO NA TABELA

        $event = Event::findOrFail($id);  // PEGA O NOME DO EVENTO PARA MANDA VIA MSG

        return redirect('/dashboard')->with('msg', 'Sua presença foi confirmada no evento '. $event->titulo); // REDIRECIONA PARA A DASHBOARD COM MSG

    }

    public function cancelarParticipacao($id){

        $user = auth()->user(); // PEGA O USER LOGADO

        $user->eventsAsParticipant()->detach($id);  // REMOVE A LIGACAO DO USER DO EVENTO

        $event = Event::findOrFail($id);

        return redirect('/dashboard')->with('msg', 'Sua presença foi removida do evento: '. $event->titulo); // REDIRECIONA PARA A DASHBOARD COM MSG


    }
}
