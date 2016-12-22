<?php

namespace App\Http\Controllers;

use App\Caminhao;
use App\Motorista;
use App\Ocorrencia;
use App\TipoOcorrencia;
use Illuminate\Http\Request;
use App\Parceiro;
use App\Contato;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Request\ParceiroRequest;
use Datatables;
use Illuminate\Validation\Factory as Validate;
use League\Flysystem\Exception;

class ParceiroController extends Controller
{
    private $parceiro;
    private $request;
    private $caminhao;
    private $contato;
    private $motorista;
    private $validate;
    private $ocorrencia;
    private $tipoOcorrencia;

    public function __construct(Parceiro $parceiro, Request $request,
                                Caminhao $caminhao, Contato $contato,
                                Motorista $motorista,
                                Ocorrencia $ocorrencia,
                                TipoOcorrencia $tipoOcorrencia,
                                Validate $validate)
    {
        $this->middleware('auth');

        $this->parceiro = $parceiro;
        $this->request = $request;
        $this->caminhao = $caminhao;
        $this->contato = $contato;
        $this->motorista = $motorista;
        $this->validate = $validate;
        $this->ocorrencia = $ocorrencia;
        $this->tipoOcorrencia = $tipoOcorrencia;
    }

    public function index()
    {
        $parceiros = $this->parceiro->paginate(10);
        return view('painel.parceiros.index2', compact('parceiros'));
    }

    public function pesquisar()
    {
//        $palavraPesquisa = $this->request->input('pesquisar');

        $palavraPesquisa = $this->request->get('nome');
        $dadosPesquisa = Parceiro::query()->select("parceiros.id",
            "parceiros.nome",
            "parceiros.documento",
//            "parceiros.email",
            "parceiros.telefone",
//            "parceiros.data_nasc",
//            "parceiros.sexo",
            "parceiros.endereco",
//            "parceiros.numero",
            "parceiros.cidade",
            "parceiros.estado")->where('nome', 'LIKE', "%$palavraPesquisa%")
                                ->paginate(10);

//
        return view("painel.parceiros.index", compact('dadosPesquisa'));
//
//        $dataBusca = $this->parceiro
//            ->where('nome', 'LIKE', "%$palavraPesquisa%")
//            ->paginate(10);

//        return $data;
//        return view("painel.parceiros.index", compact('dataBusca'));
    }

    public function store(ParceiroRequest $request)
    {

        //Pega os dados do formulário
//        $dataForm = $request->all();

//        $validator = validator($request->all(),[
//              'nome' => 'required|min:3|max:60',
//              'email' => 'required|min:6|max:150'
//         ]);
//
//        if($validator->fails()){
//              return redirect()->withErrors($validator)->withInput();
//         }

        $data['pessoa'] = Parceiro::getPessoa($request->get('pessoa'));
        $dataParc = $request->except(['extras', 'extraCaminhoes', 'extraMotoristas', 'count']);
        $dataCont = $request->only(['extras']);
        $dataCam = $request->only(['extraCaminhoes']);
        $dataMot = $request->only(['extraMotoristas']);

        \DB::beginTransaction();
//        dd(strlen($dataParc['documento']) === 0);
        if(strlen($dataParc['documento']) === 0){
            $dataParc['documento'] = null;
        }
        if(isset($dataParc['data_nasc']) && strlen($dataParc['data_nasc']) === 0){
            $dataParc['data_nasc'] = null;
        }
//        dd($dataParc);


        $parceiro = $this->parceiro->create($dataParc);



//
        foreach ($dataCont['extras'] as $extra) {
            $contatos = Contato::create([
                'nome' => $extra['nome'],
                'setor' => $extra['setor'],
                'email' => $extra['email'],
                'telefone' => $extra['telefone'],
                'id_parceiro' => $parceiro->id
            ]);
        }

        foreach ($dataCam['extraCaminhoes'] as $extraCaminhoes) {
//        dd($extraCaminhoes['placa']);
            $caminhoes = Caminhao::create([
                'placa' => $extraCaminhoes['placa'],
                'modelo' => $extraCaminhoes['modelo'],
                'cor' => $extraCaminhoes['cor'],
                'id_parceiro' => $parceiro->id
            ]);
        }

        foreach ($dataMot['extraMotoristas'] as $extraMotoristas) {

            $motoristas = Motorista::create([
                'nome' => $extraMotoristas['nome'],
                'rg' => $extraMotoristas['rg'],
                'telefone' => $extraMotoristas['telefone'],
                'id_parceiro' => $parceiro->id
            ]);

        }


        if ($parceiro && $caminhoes && $motoristas) {
            echo 'Sucesso';
            \DB::commit();
        } else {
            echo 'Falha';
            \DB::rollBack();
        }

        return redirect()->route('parceiros.index');
    }


    public function create()
    {
        $paramPessoa = $this->request->get('pessoa');
        $pessoa = Parceiro::getPessoa($paramPessoa);
        $titulo = "Adicionar Parceiro";
        return view('painel.parceiros.create', compact('titulo', 'pessoa'));
    }

