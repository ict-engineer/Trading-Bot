<?php

namespace App\Classes;
use App\Classes\Exchange;

use Exception as Exception; // a common import

class cex extends Exchange {

    public function describe () {
        return array_replace_recursive (parent::describe (), array (
            'id' => 'cex',
            'name' => 'CEX.IO',
            'countries' => array ( 'GB', 'EU', 'CY', 'RU' ),
            'rateLimit' => 1500,
            'has' => array (
                'CORS' => true,
                'fetchTickers' => true,
                'fetchOHLCV' => true,
                'fetchOrder' => true,
                'fetchOpenOrders' => true,
                'fetchClosedOrders' => true,
                'fetchDepositAddress' => true,
            ),
            'timeframes' => array (
                '1m' => '1m',
            ),
            'urls' => array (
                'logo' => 'https://user-images.githubusercontent.com/1294454/27766442-8ddc33b0-5ed8-11e7-8b98-f786aef0f3c9.jpg',
                'api' => 'https://cex.io/api',
                'www' => 'https://cex.io',
                'doc' => 'https://cex.io/cex-api',
                'fees' => array (
                    'https://cex.io/fee-schedule',
                    'https://cex.io/limits-commissions',
                ),
                'referral' => 'https://cex.io/r/0/up105393824/0/',
            ),
            'requiredCredentials' => array (
                'apiKey' => true,
                'secret' => true,
                'uid' => true,
            ),
            'api' => array (
                'public' => array (
                    'get' => array (
                        'currency_limits/',
                        'last_price/{pair}/',
                        'last_prices/{currencies}/',
                        'ohlcv/hd/{yyyymmdd}/{pair}',
                        'order_book/{pair}/',
                        'ticker/{pair}/',
                        'tickers/{currencies}/',
                        'trade_history/{pair}/',
                    ),
                    'post' => array (
                        'convert/{pair}',
                        'price_stats/{pair}',
                    ),
                ),
                'private' => array (
                    'post' => array (
                        'active_orders_status/',
                        'archived_orders/{pair}/',
                        'balance/',
                        'cancel_order/',
                        'cancel_orders/{pair}/',
                        'cancel_replace_order/{pair}/',
                        'close_position/{pair}/',
                        'get_address/',
                        'get_myfee/',
                        'get_order/',
                        'get_order_tx/',
                        'open_orders/{pair}/',
                        'open_orders/',
                        'open_position/{pair}/',
                        'open_positions/{pair}/',
                        'place_order/{pair}/',
                    ),
                ),
            ),
            'fees' => array (
                'trading' => array (
                    'maker' => 0.16 / 100,
                    'taker' => 0.25 / 100,
                ),
                'funding' => array (
                    'withdraw' => array (

                        'BTC' => 0.001,
                        'ETH' => 0.01,
                        'BCH' => 0.001,
                        'DASH' => 0.01,
                        'BTG' => 0.001,
                        'ZEC' => 0.001,
                        'XRP' => 0.02,
                    ),
                    'deposit' => array (

                        'BTC' => 0.0,
                        'ETH' => 0.0,
                        'BCH' => 0.0,
                        'DASH' => 0.0,
                        'BTG' => 0.0,
                        'ZEC' => 0.0,
                        'XRP' => 0.0,
                        'XLM' => 0.0,
                    ),
                ),
            ),
            'options' => array (
                'fetchOHLCVWarning' => true,
                'createMarketBuyOrderRequiresPrice' => true,
            ),
        ));
    }

