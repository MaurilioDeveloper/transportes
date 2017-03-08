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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Return view for listing Parceiros
     */
    public function index()
    {
        $titulo = "Listagem de Parceiros";
        $parceiros = $this->parceiro->paginate(10);
        return view('painel.parceiros.index2', compact('parceiros', 'titulo'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Search Parceiro by name
     */
    public function pesquisar()
    {

        $palavraPesquisa = $this->request->get('nome');
        $dadosPesquisa = Parceiro::query()->select("parceiros.id",
            "parceiros.nome",
            "parceiros.email",
            "parceiros.telefone",
            "parceiros.endereco",
            "parceiros.cidade")->where('nome', 'LIKE', "%$palavraPesquisa%")
                                ->paginate(10);

        return view("painel.parceiros.index2", compact('palavraPesquisa'));

    }

    /**
     * @param ParceiroRequest $request
     * @return \Illuminate\Http\RedirectResponse|int
     * POST for create a new Parceiro
     */
    public function store(ParceiroRequest $request)
    {

        $data['pessoa'] = Parceiro::getPessoa($request->get('pessoa'));
        $dataParc = $request->except(['extras', 'extraCaminhoes', 'extraMotoristas', 'count']);
        $dataCont = $request->only(['extras']);
        $dataCam = $request->only(['extraCaminhoes']);
        $dataMot = $request->only(['extraMotoristas']);

//        \DB::beginTransaction();

        if($data['pessoa'] === "fisica") {
            if (strlen($dataParc['data_nasc']) <= 1) {
                $dataParc['data_nasc'] = null;
            } else {
                $dataParc['data_nasc'] = implode('-', array_reverse(explode('/', $dataParc['data_nasc'])));
            }
        }
        if(strlen($dataParc['documento']) == 0){

            $dataParc['documento'] = NULL;
        }

        $this->validationParceiro($dataParc, Parceiro::$rules);

        $parceiro = $this->parceiro->create($dataParc);

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
            \DB::commit();
            return 1;
        } else {
            echo 'Falha';
            \DB::rollBack();
        }

        return redirect()->route('parceiros.index2');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Return view for create a new Parceiro
     */
    public function create()
    {
        $paramPessoa = $this->request->get('pessoa');
        $pessoa = Parceiro::getPessoa($paramPessoa);
        $titulo = "Cadastrar Parceiro";
        return view('painel.parceiros.create', compact('titulo', 'pessoa'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Return view for switch a type of person, Physical Person or Legal Person
     */
    public function cadastrar()
    {
        $titulo = "Adicionar Parceiro";
        return view('painel.parceiros.gerenciar', compact('titulo'));
    }

    /**
     * @return mixed
     * Return listing of data with Datatables
     */
    public function listaParceiros()
    {

         return Datatables::of(Parceiro::query()
             ->leftJoin('motoristas','motoristas.id_parceiro','=','parceiros.id')
             ->leftJoin('caminhoes','caminhoes.id_parceiro','=','parceiros.id')
            ->select("parceiros.id",
                    "parceiros.nome",
                    "parceiros.email",
                    "parceiros.telefone",
                    "parceiros.endereco",
                    "parceiros.bairro",
                    "parceiros.cidade"
            )->selectRaw('count(motoristas.id) as motoristas')
            ->selectRaw('count(caminhoes.id) as caminhoes')
             ->groupBy('parceiros.id'))
            ->make(true);

    }

    /**
     * @param $id
     * @return int
     * Delete Parceiro by ID
     */
    public function deleteParceiro($id)
    {
        Parceiro::findOrFail($id)->delete();
        return 1;
    }

    /**
     * @param $id
     * @return int
     * Delete Motorista by ID
     */
    public function deleteMotorista($id)
    {
        Motorista::findOrFail($id)->delete();
        return 1;
    }

    /**
     * @param $id
     * @return int
     * Delete Ocorrência by ID
     */
    public function deleteOcorrencia($id)
    {
        Ocorrencia::findOrFail($id)->delete();
        return 1;
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Return view for edit a Parceiro
     */
    public function edit($id)
    {
        $titulo = 'Editar Parceiro';
        $data_nascimento = str_replace('["', '', str_replace('"]', '',$this->parceiro->where('id', $id)->pluck('data_nasc')->toJson()));

        $data_nasc = implode('/',array_reverse(explode('-', $data_nascimento)));
        if($data_nasc == '[null]'){
            $data_nasc = null;
        }
        $caminhoes = $this->caminhao->all()->where('id_parceiro', $id);
        $contatos = $this->contato->all()->where('id_parceiro', $id);
        $motoristas = $this->motorista->all()->where('id_parceiro', $id);
        $ocorrencias = Ocorrencia::query()
            ->join('users', 'users.id', '=', 'ocorrencias.id_usuario')
            ->join('tipo_ocorrencias', 'tipo_ocorrencias.id', '=', 'ocorrencias.id_tipo_ocorrencia')
            ->select("ocorrencias.id", "ocorrencias.data", "tipo_ocorrencias.nome as tipo", "ocorrencias.descricao", "users.name as usuario")
            ->where('id_parceiro', $id)->paginate(10);
        $tipo_ocorrencia = $this->tipoOcorrencia->pluck('nome', 'id')->toArray();

        if (!($parceiro = Parceiro::find($id))) {
            throw new ModelNotFoundException("Parceiro não foi encontrado");
        }

        $pessoa = $parceiro->pessoa;
        return view('painel.parceiros.edit', compact('parceiro', 'tipo_ocorrencia', 'pessoa', 'titulo', 'caminhoes', 'contatos', 'motoristas', 'ocorrencias', 'data_nasc'));
    }

    /**
     * @param ParceiroRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|int
     * PUT responsible for UPDATE a Parceiro by ID
     */
    public function update(ParceiroRequest $request, $id)
    {
        if (!($parceiro = Parceiro::find($id))) {
            throw new ModelNotFoundException("Parceiro não foi encontrado");
        }

        $contatosDB = Contato::where('id_parceiro', $id)->get()->keyBy('id');
        $caminhoesDB = Caminhao::where('id_parceiro', $id)->get()->keyBy('id');
        $motoristasDB = Motorista::where('id_parceiro', $id)->get()->keyBy('id');

        $data['pessoa'] = Parceiro::getPessoa($request->get('pessoa'));
        $dataParc = $request->except(['extras', 'extraCaminhoes', 'extraMotoristas', 'count']);
        $dataCont = $request->only(['extras']);
        $dataCam = $request->only(['extraCaminhoes']);
        $dataMot = $request->only(['extraMotoristas']);


        $rules = [
            'nome' => 'required',
            'documento' => "unique:parceiros,documento,{$id}",
        ];


        $this->validationParceiro($dataParc, $rules);


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
//                dd($extraMotoristas);
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
                        $motoristasDB[$idMotorista]['presente'] = true;
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
            if(!$motorista['presente']){
                Motorista::find($motorista['id'])->delete();
            }
        }

        if($data['pessoa'] === "fisica") {

            if (isset($dataParc['data_nasc']) && strlen($dataParc['data_nasc']) <= 1) {
                $dataParc['data_nasc'] = null;
            } else if ($dataParc['data_nasc'] == "[null]") {
                $dataParc['data_nasc'] = null;
            } else {
                $dataParc['data_nasc'] = implode('-', array_reverse(explode('/', $dataParc['data_nasc'])));
            }
        }

        if(strlen($dataParc['documento']) == 1){
            $dataParc['documento'] = null;
        }

        $parceiro->fill($dataParc);
        $parceiro->save();

        if ($parceiro) {
            \DB::commit();
            return 1;
        } else {
            echo 'Falha';
            \DB::rollBack();
        }


        return redirect()->route('parceiros.index2');
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
        return redirect()->route('parceiros.index2');
    }

    /**
     * @return int|string
     * POST for create a new Ocorrencia
     */
    public function postOcorrencia()
    {
        $data = $this->request->all();
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

    }

    /**
     * @param $id
     * @return mixed
     *
     */
    public function editOcorrencia($id)
    {
        if (!($ocorrencia = Ocorrencia::find($id))) {
            throw new ModelNotFoundException("Ocorrencia não foi encontrada");
        }

        $ocorrencia->data =implode('/', array_reverse(explode('-', $ocorrencia->data)));

        return $ocorrencia;

    }

    /**
     * @param $id
     * @return int
     * PUT for update a Ocorrência
     */
    public function updateOcorrencia($id)
    {
        $dadosForm = $this->request->all();
        $dadosForm['data'] = implode('-', array_reverse(explode('/', $dadosForm['data'])));

        if (!($ocorrencia = Ocorrencia::find($id))) {
            throw new ModelNotFoundException("Ocorrencia não foi encontrada");
        }

        $ocorrencia->fill($dadosForm);
        $ocorrencia->save();

        return 1;
    }

    /**
     * @return int|string
     * POST for create a new Tipo de Ocorrencia in a Parceiro
     */
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

        TipoOcorrencia::create($dataForm);
        return 1;
    }


    /**
     * @param $dadosForm
     * @return string
     * Method used in others method for Validation a travel
     */
    protected function validationParceiro($dataParc, $rules)
    {
        $validate = $this->validate->make($dataParc, $rules);
        if($validate->fails()){
            $messages = $validate->messages();
            $displayErrors = '';

            foreach($messages->all("<p>:message</p>") as $error){
                $displayErrors .= $error;
            }

            return $displayErrors;
        }
    }

}
