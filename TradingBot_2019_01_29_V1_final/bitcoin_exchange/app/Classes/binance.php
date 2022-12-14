<?php

namespace App\Classes;
use App\Classes\Exchange;


use Exception as Exception; // a common import

class binance extends Exchange {

    public function describe () {
        return array_replace_recursive (parent::describe (), array (
            'id' => 'binance',
            'name' => 'Binance',
            'countries' => array ( 'JP' ), // Japan
            'rateLimit' => 500,
            'certified' => true,
            // new metainfo interface
            'has' => array (
                'fetchDepositAddress' => true,
                'CORS' => false,
                'fetchBidsAsks' => true,
                'fetchTickers' => true,
                'fetchOHLCV' => true,
                'fetchMyTrades' => true,
                'fetchOrder' => true,
                'fetchOrders' => true,
                'fetchOpenOrders' => true,
                'fetchClosedOrders' => true,
                'withdraw' => true,
                'fetchFundingFees' => true,
                'fetchDeposits' => true,
                'fetchWithdrawals' => true,
                'fetchTransactions' => false,
            ),
            'timeframes' => array (
                '1m' => '1m',
                '3m' => '3m',
                '5m' => '5m',
                '15m' => '15m',
                '30m' => '30m',
                '1h' => '1h',
                '2h' => '2h',
                '4h' => '4h',
                '6h' => '6h',
                '8h' => '8h',
                '12h' => '12h',
                '1d' => '1d',
                '3d' => '3d',
                '1w' => '1w',
                '1M' => '1M',
            ),
            'urls' => array (
                'logo' => 'https://user-images.githubusercontent.com/1294454/29604020-d5483cdc-87ee-11e7-94c7-d1a8d9169293.jpg',
                'api' => array (
                    'web' => 'https://www.binance.com',
                    'wapi' => 'https://api.binance.com/wapi/v3',
                    'public' => 'https://api.binance.com/api/v1',
                    'private' => 'https://api.binance.com/api/v3',
                    'v3' => 'https://api.binance.com/api/v3',
                    'v1' => 'https://api.binance.com/api/v1',
                ),
                'www' => 'https://www.binance.com',
                'referral' => 'https://www.binance.com/?ref=10205187',
                'doc' => 'https://github.com/binance-exchange/binance-official-api-docs/blob/master/rest-api.md',
                'fees' => 'https://www.binance.com/en/fee/schedule',
            ),
            'api' => array (
                'web' => array (
                    'get' => array (
                        'exchange/public/product',
                        'assetWithdraw/getAllAsset.html',
                    ),
                ),
                'wapi' => array (
                    'post' => array (
                        'withdraw',
                    ),
                    'get' => array (
                        'depositHistory',
                        'withdrawHistory',
                        'depositAddress',
                        'accountStatus',
                        'systemStatus',
                        'userAssetDribbletLog',
                        'tradeFee',
                        'assetDetail',
                    ),
                ),
                'v3' => array (
                    'get' => array (
                        'ticker/price',
                        'ticker/bookTicker',
                    ),
                ),
                'public' => array (
                    'get' => array (
                        'ping',
                        'time',
                        'depth',
                        'aggTrades',
                        'klines',
                        'ticker/24hr',
                        'ticker/allPrices',
                        'ticker/allBookTickers',
                        'ticker/price',
                        'ticker/bookTicker',
                        'exchangeInfo',
                    ),
                    'put' => array ( 'userDataStream' ),
                    'post' => array ( 'userDataStream' ),
                    'delete' => array ( 'userDataStream' ),
                ),
                'private' => array (
                    'get' => array (
                        'order',
                        'openOrders',
                        'allOrders',
                        'account',
                        'myTrades',
                    ),
                    'post' => array (
                        'order',
                        'order/test',
                    ),
                    'delete' => array (
                        'order',
                    ),
                ),
            ),
            'fees' => array (
                'trading' => array (
                    'tierBased' => false,
                    'percentage' => true,
                    'taker' => 0.001,
                    'maker' => 0.001,
                ),

                'funding' => array (
                    'tierBased' => false,
                    'percentage' => false,
                    'withdraw' => array (
                        'ADA' => 1.0,
                        'ADX' => 4.7,
                        'AION' => 1.9,
                        'AMB' => 11.4,
                        'APPC' => 6.5,
                        'ARK' => 0.1,
                        'ARN' => 3.1,
                        'AST' => 10.0,
                        'BAT' => 18.0,
                        'BCD' => 1.0,
                        'BCH' => 0.001,
                        'BCPT' => 10.2,
                        'BCX' => 1.0,
                        'BNB' => 0.7,
                        'BNT' => 1.5,
                        'BQX' => 1.6,
                        'BRD' => 6.4,
                        'BTC' => 0.001,
                        'BTG' => 0.001,
                        'BTM' => 5.0,
                        'BTS' => 1.0,
                        'CDT' => 67.0,
                        'CMT' => 37.0,
                        'CND' => 47.0,
                        'CTR' => 5.4,
                        'DASH' => 0.002,
                        'DGD' => 0.06,
                        'DLT' => 11.7,
                        'DNT' => 51.0,
                        'EDO' => 2.5,
                        'ELF' => 6.5,
                        'ENG' => 2.1,
                        'ENJ' => 42.0,
                        'EOS' => 1.0,
                        'ETC' => 0.01,
                        'ETF' => 1.0,
                        'ETH' => 0.01,
                        'EVX' => 2.5,
                        'FUEL' => 45.0,
                        'FUN' => 85.0,
                        'GAS' => 0,
                        'GTO' => 20.0,
                        'GVT' => 0.53,
                        'GXS' => 0.3,
                        'HCC' => 0.0005,
                        'HSR' => 0.0001,
                        'ICN' => 3.5,
                        'ICX' => 1.3,
                        'INS' => 1.5,
                        'IOTA' => 0.5,
                        'KMD' => 0.002,
                        'KNC' => 2.6,
                        'LEND' => 54.0,
                        'LINK' => 12.8,
                        'LLT' => 54.0,
                        'LRC' => 9.1,
                        'LSK' => 0.1,
                        'LTC' => 0.01,
                        'LUN' => 0.29,
                        'MANA' => 74.0,
                        'MCO' => 0.86,
                        'MDA' => 4.7,
                        'MOD' => 2.0,
                        'MTH' => 34.0,
                        'MTL' => 1.9,
                        'NAV' => 0.2,
                        'NEBL' => 0.01,
                        'NEO' => 0.0,
                        'NULS' => 2.1,
                        'OAX' => 8.3,
                        'OMG' => 0.57,
                        'OST' => 17.0,
                        'POE' => 88.0,
                        'POWR' => 8.6,
                        'PPT' => 0.25,
                        'QSP' => 21.0,
                        'QTUM' => 0.01,
                        'RCN' => 35.0,
                        'RDN' => 2.2,
                        'REQ' => 18.1,
                        'RLC' => 4.1,
                        'SALT' => 1.3,
                        'SBTC' => 1.0,
                        'SNGLS' => 42,
                        'SNM' => 29.0,
                        'SNT' => 32.0,
                        'STORJ' => 5.9,
                        'STRAT' => 0.1,
                        'SUB' => 7.4,
                        'TNB' => 82.0,
                        'TNT' => 47.0,
                        'TRIG' => 6.7,
                        'TRX' => 129.0,
                        'USDT' => 23.0,
                        'VEN' => 1.8,
                        'VIB' => 28.0,
                        'VIBE' => 7.2,
                        'WABI' => 3.5,
                        'WAVES' => 0.002,
                        'WINGS' => 9.3,
                        'WTC' => 0.5,
                        'XLM' => 0.01,
                        'XMR' => 0.04,
                        'XRP' => 0.25,
                        'XVG' => 0.1,
                        'XZC' => 0.02,
                        'YOYOW' => 39.0,
                        'ZEC' => 0.005,
                        'ZRX' => 5.7,
                    ),
                    'deposit' => array (),
                ),
            ),
            'commonCurrencies' => array (
                'YOYO' => 'YOYOW',
                'BCC' => 'BCH',
            ),
            // exchange-specific options
            'options' => array (
                'fetchTickersMethod' => 'publicGetTicker24hr',
                'defaultTimeInForce' => 'GTC',
                'defaultLimitOrderType' => 'limit', // or 'limit_maker'
                'hasAlreadyAuthenticatedSuccessfully' => false,
                'warnOnFetchOpenOrdersWithoutSymbol' => true,
                'recvWindow' => 5 * 1000, // 5 sec, binance default
                'timeDifference' => 0, // the difference between system clock and Binance clock
                'adjustForTimeDifference' => false, // controls the adjustment logic upon instantiation
                'parseOrderToPrecision' => false, // force amounts and costs in parseOrder to precision
                'newOrderRespType' => array (
                    'market' => 'FULL', // 'ACK' for order id, 'RESULT' for full order or 'FULL' for order with fills
                    'limit' => 'RESULT', // we change it from 'ACK' by default to 'RESULT'
                ),
            ),
            'exceptions' => array (
                '-1000' => '\\ccxt\\ExchangeNotAvailable',
                '-1013' => '\\ccxt\\InvalidOrder',
                '-1021' => '\\ccxt\\InvalidNonce',
                '-1022' => '\\ccxt\\AuthenticationError',
                '-1100' => '\\ccxt\\InvalidOrder',
                '-1104' => '\\ccxt\\ExchangeError',
                '-1128' => '\\ccxt\\ExchangeError',
                '-2010' => '\\ccxt\\ExchangeError',
                '-2011' => '\\ccxt\\OrderNotFound',
                '-2013' => '\\ccxt\\OrderNotFound',
                '-2014' => '\\ccxt\\AuthenticationError',
                '-2015' => '\\ccxt\\AuthenticationError',
            ),
        ));
    }