    public function fetch_markets ($params = array ()) {
        $markets = $this->publicGetCurrencyLimits ();
        $result = array ();
        for ($p = 0; $p < count ($markets['data']['pairs']); $p++) {
            $market = $markets['data']['pairs'][$p];
            $id = $market['symbol1'] . '/' . $market['symbol2'];
            $symbol = $id;
            list ($base, $quote) = explode ('/', $symbol);
            $result[] = array (
                'id' => $id,
                'info' => $market,
                'symbol' => $symbol,
                'base' => $base,
                'quote' => $quote,
                'precision' => array (
                    'price' => $this->precision_from_string($this->safe_string($market, 'minPrice')),
                    'amount' => $this->precision_from_string($this->safe_string($market, 'minLotSize')),
                ),
                'limits' => array (
                    'amount' => array (
                        'min' => $market['minLotSize'],
                        'max' => $market['maxLotSize'],
                    ),
                    'price' => array (
                        'min' => $this->safe_float($market, 'minPrice'),
                        'max' => $this->safe_float($market, 'maxPrice'),
                    ),
                    'cost' => array (
                        'min' => $market['minLotSizeS2'],
                        'max' => null,
                    ),
                ),
            );
        }
        return $result;
    }

    public function fetch_balance ($params = array ()) {
        $this->load_markets();
        $response = $this->privatePostBalance ();
        $result = array ( 'info' => $response );
        $ommited = array ( 'username', 'timestamp' );
        $balances = $this->omit ($response, $ommited);
        $currencies = is_array ($balances) ? array_keys ($balances) : array ();
        for ($i = 0; $i < count ($currencies); $i++) {
            $currency = $currencies[$i];
            if (is_array ($balances) && array_key_exists ($currency, $balances)) {
                $account = array (
                    'free' => $this->safe_float($balances[$currency], 'available', 0.0),
                    'used' => $this->safe_float($balances[$currency], 'orders', 0.0),
                    'total' => 0.0,
                );
                $account['total'] = $this->sum ($account['free'], $account['used']);
                $result[$currency] = $account;
            }
        }
        return $this->parse_balance($result);
    }

    public function fetch_order_book ($symbol, $limit = null, $params = array ()) {
        $this->load_markets();
        $request = array (
            'pair' => $this->market_id($symbol),
        );
        if ($limit !== null) {
            $request['depth'] = $limit;
        }
        $orderbook = $this->publicGetOrderBookPair (array_merge ($request, $params));
        $timestamp = $orderbook['timestamp'] * 1000;
        return $this->parse_order_book($orderbook, $timestamp);
    }

    public function parse_ohlcv ($ohlcv, $market = null, $timeframe = '1m', $since = null, $limit = null) {
        return [
            $ohlcv[0] * 1000,
            $ohlcv[1],
            $ohlcv[2],
            $ohlcv[3],
            $ohlcv[4],
            $ohlcv[5],
        ];
    }

    public function fetch_ohlcv ($symbol, $timeframe = '1m', $since = null, $limit = null, $params = array ()) {
        $this->load_markets();
        $market = $this->market ($symbol);
        if ($since === null) {
            $since = $this->milliseconds () - 86400000; // yesterday
        } else {
            if ($this->options['fetchOHLCVWarning']) {
                throw new ExchangeError ($this->id . " fetchOHLCV warning => CEX can return historical candles for a certain date only, this might produce an empty or null reply. Set exchange.options['fetchOHLCVWarning'] = false or add (array ( 'options' => array ( 'fetchOHLCVWarning' => false ))) to constructor $params to suppress this warning message.");
            }
        }
        $ymd = $this->ymd ($since);
        $ymd = explode ('-', $ymd);
        $ymd = implode ('', $ymd);
        $request = array (
            'pair' => $market['id'],
            'yyyymmdd' => $ymd,
        );
        try {
            $response = $this->publicGetOhlcvHdYyyymmddPair (array_merge ($request, $params));
            $key = 'data' . $this->timeframes[$timeframe];
            $ohlcvs = json_decode ($response[$key], $as_associative_array = true);
            return $this->parse_ohlcvs($ohlcvs, $market, $timeframe, $since, $limit);
        } catch (Exception $e) {
            if ($e instanceof NullResponse) {
                return array ();
            }
        }
    }

