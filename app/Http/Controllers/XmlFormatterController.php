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

        $csv = Writer::createFromFileObject(new \SplTempFileObject());
        $csv->output('viagens_'.Carbon::now().'.xml');
        $xml = response()->xml(Viagem::all());
        return $xml;

//        return ;
//        $csv = Writer::createFromFileObject(new \SplTempFileObject());
//        $csv->output('viagens_'.Carbon::now().'.xml');
//        $viagem = Viagem::query()->select('id', 'id_motorista')->get();
//        $formatter = Formatter::make($viagem, Formatter::JSON);
//        return $formatter->toXml('id', 'id_motorista');
    }
}
