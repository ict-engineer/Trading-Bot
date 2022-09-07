<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\kraken;
use App\Classes\bitfinex;
use App\Classes\binance;
use App\Classes\cex;
use App\Models\ccxt\Exchanges;
use App\Models\ccxt\Assets;
use App\Models\ccxt\AssetPairs;

class CryptoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getAsset($exchangeId, $base, $quote){
        $result = AssetPairs::where('exchange_id', $exchangeId)->where('name', 'like', '%'.$base.'%')->where('name', 'like', '%'.$quote.'%')->first();
        return $result->name;
    }

    public function getOrderBook(Request $request){
        $exchangeString = $request->exchange;
        $baseCurrency   = $request->baseCurrency;
        $quoteCurrency  = $request->quoteCurrency;
        $sellType       = $request->sellType;

        $exchange;
        $assetpair;
        $type;
        $exchangeSets   = explode(",", $exchangeString);
        $exchangeId     = $exchangeSets[0];
        $exchangeType   = $exchangeSets[1];

        switch($exchangeType){
        case 'kraken':
            $type = "Kraken";
            $exchange    = new kraken(array(
                'apiKey'=> 'Hu0JLuXsOwsI5m6RMIivcN4fbiFAwoZKHb2ZERCEszV2U4H0ZffpxBMo',
                'secret'=> '70rPORoXQriUBUmr6EGcAXW5/PA5fD3hluDtFU323fsW+jgwI3s5sdFlNHbbcLUGxjMwvM78ukCpYi/mWIIjfg==',
            ));
            break;
        case 'bitfinex':
            $type = "bitfinex";
            $exchange    = new bitfinex();
            break;
        case 'binance':
            $type = "binance";
            $exchange    = new binance();
            break;
        case 'cex':
            $type = "cex";
            $exchange    = new cex();
            break;
        default:
        }

        $assetpair              = $this->getAsset($exchangeId, $baseCurrency, $quoteCurrency);
        $result                 = array();
        $result['assetpair']    = $assetpair;
        $result['orderbook']    = array();
        $result['orderbook']    = $exchange->fetch_order_book($assetpair, 500);
        echo json_encode($result);
    }

    public function getTicker(Request $request){

        $exchangeString = $request->exchange;
        $baseCurrency   = $request->baseCurrency;
        $quoteCurrency  = $request->quoteCurrency;
        // $sellType       = $request->sellType;

        $exchange;
        $assetpair;
        $type;
        $exchangeSets   = explode(",", $exchangeString);
        $exchangeId     = $exchangeSets[0];
        $exchangeType   = $exchangeSets[1];

        switch($exchangeType){
        case 'kraken':
            $type = "Kraken";
            $exchange    = new kraken(array(
                'apiKey'=> 'Hu0JLuXsOwsI5m6RMIivcN4fbiFAwoZKHb2ZERCEszV2U4H0ZffpxBMo',
                'secret'=> '70rPORoXQriUBUmr6EGcAXW5/PA5fD3hluDtFU323fsW+jgwI3s5sdFlNHbbcLUGxjMwvM78ukCpYi/mWIIjfg==',
            ));
            break;
        case 'bitfinex':
            $type = "bitfinex";
            $exchange    = new bitfinex();
            break;
        case 'binance':
            $type = "binance";
            $exchange    = new binance();
            break;
        case 'cex':
            $type = "cex";
            $exchange    = new cex();
            break;
        default:
        }

        $assetpair   = $this->getAsset($exchangeId, $baseCurrency, $quoteCurrency);
        echo json_encode($exchange->fetch_ticker($assetpair));
    }

    public function getExchangeSets(){
        $exchangeSets   = Exchanges::get();

        $result         = array();
        $num            = 0;
        foreach($exchangeSets as $exchange){
            $result[$num] = array();
            $result[$num]['exchange_id']    = $exchange->id;
            $result[$num]['exchange_name']  = $exchange->name;
            $num++;
        }

        echo json_encode($result);
    }

    public function getBaseCurrency(Request $request){
        $exchange_id        = $request->exchange_id;

        $assets             = Assets::where('exchange_id', $exchange_id)->get();
        $baseCurrency       = array();
        $num                = 0;
        foreach($assets as $asset){
            $baseCurrency[$num]         = array();
            $baseCurrency[$num]['id']   = $asset->id;
            $baseCurrency[$num]['name'] = $asset->name;
            $num++;
        }

        echo json_encode($baseCurrency);
    }

    public function getQuoteCurrency(Request $request){
        $exchange_id        = $request->exchange_id;
        $baseCurrency       = $request->baseCurrency;

        $assetPairs         = AssetPairs::where('exchange_id', $exchange_id)->where('name', 'like', '%'.$baseCurrency.'%')->get();

        $results            = array();
        $num                = 0;
        foreach($assetPairs as $item){
            $pair           = $item->name;
            $pairItem       = explode('/', $pair);

            if($pairItem[0] != $baseCurrency){
                $results[$num] = $pairItem[0];
            }else{
                $results[$num] = $pairItem[1];
            }
            $num++;
        }

        echo json_encode($results);
    }

    public function get_web_page($url) {
        $options = array(
            CURLOPT_RETURNTRANSFER => true,   // return web page
            CURLOPT_HEADER         => false,  // don't return headers
            CURLOPT_FOLLOWLOCATION => true,   // follow redirects
            CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
            CURLOPT_ENCODING       => "",     // handle compressed
            CURLOPT_USERAGENT      => "test", // name of client
            CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
            CURLOPT_TIMEOUT        => 120,    // time-out on response
        );

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);

        $content  = curl_exec($ch);

        curl_close($ch);

        return $content;
    }


    public function getProfit(Request $req){
        $baseCurrency   = $req->baseCurrency;
        $quoteCurrency  = $req->quoteCurrency;
        $query          = $baseCurrency.'/'.$quoteCurrency.'?apikey=73F2CE4D-1220-4EA3-9D12-FFF01557C938';
        $url            = 'https://rest.coinapi.io/v1/exchangerate/'.$query;
        $response       = $this->get_web_page($url);

        echo ($response);

    }


}