    public function parse_ticker ($ticker, $market = null) {
        $timestamp = null;
        if (is_array ($ticker) && array_key_exists ('timestamp', $ticker)) {
            $timestamp = intval ($ticker['timestamp']) * 1000;
        }
        $volume = $this->safe_float($ticker, 'volume');
        $high = $this->safe_float($ticker, 'high');
        $low = $this->safe_float($ticker, 'low');
        $bid = $this->safe_float($ticker, 'bid');
        $ask = $this->safe_float($ticker, 'ask');
        $last = $this->safe_float($ticker, 'last');
        $symbol = null;
        if ($market)
            $symbol = $market['symbol'];
        return array (
            'symbol' => $symbol,
            'timestamp' => $timestamp,
            'datetime' => $this->iso8601 ($timestamp),
            'high' => $high,
            'low' => $low,
            'bid' => $bid,
            'bidVolume' => null,
            'ask' => $ask,
            'askVolume' => null,
            'vwap' => null,
            'open' => null,
            'close' => $last,
            'last' => $last,
            'previousClose' => null,
            'change' => null,
            'percentage' => null,
            'average' => null,
            'baseVolume' => $volume,
            'quoteVolume' => null,
            'info' => $ticker,
        );
    }

    public function fetch_tickers ($symbols = null, $params = array ()) {
        $this->load_markets();
        $currencies = is_array ($this->currencies) ? array_keys ($this->currencies) : array ();
        $response = $this->publicGetTickersCurrencies (array_merge (array (
            'currencies' => implode ('/', $currencies),
        ), $params));
        $tickers = $response['data'];
        $result = array ();
        for ($t = 0; $t < count ($tickers); $t++) {
            $ticker = $tickers[$t];
            $symbol = str_replace (':', '/', $ticker['pair']);
            $market = $this->markets[$symbol];
            $result[$symbol] = $this->parse_ticker($ticker, $market);
        }
        return $result;
    }

    public function fetch_ticker ($symbol, $params = array ()) {
        $this->load_markets();
        $market = $this->market ($symbol);
        $ticker = $this->publicGetTickerPair (array_merge (array (
            'pair' => $market['id'],
        ), $params));
        return $this->parse_ticker($ticker, $market);
    }

    public function parse_trade ($trade, $market = null) {
        $timestamp = intval ($trade['date']) * 1000;
        return array (
            'info' => $trade,
            'id' => $trade['tid'],
            'timestamp' => $timestamp,
            'datetime' => $this->iso8601 ($timestamp),
            'symbol' => $market['symbol'],
            'type' => null,
            'side' => $trade['type'],
            'price' => $this->safe_float($trade, 'price'),
            'amount' => $this->safe_float($trade, 'amount'),
        );
    }

    public function fetch_trades ($symbol, $since = null, $limit = null, $params = array ()) {
        $this->load_markets();
        $market = $this->market ($symbol);
        $response = $this->publicGetTradeHistoryPair (array_merge (array (
            'pair' => $market['id'],
        ), $params));
        return $this->parse_trades($response, $market, $since, $limit);
    }

    public function create_order ($symbol, $type, $side, $amount, $price = null, $params = array ()) {
        if ($type === 'market') {
            if ($side === 'buy') {
                if ($this->options['createMarketBuyOrderRequiresPrice']) {
                    if ($price === null) {
                        throw new InvalidOrder ($this->id . " createOrder() requires the $price argument with market buy orders to calculate total order cost ($amount to spend), where cost = $amount * $price-> Supply a $price argument to createOrder() call if you want the cost to be calculated for you from $price and $amount, or, alternatively, add .options['createMarketBuyOrderRequiresPrice'] = false to supply the cost in the $amount argument (the exchange-specific behaviour)");
                    } else {
                        $amount = $amount * $price;
                    }
                }
            }
        }
        $this->load_markets();
        $request = array (
            'pair' => $this->market_id($symbol),
            'type' => $side,
            'amount' => $amount,
        );
        if ($type === 'limit') {
            $request['price'] = $price;
        } else {
            $request['order_type'] = $type;
        }
        $response = $this->privatePostPlaceOrderPair (array_merge ($request, $params));
        return array (
            'info' => $response,
            'id' => $response['id'],
        );
    }

