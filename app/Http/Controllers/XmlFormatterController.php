<?php

namespace App\Http\Controllers;

use App\Viagem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use SoapBox\Formatter\Formatter;
use League\Csv\Writer;
use XmlResponse\XmlResponseServiceProvider;

class XmlFormatterController extends Controller
{
    public function teste(Request $request)
    {

        $data = date('d/m/Y H:i:s',strtotime(Carbon::now()));
        $csv = Writer::createFromFileObject(new \SplTempFileObject());
//        $csv->output('viagens_'.$data.'.xml');
        $viagem = Viagem::query()
        ->join('parceiros', 'parceiros.id', '=', 'viagens.id_parceiro_viagem')
        ->join('origens_destinos as od', 'od.id', '=', 'viagens.id_cidade_origem')
        ->join('motoristas as m', 'm.id', '=', 'viagens.id_motorista')
        ->join('caminhoes as c', 'c.id', '=', 'viagens.id_caminhao')
        ->join('origens_destinos as od2', 'od2.id', '=', 'viagens.id_cidade_destino')
        ->leftJoin('fretes_viagens as fv','fv.id_viagem','=','viagens.id')
        ->leftJoin('fretes as f','f.id','=','fv.id_frete')
        ->groupBy('viagens.id')
        ->select("viagens.id", "parceiros.nome as parceiro", "m.nome as motorista", "c.modelo as caminhao", "viagens.status", "viagens.data_inicio", "od.cidade as cidade_origem", "od2.cidade as cidade_destino")
        ->selectRaw('count(fv.id) as fretes_viagens');

        $xml = response()->xml($viagem->get());
        return $xml;



//        return ;
//        $csv = Writer::createFromFileObject(new \SplTempFileObject());
//        $csv->output('viagens_'.Carbon::now().'.xml');
//        $viagem = Viagem::query()->select('id', 'id_motorista')->get();
//        $formatter = Formatter::make($viagem, Formatter::JSON);
//        return $formatter->toXml('id', 'id_motorista');
    }
}