    public function nonce () {
        return $this->milliseconds () - $this->options['timeDifference'];
    }

    public function load_time_difference () {
        $response = $this->publicGetTime ();
        $after = $this->milliseconds ();
        $this->options['timeDifference'] = intval ($after - $response['serverTime']);
        return $this->options['timeDifference'];
    }

    public function fetch_markets ($params = array ()) {
        $response = $this->publicGetExchangeInfo ();
        if ($this->options['adjustForTimeDifference'])
            $this->load_time_difference ();
        $markets = $response['symbols'];
        $result = array ();
        for ($i = 0; $i < count ($markets); $i++) {
            $market = $markets[$i];
            $id = $market['symbol'];
            // "123456" is a "test $symbol/$market"
            if ($id === '123456')
                continue;
            $baseId = $market['baseAsset'];
            $quoteId = $market['quoteAsset'];
            $base = $this->common_currency_code($baseId);
            $quote = $this->common_currency_code($quoteId);
            $symbol = $base . '/' . $quote;
            $filters = $this->index_by($market['filters'], 'filterType');
            $precision = array (
                'base' => $market['baseAssetPrecision'],
                'quote' => $market['quotePrecision'],
                'amount' => $market['baseAssetPrecision'],
                'price' => $market['quotePrecision'],
            );
            $active = ($market['status'] === 'TRADING');
            $entry = array (
                'id' => $id,
                'symbol' => $symbol,
                'base' => $base,
                'quote' => $quote,
                'baseId' => $baseId,
                'quoteId' => $quoteId,
                'info' => $market,
                'active' => $active,
                'precision' => $precision,
                'limits' => array (
                    'amount' => array (
                        'min' => pow (10, -$precision['amount']),
                        'max' => null,
                    ),
                    'price' => array (
                        'min' => null,
                        'max' => null,
                    ),
                    'cost' => array (
                        'min' => -1 * log10 ($precision['amount']),
                        'max' => null,
                    ),
                ),
            );
            if (is_array ($filters) && array_key_exists ('PRICE_FILTER', $filters)) {
                $filter = $filters['PRICE_FILTER'];

                $entry['precision']['price'] = $this->precision_from_string($filter['tickSize']);
            }
            if (is_array ($filters) && array_key_exists ('LOT_SIZE', $filters)) {
                $filter = $filters['LOT_SIZE'];
                $entry['precision']['amount'] = $this->precision_from_string($filter['stepSize']);
                $entry['limits']['amount'] = array (
                    'min' => $this->safe_float($filter, 'minQty'),
                    'max' => $this->safe_float($filter, 'maxQty'),
                );
            }
            if (is_array ($filters) && array_key_exists ('MIN_NOTIONAL', $filters)) {
                $entry['limits']['cost']['min'] = floatval ($filters['MIN_NOTIONAL']['minNotional']);
            }
            $result[] = $entry;
        }
        return $result;
    }