    public function cancel_order ($id, $symbol = null, $params = array ()) {
        $this->load_markets();
        return $this->privatePostCancelOrder (array ( 'id' => $id ));
    }

    public function parse_order ($order, $market = null) {

        $timestamp = $order['time'];
        if (gettype ($order['time']) === 'string' && mb_strpos ($order['time'], 'T') !== false) {
            $timestamp = $this->parse8601 ($timestamp);
        } else {
            $timestamp = intval ($timestamp);
        }
        $symbol = null;
        if ($market === null) {
            $symbol = $order['symbol1'] . '/' . $order['symbol2'];
            if (is_array ($this->markets) && array_key_exists ($symbol, $this->markets))
                $market = $this->market ($symbol);
        }
        $status = $order['status'];
        if ($status === 'a') {
            $status = 'open'; // the unified $status
        } else if ($status === 'cd') {
            $status = 'canceled';
        } else if ($status === 'c') {
            $status = 'canceled';
        } else if ($status === 'd') {
            $status = 'closed';
        }
        $price = $this->safe_float($order, 'price');
        $amount = $this->safe_float($order, 'amount');
        $remaining = $this->safe_float($order, 'pending');
        if (!$remaining)
            $remaining = $this->safe_float($order, 'remains');
        $filled = $amount - $remaining;
        $fee = null;
        $cost = null;
        if ($market !== null) {
            $symbol = $market['symbol'];
            $cost = $this->safe_float($order, 'ta:' . $market['quote']);
            if ($cost === null)
                $cost = $this->safe_float($order, 'tta:' . $market['quote']);
            $baseFee = 'fa:' . $market['base'];
            $baseTakerFee = 'tfa:' . $market['base'];
            $quoteFee = 'fa:' . $market['quote'];
            $quoteTakerFee = 'tfa:' . $market['quote'];
            $feeRate = $this->safe_float($order, 'tradingFeeMaker');
            if (!$feeRate)
                $feeRate = $this->safe_float($order, 'tradingFeeTaker', $feeRate);
            if ($feeRate)
                $feeRate /= 100.0;
            if ((is_array ($order) && array_key_exists ($baseFee, $order)) || (is_array ($order) && array_key_exists ($baseTakerFee, $order))) {
                $baseFeeCost = $this->safe_float($order, $baseFee);
                if ($baseFeeCost === null)
                    $baseFeeCost = $this->safe_float($order, $baseTakerFee);
                $fee = array (
                    'currency' => $market['base'],
                    'rate' => $feeRate,
                    'cost' => $baseFeeCost,
                );
            } else if ((is_array ($order) && array_key_exists ($quoteFee, $order)) || (is_array ($order) && array_key_exists ($quoteTakerFee, $order))) {
                $quoteFeeCost = $this->safe_float($order, $quoteFee);
                if ($quoteFeeCost === null)
                    $quoteFeeCost = $this->safe_float($order, $quoteTakerFee);
                $fee = array (
                    'currency' => $market['quote'],
                    'rate' => $feeRate,
                    'cost' => $quoteFeeCost,
                );
            }
        }
        if (!$cost)
            $cost = $price * $filled;
        return array (
            'id' => $order['id'],
            'datetime' => $this->iso8601 ($timestamp),
            'timestamp' => $timestamp,
            'lastTradeTimestamp' => null,
            'status' => $status,
            'symbol' => $symbol,
            'type' => null,
            'side' => $order['type'],
            'price' => $price,
            'cost' => $cost,
            'amount' => $amount,
            'filled' => $filled,
            'remaining' => $remaining,
            'trades' => null,
            'fee' => $fee,
            'info' => $order,
        );
    }