    public function cadastrar()
    {
        $titulo = "Adicionar Parceiro";
        return view('painel.parceiros.gerenciar', compact('titulo'));
    }

    public function show()
    {

    }

    public function listaParceiros()
    {
/*
        return '{ "data": '. Parceiro::query()->select("parceiros.id",
            "parceiros.nome",
            "parceiros.documento",
//            "parceiros.email",
            "parceiros.telefone",
            "parceiros.cep",
//            "parceiros.data_nasc",
//            "parceiros.sexo",
            "parceiros.endereco",
            "parceiros.bairro",
//            "parceiros.numero",
            "parceiros.cidade",
            "parceiros.estado")->get()->toJson().'}';
*/

         return Datatables::of(Parceiro::query()
            ->select("parceiros.id",
                "parceiros.nome",
                "parceiros.documento",
//            "parceiros.email",
                "parceiros.telefone",
                "parceiros.cep",
//            "parceiros.data_nasc",
//            "parceiros.sexo",
                "parceiros.endereco",
                "parceiros.bairro",
//            "parceiros.numero",
                "parceiros.cidade",
                "parceiros.estado"))
            ->make(true);
        //return Datatables::of(Visitante::query()
        //      ->select("visitantes.nome", "visitantes.estado", "visitantes.cidade", "visitantes.telefone", "visitantes.cargo", "visitantes.cidade", "visitantes.email"))->make(true);

    }

    public function deleteParceiro($id)
    {
        Parceiro::findOrFail($id)->delete();
        return 1;
    }

    public function deleteMotorista($id)
    {
        Motorista::findOrFail($id)->delete();
        return 1;
    }

    public function deleteOcorrencia($id)
    {
        Ocorrencia::findOrFail($id)->delete();
        return 1;
    }



    public function edit($id)
    {
        $titulo = 'Editar Parceiro';
//        $dataParc = $request->except(['extras', 'extraCaminhoes', 'extraMotoristas', 'count']);
//        $dataCont = $request->only(['extras']);
//        $dataCam = $request->only(['extraCaminhoes']);
//        $dataMot = $request->only(['extraMotoristas']);
        $caminhoes = $this->caminhao->all()->where('id_parceiro', $id);
        $contatos = $this->contato->all()->where('id_parceiro', $id);
        $motoristas = $this->motorista->all()->where('id_parceiro', $id);
        $ocorrencias = Ocorrencia::query()
            ->join('users', 'users.id', '=', 'ocorrencias.id_usuario')
            ->join('tipo_ocorrencias', 'tipo_ocorrencias.id', '=', 'ocorrencias.id_tipo_ocorrencia')
            ->select("ocorrencias.id", "ocorrencias.data", "tipo_ocorrencias.nome as tipo", "ocorrencias.descricao", "users.name as usuario")
            ->where('id_parceiro', $id)->paginate(10);
        $tipo_ocorrencia = $this->tipoOcorrencia->pluck('nome', 'id')->toArray();

//        dd($motoristas);

//        dd($motoristas);
        if (!($parceiro = Parceiro::find($id))) {
            throw new ModelNotFoundException("Parceiro não foi encontrado");
        }
        $pessoa = $parceiro->pessoa;
        return view('painel.parceiros.edit', compact('parceiro', 'tipo_ocorrencia', 'pessoa', 'titulo', 'caminhoes', 'contatos', 'motoristas', 'ocorrencias'));
    }