    public function calculate_fee ($symbol, $type, $side, $amount, $price, $takerOrMaker = 'taker', $params = array ()) {
        $market = $this->markets[$symbol];
        $key = 'quote';
        $rate = $market[$takerOrMaker];
        $cost = $amount * $rate;
        $precision = $market['precision']['price'];
        if ($side === 'sell') {
            $cost *= $price;
        } else {
            $key = 'base';
            $precision = $market['precision']['amount'];
        }
        $cost = $this->decimal_to_precision($cost, ROUND, $precision, $this->precisionMode);
        return array (
            'type' => $takerOrMaker,
            'currency' => $market[$key],
            'rate' => $rate,
            'cost' => floatval ($cost),
        );
    }

    public function fetch_balance ($params = array ()) {
        $this->load_markets();
        $response = $this->privateGetAccount ($params);
        $result = array ( 'info' => $response );
        $balances = $response['balances'];
        for ($i = 0; $i < count ($balances); $i++) {
            $balance = $balances[$i];
            $currency = $balance['asset'];
            if (is_array ($this->currencies_by_id) && array_key_exists ($currency, $this->currencies_by_id))
                $currency = $this->currencies_by_id[$currency]['code'];
            $account = array (
                'free' => floatval ($balance['free']),
                'used' => floatval ($balance['locked']),
                'total' => 0.0,
            );
            $account['total'] = $this->sum ($account['free'], $account['used']);
            $result[$currency] = $account;
        }
        return $this->parse_balance($result);
    }

    public function fetch_order_book ($symbol, $limit = null, $params = array ()) {
        $this->load_markets();
        $market = $this->market ($symbol);
        $request = array (
            'symbol' => $market['id'],
        );
        if ($limit !== null)
            $request['limit'] = $limit; // default = maximum = 100
        $response = $this->publicGetDepth (array_merge ($request, $params));
        $orderbook = $this->parse_order_book($response);
        $orderbook['nonce'] = $this->safe_integer($response, 'lastUpdateId');
        return $orderbook;
    }