    public function fetch_open_orders ($symbol = null, $since = null, $limit = null, $params = array ()) {
        $this->load_markets();
        $request = array ();
        $method = 'privatePostOpenOrders';
        $market = null;
        if ($symbol !== null) {
            $market = $this->market ($symbol);
            $request['pair'] = $market['id'];
            $method .= 'Pair';
        }
        $orders = $this->$method (array_merge ($request, $params));
        for ($i = 0; $i < count ($orders); $i++) {
            $orders[$i] = array_merge ($orders[$i], array ( 'status' => 'open' ));
        }
        return $this->parse_orders($orders, $market, $since, $limit);
    }

    public function fetch_closed_orders ($symbol = null, $since = null, $limit = null, $params = array ()) {
        $this->load_markets();
        $method = 'privatePostArchivedOrdersPair';
        if ($symbol === null) {
            throw new ArgumentsRequired ($this->id . ' fetchClosedOrders requires a $symbol argument');
        }
        $market = $this->market ($symbol);
        $request = array ( 'pair' => $market['id'] );
        $response = $this->$method (array_merge ($request, $params));
        return $this->parse_orders($response, $market, $since, $limit);
    }

    public function fetch_order ($id, $symbol = null, $params = array ()) {
        $this->load_markets();
        $response = $this->privatePostGetOrder (array_merge (array (
            'id' => (string) $id,
        ), $params));
        return $this->parse_order($response);
    }

    public function nonce () {
        return $this->milliseconds ();
    }

    public function sign ($path, $api = 'public', $method = 'GET', $params = array (), $headers = null, $body = null) {
        $url = $this->urls['api'] . '/' . $this->implode_params($path, $params);
        $query = $this->omit ($params, $this->extract_params($path));
        if ($api === 'public') {
            if ($query)
                $url .= '?' . $this->urlencode ($query);
        } else {
            $this->check_required_credentials();
            $nonce = (string) $this->nonce ();
            $auth = $nonce . $this->uid . $this->apiKey;
            $signature = $this->hmac ($this->encode ($auth), $this->encode ($this->secret));
            $body = $this->urlencode (array_merge (array (
                'key' => $this->apiKey,
                'signature' => strtoupper ($signature),
                'nonce' => $nonce,
            ), $query));
            $headers = array (
                'Content-Type' => 'application/x-www-form-urlencoded',
            );
        }
        return array ( 'url' => $url, 'method' => $method, 'body' => $body, 'headers' => $headers );
    }

    public function request ($path, $api = 'public', $method = 'GET', $params = array (), $headers = null, $body = null) {
        $response = $this->fetch2 ($path, $api, $method, $params, $headers, $body);
        if (!$response) {
            throw new NullResponse ($this->id . ' returned ' . $this->json ($response));
        } else if ($response === true) {
            return $response;
        } else if (is_array ($response) && array_key_exists ('e', $response)) {
            if (is_array ($response) && array_key_exists ('ok', $response))
                if ($response['ok'] === 'ok')
                    return $response;
            throw new ExchangeError ($this->id . ' ' . $this->json ($response));
        } else if (is_array ($response) && array_key_exists ('error', $response)) {
            if ($response['error'])
                throw new ExchangeError ($this->id . ' ' . $this->json ($response));
        }
        return $response;
    }

    public function fetch_deposit_address ($code, $params = array ()) {
        if ($code === 'XRP' || $code === 'XLM') {

            throw new NotSupported ($this->id . ' fetchDepositAddress does not support XRP and XLM addresses yet (awaiting docs from CEX.io)');
        }
        $this->load_markets();
        $currency = $this->currency ($code);
        $request = array (
            'currency' => $currency['id'],
        );
        $response = $this->privatePostGetAddress (array_merge ($request, $params));
        $address = $this->safe_string($response, 'data');
        $this->check_address($address);
        return array (
            'currency' => $code,
            'address' => $address,
            'tag' => null,
            'info' => $response,
        );
    }
}