    public function update(ParceiroRequest $request, $id)
    {
        if (!($parceiro = Parceiro::find($id))) {
            throw new ModelNotFoundException("Parceiro não foi encontrado");
        }

        $contatosDB = Contato::where('id_parceiro', $id)->get()->keyBy('id');
        $caminhoesDB = Caminhao::where('id_parceiro', $id)->get()->keyBy('id');
        $motoristasDB = Motorista::where('id_parceiro', $id)->get()->keyBy('id');

        $dataParc = $request->except(['extras', 'extraCaminhoes', 'extraMotoristas', 'count']);
        $dataCont = $request->only(['extras']);
        $dataCam = $request->only(['extraCaminhoes']);
        $dataMot = $request->only(['extraMotoristas']);

        $validate = $this->validate->make($dataParc, Parceiro::$rules);
        if($validate->fails()){
            $messages = $validate->messages();
            $displayErrors = '';

            foreach($messages->all("<p>:message</p>") as $error){
                $displayErrors .= $error;
            }

            return $displayErrors;
        }



        if(is_array($dataCont['extras'])) {
            foreach ($dataCont['extras'] as $extra) {

                if (key_exists('id', $extra)) {
                    $idContato = intval($extra['id']);
                } else {
                    $idContato = 0;
                }
                if ($idContato > 0) {
                    if (!($contato = Contato::find($idContato))) {
                        throw new ModelNotFoundException("Contato não foi encontrado");
                    } else {
//                    dd($extra);
                        $contato->fill($extra);
                        $contato->save();
                        $contatosDB[$idContato]['presente'] = true;
                    }
                } else {

                    $contatos = Contato::create([
                        'nome' => $extra['nome'],
                        'setor' => $extra['setor'],
                        'email' => $extra['email'],
                        'telefone' => $extra['telefone'],
                        'id_parceiro' => $parceiro->id
                    ]);
                }
            }
        }

        foreach ($contatosDB as $contato) {
            if(!$contato['presente']){
                Contato::find($contato['id'])->delete();
            }
        }


        if(is_array($dataCam['extraCaminhoes'])) {
            foreach ($dataCam['extraCaminhoes'] as $extraCaminhoes) {

//            dd($extraCaminhoes);
                if (key_exists('id', $extraCaminhoes)) {
                    $idCaminhao = intval($extraCaminhoes['id']);
                } else {
                    $idCaminhao = 0;
                }
                if ($idCaminhao > 0) {
                    if (!($caminhao = Caminhao::find($idCaminhao))) {
                        throw new ModelNotFoundException("Caminhão não foi encontrado");
                    } else {
                        $caminhao->fill($extraCaminhoes);
                        $caminhao->save();
                        $caminhoesDB[$idCaminhao]['presente'] = true;
                    }
                } else {

                    $caminhoes = Caminhao::create([
                        'placa' => $extraCaminhoes['placa'],
                        'modelo' => $extraCaminhoes['modelo'],
                        'cor' => $extraCaminhoes['cor'],
                        'id_parceiro' => $parceiro->id
                    ]);

                }
            }
        }


        foreach ($caminhoesDB as $caminhao) {
            if(!$caminhao['presente']){
                Caminhao::find($caminhao['id'])->delete();
            }
        }

        if(is_array($dataMot['extraMotoristas'])) {
            foreach ($dataMot['extraMotoristas'] as $extraMotoristas) {

                if (key_exists('id', $extraMotoristas)) {
                    $idMotorista = intval($extraMotoristas['id']);
                } else {
                    $idMotorista = 0;
                }
                if ($idMotorista > 0) {
                    if (!($motorista = Motorista::find($idMotorista))) {
                        throw new ModelNotFoundException("Motorista não foi encontrado");
                    } else {
                        $motorista->fill($extraMotoristas);
                        $motorista->save();
                        $motoristaDB[$idMotorista]['presente'] = true;
                    }
                } else {

                    $motoristas = Motorista::create([
                        'nome' => $extraMotoristas['nome'],
                        'rg' => $extraMotoristas['rg'],
                        'telefone' => $extraMotoristas['telefone'],
                        'id_parceiro' => $parceiro->id
                    ]);

                }
            }
        }


        foreach ($motoristasDB as $motorista) {
//            dd($motorista);
            if(!$motorista['presente']){
                Motorista::find($motorista['id'])->delete();
            }
        }

        $parceiro->fill($dataParc);
        $parceiro->save();

//        $motorista = Motorista::find($idMotorista);
        if ($parceiro) {
            echo 'Sucesso';
            \DB::commit();
        } else {
            echo 'Falha';
            \DB::rollBack();
        }


//        return "Editando Parceiro";
        return redirect()->route('parceiros.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!($parceiro = Parceiro::find($id))) {
            throw new ModelNotFoundException("Parceiro não foi encontrado");
        }

        $parceiro->delete();
        return redirect()->route('parceiros.index');
    }

    public function postOcorrencia()
    {
        $data = $this->request->all();
//        dd($data);//
        $dataOcorrencia = implode('-',array_reverse(explode('/', $data['data'])));

        $validate = $this->validate->make($data, Ocorrencia::$rules);
        if($validate->fails()){
            $messages = $validate->messages();
            $displayErrors = '';

            foreach($messages->all("<p>:message</p>") as $error){
                $displayErrors .= $error;
            }

            return $displayErrors;
        }

//        dd($data);

        $ocorrencia = Ocorrencia::create([
            'data' => $dataOcorrencia,
            'id_tipo_ocorrencia' => $data['id_tipo_ocorrencia'],
            'id_usuario' => $data['id_usuario'],
            'id_parceiro' => $data['id_parceiro'],
            'descricao' => $data['descricao']
        ]);

        if($ocorrencia){
            return 1;
        }else{
            return "Erro Inesperado";
        }


//        return redirect()->route('parceiros.index');
    }

    public function postTipoOcorrencia()
    {
        $dataForm = $this->request->all();

        $validate = $this->validate->make($dataForm, TipoOcorrencia::$rules);
        if($validate->fails()){
            $messages = $validate->messages();
            $displayErrors = '';

            foreach($messages->all("<p>:message</p>") as $error){
                $displayErrors .= $error;
            }

            return $displayErrors;
        }

//        dd($dataForm);
        TipoOcorrencia::create($dataForm);
        return 1;

//        return redirect()->route('parceiros.index');
    }

}