    public function parse_ticker ($ticker, $market = null) {
        $timestamp = $this->safe_integer($ticker, 'closeTime');
        $symbol = $this->find_symbol($this->safe_string($ticker, 'symbol'), $market);
        $last = $this->safe_float($ticker, 'lastPrice');
        return array (
            'symbol' => $symbol,
            'timestamp' => $timestamp,
            'datetime' => $this->iso8601 ($timestamp),
            'high' => $this->safe_float($ticker, 'highPrice'),
            'low' => $this->safe_float($ticker, 'lowPrice'),
            'bid' => $this->safe_float($ticker, 'bidPrice'),
            'bidVolume' => $this->safe_float($ticker, 'bidQty'),
            'ask' => $this->safe_float($ticker, 'askPrice'),
            'askVolume' => $this->safe_float($ticker, 'askQty'),
            'vwap' => $this->safe_float($ticker, 'weightedAvgPrice'),
            'open' => $this->safe_float($ticker, 'openPrice'),
            'close' => $last,
            'last' => $last,
            'previousClose' => $this->safe_float($ticker, 'prevClosePrice'), // previous day close
            'change' => $this->safe_float($ticker, 'priceChange'),
            'percentage' => $this->safe_float($ticker, 'priceChangePercent'),
            'average' => null,
            'baseVolume' => $this->safe_float($ticker, 'volume'),
            'quoteVolume' => $this->safe_float($ticker, 'quoteVolume'),
            'info' => $ticker,
        );
    }

    public function fetch_ticker ($symbol, $params = array ()) {
        $this->load_markets();
        $market = $this->market ($symbol);
        $response = $this->publicGetTicker24hr (array_merge (array (
            'symbol' => $market['id'],
        ), $params));
        return $this->parse_ticker($response, $market);
    }

    public function parse_tickers ($rawTickers, $symbols = null) {
        $tickers = array ();
        for ($i = 0; $i < count ($rawTickers); $i++) {
            $tickers[] = $this->parse_ticker($rawTickers[$i]);
        }
        return $this->filter_by_array($tickers, 'symbol', $symbols);
    }

    public function fetch_bids_asks ($symbols = null, $params = array ()) {
        $this->load_markets();
        $rawTickers = $this->publicGetTickerBookTicker ($params);
        return $this->parse_tickers ($rawTickers, $symbols);
    }

    public function fetch_tickers ($symbols = null, $params = array ()) {
        $this->load_markets();
        $method = $this->options['fetchTickersMethod'];
        $rawTickers = $this->$method ($params);
        return $this->parse_tickers ($rawTickers, $symbols);
    }

    public function parse_ohlcv ($ohlcv, $market = null, $timeframe = '1m', $since = null, $limit = null) {
        return [
            $ohlcv[0],
            floatval ($ohlcv[1]),
            floatval ($ohlcv[2]),
            floatval ($ohlcv[3]),
            floatval ($ohlcv[4]),
            floatval ($ohlcv[5]),
        ];
    }

    public function fetch_ohlcv ($symbol, $timeframe = '1m', $since = null, $limit = null, $params = array ()) {
        $this->load_markets();
        $market = $this->market ($symbol);
        $request = array (
            'symbol' => $market['id'],
            'interval' => $this->timeframes[$timeframe],
        );
        if ($since !== null) {
            $request['startTime'] = $since;
        }
        if ($limit !== null) {
            $request['limit'] = $limit; // default == max == 500
        }
        $response = $this->publicGetKlines (array_merge ($request, $params));
        return $this->parse_ohlcvs($response, $market, $timeframe, $since, $limit);
    }

    public function parse_trade ($trade, $market = null) {
        $timestampField = (is_array ($trade) && array_key_exists ('T', $trade)) ? 'T' : 'time';
        $timestamp = $this->safe_integer($trade, $timestampField);
        $priceField = (is_array ($trade) && array_key_exists ('p', $trade)) ? 'p' : 'price';
        $price = $this->safe_float($trade, $priceField);
        $amountField = (is_array ($trade) && array_key_exists ('q', $trade)) ? 'q' : 'qty';
        $amount = $this->safe_float($trade, $amountField);
        $idField = (is_array ($trade) && array_key_exists ('a', $trade)) ? 'a' : 'id';
        $id = $this->safe_string($trade, $idField);
        $side = null;
        $order = null;
        if (is_array ($trade) && array_key_exists ('orderId', $trade))
            $order = $this->safe_string($trade, 'orderId');
        if (is_array ($trade) && array_key_exists ('m', $trade)) {
            $side = $trade['m'] ? 'sell' : 'buy'; // this is reversed intentionally
        } else {
            if (is_array ($trade) && array_key_exists ('isBuyer', $trade))
                $side = ($trade['isBuyer']) ? 'buy' : 'sell'; // this is a true $side
        }
        $fee = null;
        if (is_array ($trade) && array_key_exists ('commission', $trade)) {
            $fee = array (
                'cost' => $this->safe_float($trade, 'commission'),
                'currency' => $this->common_currency_code($trade['commissionAsset']),
            );
        }
        $takerOrMaker = null;
        if (is_array ($trade) && array_key_exists ('isMaker', $trade))
            $takerOrMaker = $trade['isMaker'] ? 'maker' : 'taker';
        $symbol = null;
        if ($market === null) {
            $marketId = $this->safe_string($trade, 'symbol');
            $market = $this->safe_value($this->markets_by_id, $marketId);
        }
        if ($market !== null) {
            $symbol = $market['symbol'];
        }
        return array (
            'info' => $trade,
            'timestamp' => $timestamp,
            'datetime' => $this->iso8601 ($timestamp),
            'symbol' => $symbol,
            'id' => $id,
            'order' => $order,
            'type' => null,
            'takerOrMaker' => $takerOrMaker,
            'side' => $side,
            'price' => $price,
            'cost' => $price * $amount,
            'amount' => $amount,
            'fee' => $fee,
        );
    }

    public function fetch_trades ($symbol, $since = null, $limit = null, $params = array ()) {
        $this->load_markets();
        $market = $this->market ($symbol);
        $request = array (
            'symbol' => $market['id'],
        );
        if ($since !== null) {
            $request['startTime'] = $since;
            $request['endTime'] = $this->sum ($since, 3600000);
        }
        if ($limit !== null)
            $request['limit'] = $limit;

        $response = $this->publicGetAggTrades (array_merge ($request, $params));
        return $this->parse_trades($response, $market, $since, $limit);
    }

    public function parse_order_status ($status) {
        $statuses = array (
            'NEW' => 'open',
            'PARTIALLY_FILLED' => 'open',
            'FILLED' => 'closed',
            'CANCELED' => 'canceled',
            'PENDING_CANCEL' => 'canceling', // currently unused
            'REJECTED' => 'rejected',
            'EXPIRED' => 'expired',
        );
        return (is_array ($statuses) && array_key_exists ($status, $statuses)) ? $statuses[$status] : $status;
    }

    public function parse_order ($order, $market = null) {
        $status = $this->parse_order_status($this->safe_string($order, 'status'));
        $symbol = $this->find_symbol($this->safe_string($order, 'symbol'), $market);
        $timestamp = null;
        if (is_array ($order) && array_key_exists ('time', $order))
            $timestamp = $order['time'];
        else if (is_array ($order) && array_key_exists ('transactTime', $order))
            $timestamp = $order['transactTime'];
        $price = $this->safe_float($order, 'price');
        $amount = $this->safe_float($order, 'origQty');
        $filled = $this->safe_float($order, 'executedQty');
        $remaining = null;
        $cost = $this->safe_float($order, 'cummulativeQuoteQty');
        if ($filled !== null) {
            if ($amount !== null) {
                $remaining = $amount - $filled;
                if ($this->options['parseOrderToPrecision']) {
                    $remaining = floatval ($this->amount_to_precision($symbol, $remaining));
                }
                $remaining = max ($remaining, 0.0);
            }
            if ($price !== null) {
                if ($cost === null) {
                    $cost = $price * $filled;
                }
            }
        }
        $id = $this->safe_string($order, 'orderId');
        $type = $this->safe_string($order, 'type');
        if ($type !== null) {
            $type = strtolower ($type);
            if ($type === 'market') {
                if ($price === 0.0) {
                    if (($cost !== null) && ($filled !== null)) {
                        if (($cost > 0) && ($filled > 0)) {
                            $price = $cost / $filled;
                        }
                    }
                }
            }
        }
        $side = $this->safe_string($order, 'side');
        if ($side !== null)
            $side = strtolower ($side);
        $fee = null;
        $trades = null;
        $fills = $this->safe_value($order, 'fills');
        if ($fills !== null) {
            $trades = $this->parse_trades($fills, $market);
            $numTrades = is_array ($trades) ? count ($trades) : 0;
            if ($numTrades > 0) {
                $cost = $trades[0]['cost'];
                $fee = array (
                    'cost' => $trades[0]['fee']['cost'],
                    'currency' => $trades[0]['fee']['currency'],
                );
                for ($i = 1; $i < count ($trades); $i++) {
                    $cost = $this->sum ($cost, $trades[$i]['cost']);
                    $fee['cost'] = $this->sum ($fee['cost'], $trades[$i]['fee']['cost']);
                }
            }
        }
        $average = null;
        if ($cost !== null) {
            if ($filled) {
                $average = $cost / $filled;
            }
            if ($this->options['parseOrderToPrecision']) {
                $cost = floatval ($this->cost_to_precision($symbol, $cost));
            }
        }
        $result = array (
            'info' => $order,
            'id' => $id,
            'timestamp' => $timestamp,
            'datetime' => $this->iso8601 ($timestamp),
            'lastTradeTimestamp' => null,
            'symbol' => $symbol,
            'type' => $type,
            'side' => $side,
            'price' => $price,
            'amount' => $amount,
            'cost' => $cost,
            'average' => $average,
            'filled' => $filled,
            'remaining' => $remaining,
            'status' => $status,
            'fee' => $fee,
            'trades' => $trades,
        );
        return $result;
    }

    public function create_order ($symbol, $type, $side, $amount, $price = null, $params = array ()) {
        $this->load_markets();
        $market = $this->market ($symbol);
        // the next 5 lines are added to support for testing orders
        $method = 'privatePostOrder';
        $test = $this->safe_value($params, 'test', false);
        if ($test) {
            $method .= 'Test';
            $params = $this->omit ($params, 'test');
        }
        $uppercaseType = strtoupper ($type);
        $newOrderRespType = $this->safe_value($this->options['newOrderRespType'], $type, 'RESULT');
        $order = array (
            'symbol' => $market['id'],
            'quantity' => $this->amount_to_precision($symbol, $amount),
            'type' => $uppercaseType,
            'side' => strtoupper ($side),
            'newOrderRespType' => $newOrderRespType, // 'ACK' for $order id, 'RESULT' for full $order or 'FULL' for $order with fills
        );
        $timeInForceIsRequired = false;
        $priceIsRequired = false;
        $stopPriceIsRequired = false;
        if ($uppercaseType === 'LIMIT') {
            $priceIsRequired = true;
            $timeInForceIsRequired = true;
        } else if (($uppercaseType === 'STOP_LOSS') || ($uppercaseType === 'TAKE_PROFIT')) {
            $stopPriceIsRequired = true;
        } else if (($uppercaseType === 'STOP_LOSS_LIMIT') || ($uppercaseType === 'TAKE_PROFIT_LIMIT')) {
            $stopPriceIsRequired = true;
            $priceIsRequired = true;
            $timeInForceIsRequired = true;
        } else if ($uppercaseType === 'LIMIT_MAKER') {
            $priceIsRequired = true;
        }
        if ($priceIsRequired) {
            if ($price === null) {
                throw new InvalidOrder ($this->id . ' createOrder $method requires a $price argument for a ' . $type . ' order');
            }
            $order['price'] = $this->price_to_precision($symbol, $price);
        }
        if ($timeInForceIsRequired) {
            $order['timeInForce'] = $this->options['defaultTimeInForce']; // 'GTC' = Good To Cancel (default), 'IOC' = Immediate Or Cancel
        }
        if ($stopPriceIsRequired) {
            $stopPrice = $this->safe_float($params, 'stopPrice');
            if ($stopPrice === null) {
                throw new InvalidOrder ($this->id . ' createOrder $method requires a $stopPrice extra param for a ' . $type . ' order');
            } else {
                $params = $this->omit ($params, 'stopPrice');
                $order['stopPrice'] = $this->price_to_precision($symbol, $stopPrice);
            }
        }
        $response = $this->$method (array_merge ($order, $params));
        return $this->parse_order($response, $market);
    }

    public function fetch_order ($id, $symbol = null, $params = array ()) {
        if ($symbol === null)
            throw new ArgumentsRequired ($this->id . ' fetchOrder requires a $symbol argument');
        $this->load_markets();
        $market = $this->market ($symbol);
        $origClientOrderId = $this->safe_value($params, 'origClientOrderId');
        $request = array (
            'symbol' => $market['id'],
        );
        if ($origClientOrderId !== null)
            $request['origClientOrderId'] = $origClientOrderId;
        else
            $request['orderId'] = intval ($id);
        $response = $this->privateGetOrder (array_merge ($request, $params));
        return $this->parse_order($response, $market);
    }

    public function fetch_orders ($symbol = null, $since = null, $limit = null, $params = array ()) {
        if ($symbol === null)
            throw new ArgumentsRequired ($this->id . ' fetchOrders requires a $symbol argument');
        $this->load_markets();
        $market = $this->market ($symbol);
        $request = array (
            'symbol' => $market['id'],
        );
        if ($since !== null) {
            $request['startTime'] = $since;
        }
        if ($limit !== null) {
            $request['limit'] = $limit;
        }
        $response = $this->privateGetAllOrders (array_merge ($request, $params));

        return $this->parse_orders($response, $market, $since, $limit);
    }

    public function fetch_open_orders ($symbol = null, $since = null, $limit = null, $params = array ()) {
        $this->load_markets();
        $market = null;
        $request = array ();
        if ($symbol !== null) {
            $market = $this->market ($symbol);
            $request['symbol'] = $market['id'];
        } else if ($this->options['warnOnFetchOpenOrdersWithoutSymbol']) {
            $symbols = $this->symbols;
            $numSymbols = is_array ($symbols) ? count ($symbols) : 0;
            $fetchOpenOrdersRateLimit = intval ($numSymbols / 2);
            throw new ExchangeError ($this->id . ' fetchOpenOrders WARNING => fetching open orders without specifying a $symbol is rate-limited to one call per ' . (string) $fetchOpenOrdersRateLimit . ' seconds. Do not call this method frequently to avoid ban. Set ' . $this->id . '.options["warnOnFetchOpenOrdersWithoutSymbol"] = false to suppress this warning message.');
        }
        $response = $this->privateGetOpenOrders (array_merge ($request, $params));
        return $this->parse_orders($response, $market, $since, $limit);
    }

    public function fetch_closed_orders ($symbol = null, $since = null, $limit = null, $params = array ()) {
        $orders = $this->fetch_orders($symbol, $since, $limit, $params);
        return $this->filter_by($orders, 'status', 'closed');
    }

    public function cancel_order ($id, $symbol = null, $params = array ()) {
        if ($symbol === null)
            throw new ArgumentsRequired ($this->id . ' cancelOrder requires a $symbol argument');
        $this->load_markets();
        $market = $this->market ($symbol);
        $response = $this->privateDeleteOrder (array_merge (array (
            'symbol' => $market['id'],
            'orderId' => intval ($id),
            // 'origClientOrderId' => $id,
        ), $params));
        return $this->parse_order($response);
    }

    public function fetch_my_trades ($symbol = null, $since = null, $limit = null, $params = array ()) {
        if ($symbol === null)
            throw new ArgumentsRequired ($this->id . ' fetchMyTrades requires a $symbol argument');
        $this->load_markets();
        $market = $this->market ($symbol);
        $request = array (
            'symbol' => $market['id'],
        );
        if ($limit !== null)
            $request['limit'] = $limit;
        $response = $this->privateGetMyTrades (array_merge ($request, $params));
        return $this->parse_trades($response, $market, $since, $limit);
    }

    public function fetch_deposits ($code = null, $since = null, $limit = null, $params = array ()) {
        $this->load_markets();
        $currency = null;
        $request = array ();
        if ($code !== null) {
            $currency = $this->currency ($code);
            $request['asset'] = $currency['id'];
        }
        if ($since !== null) {
            $request['startTime'] = $since;
        }
        $response = $this->wapiGetDepositHistory (array_merge ($request, $params));
        return $this->parseTransactions ($response['depositList'], $currency, $since, $limit);
    }

    public function fetch_withdrawals ($code = null, $since = null, $limit = null, $params = array ()) {
        $this->load_markets();
        $currency = null;
        $request = array ();
        if ($code !== null) {
            $currency = $this->currency ($code);
            $request['asset'] = $currency['id'];
        }
        if ($since !== null) {
            $request['startTime'] = $since;
        }
        $response = $this->wapiGetWithdrawHistory (array_merge ($request, $params));

        return $this->parseTransactions ($response['withdrawList'], $currency, $since, $limit);
    }

    public function parse_transaction_status_by_type ($status, $type = null) {
        if ($type === null) {
            return $status;
        }
        $statuses = array (
            'deposit' => array (
                '0' => 'pending',
                '1' => 'ok',
            ),
            'withdrawal' => array (
                '0' => 'pending', // Email Sent
                '1' => 'canceled', // Cancelled (different from 1 = ok in deposits)
                '2' => 'pending', // Awaiting Approval
                '3' => 'failed', // Rejected
                '4' => 'pending', // Processing
                '5' => 'failed', // Failure
                '6' => 'ok', // Completed
            ),
        );
        return (is_array ($statuses[$type]) && array_key_exists ($status, $statuses[$type])) ? $statuses[$type][$status] : $status;
    }

    public function parse_transaction ($transaction, $currency = null) {

        $id = $this->safe_string($transaction, 'id');
        $address = $this->safe_string($transaction, 'address');
        $tag = $this->safe_string($transaction, 'addressTag'); // set but unused
        if ($tag !== null) {
            if (strlen ($tag) < 1) {
                $tag = null;
            }
        }
        $txid = $this->safe_value($transaction, 'txId');
        $code = null;
        $currencyId = $this->safe_string($transaction, 'asset');
        if (is_array ($this->currencies_by_id) && array_key_exists ($currencyId, $this->currencies_by_id)) {
            $currency = $this->currencies_by_id[$currencyId];
        } else {
            $code = $this->common_currency_code($currencyId);
        }
        if ($currency !== null) {
            $code = $currency['code'];
        }
        $timestamp = null;
        $insertTime = $this->safe_integer($transaction, 'insertTime');
        $applyTime = $this->safe_integer($transaction, 'applyTime');
        $type = $this->safe_string($transaction, 'type');
        if ($type === null) {
            if (($insertTime !== null) && ($applyTime === null)) {
                $type = 'deposit';
                $timestamp = $insertTime;
            } else if (($insertTime === null) && ($applyTime !== null)) {
                $type = 'withdrawal';
                $timestamp = $applyTime;
            }
        }
        $status = $this->parse_transaction_status_by_type ($this->safe_string($transaction, 'status'), $type);
        $amount = $this->safe_float($transaction, 'amount');
        $feeCost = null;
        $fee = array (
            'cost' => $feeCost,
            'currency' => $code,
        );
        return array (
            'info' => $transaction,
            'id' => $id,
            'txid' => $txid,
            'timestamp' => $timestamp,
            'datetime' => $this->iso8601 ($timestamp),
            'address' => $address,
            'tag' => $tag,
            'type' => $type,
            'amount' => $amount,
            'currency' => $code,
            'status' => $status,
            'updated' => null,
            'fee' => $fee,
        );
    }

    public function fetch_deposit_address ($code, $params = array ()) {
        $this->load_markets();
        $currency = $this->currency ($code);
        $response = $this->wapiGetDepositAddress (array_merge (array (
            'asset' => $currency['id'],
        ), $params));
        if (is_array ($response) && array_key_exists ('success', $response)) {
            if ($response['success']) {
                $address = $this->safe_string($response, 'address');
                $tag = $this->safe_string($response, 'addressTag');
                return array (
                    'currency' => $code,
                    'address' => $this->check_address($address),
                    'tag' => $tag,
                    'info' => $response,
                );
            }
        }
    }

    public function fetch_funding_fees ($codes = null, $params = array ()) {
        $response = $this->wapiGetAssetDetail ();

        $detail = $this->safe_value($response, 'assetDetail');
        $ids = is_array ($detail) ? array_keys ($detail) : array ();
        $withdrawFees = array ();
        for ($i = 0; $i < count ($ids); $i++) {
            $id = $ids[$i];
            $code = $this->common_currency_code($id);
            $withdrawFees[$code] = $this->safe_float($detail[$id], 'withdrawFee');
        }
        return array (
            'withdraw' => $withdrawFees,
            'deposit' => array (),
            'info' => $response,
        );
    }

    public function withdraw ($code, $amount, $address, $tag = null, $params = array ()) {
        $this->check_address($address);
        $this->load_markets();
        $currency = $this->currency ($code);
        $name = mb_substr ($address, 0, 20);
        $request = array (
            'asset' => $currency['id'],
            'address' => $address,
            'amount' => floatval ($amount),
            'name' => $name,
        );
        if ($tag)
            $request['addressTag'] = $tag;
        $response = $this->wapiPostWithdraw (array_merge ($request, $params));
        return array (
            'info' => $response,
            'id' => $this->safe_string($response, 'id'),
        );
    }

    public function sign ($path, $api = 'public', $method = 'GET', $params = array (), $headers = null, $body = null) {
        $url = $this->urls['api'][$api];
        $url .= '/' . $path;
        if ($api === 'wapi')
            $url .= '.html';
        // v1 special case for userDataStream
        if ($path === 'userDataStream') {
            $body = $this->urlencode ($params);
            $headers = array (
                'X-MBX-APIKEY' => $this->apiKey,
                'Content-Type' => 'application/x-www-form-urlencoded',
            );
        } else if (($api === 'private') || ($api === 'wapi')) {
            $this->check_required_credentials();
            $query = $this->urlencode (array_merge (array (
                'timestamp' => $this->nonce (),
                'recvWindow' => $this->options['recvWindow'],
            ), $params));
            $signature = $this->hmac ($this->encode ($query), $this->encode ($this->secret));
            $query .= '&' . 'signature=' . $signature;
            $headers = array (
                'X-MBX-APIKEY' => $this->apiKey,
            );
            if (($method === 'GET') || ($method === 'DELETE') || ($api === 'wapi')) {
                $url .= '?' . $query;
            } else {
                $body = $query;
                $headers['Content-Type'] = 'application/x-www-form-urlencoded';
            }
        } else {
            if ($params)
                $url .= '?' . $this->urlencode ($params);
        }
        return array ( 'url' => $url, 'method' => $method, 'body' => $body, 'headers' => $headers );
    }

    public function handle_errors ($code, $reason, $url, $method, $headers, $body, $response) {
        if (($code === 418) || ($code === 429))
            throw new DDoSProtection ($this->id . ' ' . (string) $code . ' ' . $reason . ' ' . $body);

        if ($code >= 400) {
            if (mb_strpos ($body, 'Price * QTY is zero or less') !== false)
                throw new InvalidOrder ($this->id . ' order cost = amount * price is zero or less ' . $body);
            if (mb_strpos ($body, 'LOT_SIZE') !== false)
                throw new InvalidOrder ($this->id . ' order amount should be evenly divisible by lot size ' . $body);
            if (mb_strpos ($body, 'PRICE_FILTER') !== false)
                throw new InvalidOrder ($this->id . ' order price is invalid, i.e. exceeds allowed price precision, exceeds min price or max price limits or is invalid float value in general, use $this->price_to_precision(symbol, amount) ' . $body);
        }
        if (strlen ($body) > 0) {
            if ($body[0] === '{') {

                $success = $this->safe_value($response, 'success', true);
                if (!$success) {
                    $message = $this->safe_string($response, 'msg');
                    $parsedMessage = null;
                    if ($message !== null) {
                        try {
                            $parsedMessage = json_decode ($message, $as_associative_array = true);
                        } catch (Exception $e) {
                            // do nothing
                            $parsedMessage = null;
                        }
                        if ($parsedMessage !== null) {
                            $response = $parsedMessage;
                        }
                    }
                }
                // checks against $error codes
                $error = $this->safe_string($response, 'code');
                if ($error !== null) {
                    $exceptions = $this->exceptions;
                    if (is_array ($exceptions) && array_key_exists ($error, $exceptions)) {

                        if (($error === '-2015') && $this->options['hasAlreadyAuthenticatedSuccessfully']) {
                            throw new DDoSProtection ($this->id . ' temporary banned => ' . $body);
                        }
                        $message = $this->safe_string($response, 'msg');
                        if ($message === 'Order would trigger immediately.') {
                            throw new InvalidOrder ($this->id . ' ' . $body);
                        } else if ($message === 'Account has insufficient balance for requested action.') {
                            throw new InsufficientFunds ($this->id . ' ' . $body);
                        } else if ($message === 'Rest API trading is not enabled.') {
                            throw new ExchangeNotAvailable ($this->id . ' ' . $body);
                        }
                        throw new $exceptions[$error] ($this->id . ' ' . $body);
                    } else {
                        throw new ExchangeError ($this->id . ' ' . $body);
                    }
                }
                if (!$success) {
                    throw new ExchangeError ($this->id . ' ' . $body);
                }
            }
        }
    }

    public function request ($path, $api = 'public', $method = 'GET', $params = array (), $headers = null, $body = null) {
        $response = $this->fetch2 ($path, $api, $method, $params, $headers, $body);

        if (($api === 'private') || ($api === 'wapi'))
            $this->options['hasAlreadyAuthenticatedSuccessfully'] = true;
        return $response;
    }
}
