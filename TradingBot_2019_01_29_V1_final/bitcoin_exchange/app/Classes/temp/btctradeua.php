<?php

namespace ccxt;

// PLEASE DO NOT EDIT THIS FILE, IT IS GENERATED AND WILL BE OVERWRITTEN:
// https://github.com/ccxt/ccxt/blob/master/CONTRIBUTING.md#how-to-contribute-code

use Exception as Exception; // a common import

class btctradeua extends Exchange {

    public function describe () {
        return array_replace_recursive (parent::describe (), array (
            'id' => 'btctradeua',
            'name' => 'BTC Trade UA',
            'countries' => array ( 'UA' ), // Ukraine,
            'rateLimit' => 3000,
            'has' => array (
                'CORS' => true,
                'createMarketOrder' => false,
                'fetchOpenOrders' => true,
            ),
            'urls' => array (
                'logo' => 'https://user-images.githubusercontent.com/1294454/27941483-79fc7350-62d9-11e7-9f61-ac47f28fcd96.jpg',
                'api' => 'https://btc-trade.com.ua/api',
                'www' => 'https://btc-trade.com.ua',
                'doc' => 'https://docs.google.com/document/d/1ocYA0yMy_RXd561sfG3qEPZ80kyll36HUxvCRe5GbhE/edit',
            ),
            'api' => array (
                'public' => array (
                    'get' => array (
                        'deals/{symbol}',
                        'trades/sell/{symbol}',
                        'trades/buy/{symbol}',
                        'japan_stat/high/{symbol}',
                    ),
                ),
                'private' => array (
                    'post' => array (
                        'auth',
                        'ask/{symbol}',
                        'balance',
                        'bid/{symbol}',
                        'buy/{symbol}',
                        'my_orders/{symbol}',
                        'order/status/{id}',
                        'remove/order/{id}',
                        'sell/{symbol}',
                    ),
                ),
            ),
            'markets' => array (
                'BCH/UAH' => array ( 'id' => 'bch_uah', 'symbol' => 'BCH/UAH', 'base' => 'BCH', 'quote' => 'UAH' ),
                'BTC/UAH' => array ( 'id' => 'btc_uah', 'symbol' => 'BTC/UAH', 'base' => 'BTC', 'quote' => 'UAH', 'precision' => array ( 'price' => 1 ), 'limits' => array ( 'amount' => array ( 'min' => 0.0000000001 ))),
                'DASH/BTC' => array ( 'id' => 'dash_btc', 'symbol' => 'DASH/BTC', 'base' => 'DASH', 'quote' => 'BTC' ),
                'DASH/UAH' => array ( 'id' => 'dash_uah', 'symbol' => 'DASH/UAH', 'base' => 'DASH', 'quote' => 'UAH' ),
                'DOGE/BTC' => array ( 'id' => 'doge_btc', 'symbol' => 'DOGE/BTC', 'base' => 'DOGE', 'quote' => 'BTC' ),
                'DOGE/UAH' => array ( 'id' => 'doge_uah', 'symbol' => 'DOGE/UAH', 'base' => 'DOGE', 'quote' => 'UAH' ),
                'ETH/UAH' => array ( 'id' => 'eth_uah', 'symbol' => 'ETH/UAH', 'base' => 'ETH', 'quote' => 'UAH' ),
                'ITI/UAH' => array ( 'id' => 'iti_uah', 'symbol' => 'ITI/UAH', 'base' => 'ITI', 'quote' => 'UAH' ),
                'KRB/UAH' => array ( 'id' => 'krb_uah', 'symbol' => 'KRB/UAH', 'base' => 'KRB', 'quote' => 'UAH' ),
                'LTC/BTC' => array ( 'id' => 'ltc_btc', 'symbol' => 'LTC/BTC', 'base' => 'LTC', 'quote' => 'BTC' ),
                'LTC/UAH' => array ( 'id' => 'ltc_uah', 'symbol' => 'LTC/UAH', 'base' => 'LTC', 'quote' => 'UAH' ),
                'NVC/BTC' => array ( 'id' => 'nvc_btc', 'symbol' => 'NVC/BTC', 'base' => 'NVC', 'quote' => 'BTC' ),
                'NVC/UAH' => array ( 'id' => 'nvc_uah', 'symbol' => 'NVC/UAH', 'base' => 'NVC', 'quote' => 'UAH' ),
                'PPC/BTC' => array ( 'id' => 'ppc_btc', 'symbol' => 'PPC/BTC', 'base' => 'PPC', 'quote' => 'BTC' ),
                'SIB/UAH' => array ( 'id' => 'sib_uah', 'symbol' => 'SIB/UAH', 'base' => 'SIB', 'quote' => 'UAH' ),
                'XMR/UAH' => array ( 'id' => 'xmr_uah', 'symbol' => 'XMR/UAH', 'base' => 'XMR', 'quote' => 'UAH' ),
                'ZEC/UAH' => array ( 'id' => 'zec_uah', 'symbol' => 'ZEC/UAH', 'base' => 'ZEC', 'quote' => 'UAH' ),
            ),
            'fees' => array (
                'trading' => array (
                    'maker' => 0.1 / 100,
                    'taker' => 0.1 / 100,
                ),
                'funding' => array (
                    'withdraw' => array (
                        'BTC' => 0.0006,
                        'LTC' => 0.01,
                        'NVC' => 0.01,
                        'DOGE' => 10,
                    ),
                ),
            ),
        ));
    }

    public function sign_in () {
        return $this->privatePostAuth ();
    }

    public function fetch_balance ($params = array ()) {
        $response = $this->privatePostBalance ();
        $result = array ( 'info' => $response );
        if (is_array ($response) && array_key_exists ('accounts', $response)) {
            $accounts = $response['accounts'];
            for ($b = 0; $b < count ($accounts); $b++) {
                $account = $accounts[$b];
                $currency = $account['currency'];
                $balance = floatval ($account['balance']);
                $result[$currency] = array (
                    'free' => $balance,
                    'used' => 0.0,
                    'total' => $balance,
                );
            }
        }
        return $this->parse_balance($result);
    }

    public function fetch_order_book ($symbol, $limit = null, $params = array ()) {
        $market = $this->market ($symbol);
        $bids = $this->publicGetTradesBuySymbol (array_merge (array (
            'symbol' => $market['id'],
        ), $params));
        $asks = $this->publicGetTradesSellSymbol (array_merge (array (
            'symbol' => $market['id'],
        ), $params));
        $orderbook = array (
            'bids' => array (),
            'asks' => array (),
        );
        if ($bids) {
            if (is_array ($bids) && array_key_exists ('list', $bids))
                $orderbook['bids'] = $bids['list'];
        }
        if ($asks) {
            if (is_array ($asks) && array_key_exists ('list', $asks))
                $orderbook['asks'] = $asks['list'];
        }
        return $this->parse_order_book($orderbook, null, 'bids', 'asks', 'price', 'currency_trade');
    }

    public function fetch_ticker ($symbol, $params = array ()) {
        $response = $this->publicGetJapanStatHighSymbol (array_merge (array (
            'symbol' => $this->market_id($symbol),
        ), $params));
        $ticker = $response['trades'];
        $timestamp = $this->milliseconds ();
        $result = array (
            'symbol' => $symbol,
            'timestamp' => $timestamp,
            'datetime' => $this->iso8601 ($timestamp),
            'high' => null,
            'low' => null,
            'bid' => null,
            'bidVolume' => null,
            'ask' => null,
            'askVolume' => null,
            'vwap' => null,
            'open' => null,
            'close' => null,
            'last' => null,
            'previousClose' => null,
            'change' => null,
            'percentage' => null,
            'average' => null,
            'baseVolume' => null,
            'quoteVolume' => null,
            'info' => $ticker,
        );
        $tickerLength = is_array ($ticker) ? count ($ticker) : 0;
        if ($tickerLength > 0) {
            $start = max ($tickerLength - 48, 0);
            for ($t = $start; $t < count ($ticker); $t++) {
                $candle = $ticker[$t];
                if ($result['open'] === null)
                    $result['open'] = $candle[1];
                if (($result['high'] === null) || ($result['high'] < $candle[2]))
                    $result['high'] = $candle[2];
                if (($result['low'] === null) || ($result['low'] > $candle[3]))
                    $result['low'] = $candle[3];
                if ($result['baseVolume'] === null)
                    $result['baseVolume'] = -$candle[5];
                else
                    $result['baseVolume'] -= $candle[5];
            }
            $last = $tickerLength - 1;
            $result['last'] = $ticker[$last][4];
            $result['close'] = $result['last'];
            $result['baseVolume'] = -1 * $result['baseVolume'];
        }
        return $result;
    }

    public function convert_cyrillic_month_name_to_string ($cyrillic) {
        $months = array (
            '????????????' => '01',
            '??????????????' => '02',
            '??????????' => '03',
            '????????????' => '04',
            '??????' => '05',
            '????????' => '06',
            '????????' => '07',
            '??????????????' => '08',
            '????????????????' => '09',
            '??????????????' => '10',
            '????????????' => '11',
            '??????????????' => '12',
        );
        $month = null;
        if (is_array ($months) && array_key_exists ($cyrillic, $months))
            $month = $months[$cyrillic];
        return $month;
    }

    public function parse_cyrillic_datetime ($cyrillic) {
        $parts = explode (' ', $cyrillic);
        $day = $parts[0];
        $month = $this->convert_cyrillic_month_name_to_string ($parts[1]);
        if (!$month)
            throw new ExchangeError ($this->id . ' parseTrade() null $month name => ' . $cyrillic);
        $year = $parts[2];
        $hms = $parts[4];
        $hmsLength = is_array ($hms) ? count ($hms) : 0;
        if ($hmsLength === 7) {
            $hms = '0' . $hms;
        }
        if (strlen ($day) === 1) {
            $day = '0' . $day;
        }
        $ymd = implode ('-', array ($year, $month, $day));
        $ymdhms = $ymd . 'T' . $hms;
        $timestamp = $this->parse8601 ($ymdhms);
        // server reports local time, adjust to UTC
        $md = implode ('', array ($month, $day));
        $md = intval ($md);
        // a special case for DST
        // subtract 2 hours during winter
        if ($md < 325 || $md > 1028)
            return $timestamp - 7200000;
        // subtract 3 hours during summer
        return $timestamp - 10800000;
    }

    public function parse_trade ($trade, $market) {
        $timestamp = $this->parse_cyrillic_datetime ($trade['pub_date']);
        return array (
            'id' => (string) $trade['id'],
            'info' => $trade,
            'timestamp' => $timestamp,
            'datetime' => $this->iso8601 ($timestamp),
            'symbol' => $market['symbol'],
            'type' => 'limit',
            'side' => $trade['type'],
            'price' => $this->safe_float($trade, 'price'),
            'amount' => $this->safe_float($trade, 'amnt_trade'),
        );
    }

    public function fetch_trades ($symbol, $since = null, $limit = null, $params = array ()) {
        $market = $this->market ($symbol);
        $response = $this->publicGetDealsSymbol (array_merge (array (
            'symbol' => $market['id'],
        ), $params));
        // they report each trade twice (once for both of the two sides of the fill)
        // deduplicate $trades for that reason
        $trades = array ();
        for ($i = 0; $i < count ($response); $i++) {
            if (fmod ($response[$i]['id'], 2)) {
                $trades[] = $response[$i];
            }
        }
        return $this->parse_trades($trades, $market, $since, $limit);
    }

    public function create_order ($symbol, $type, $side, $amount, $price = null, $params = array ()) {
        if ($type === 'market')
            throw new ExchangeError ($this->id . ' allows limit orders only');
        $market = $this->market ($symbol);
        $method = 'privatePost' . $this->capitalize ($side) . 'Id';
        $order = array (
            'count' => $amount,
            'currency1' => $market['quote'],
            'currency' => $market['base'],
            'price' => $price,
        );
        return $this->$method (array_merge ($order, $params));
    }

    public function cancel_order ($id, $symbol = null, $params = array ()) {
        return $this->privatePostRemoveOrderId (array ( 'id' => $id ));
    }

    public function parse_order ($trade, $market) {
        $timestamp = $this->milliseconds;
        return array (
            'id' => $trade['id'],
            'timestamp' => $timestamp, // until they fix their $timestamp
            'datetime' => $this->iso8601 ($timestamp),
            'lastTradeTimestamp' => null,
            'status' => 'open',
            'symbol' => $market['symbol'],
            'type' => null,
            'side' => $trade['type'],
            'price' => $trade['price'],
            'amount' => $trade['amnt_trade'],
            'filled' => 0,
            'remaining' => $trade['amnt_trade'],
            'trades' => null,
            'info' => $trade,
        );
    }

    public function fetch_open_orders ($symbol = null, $since = null, $limit = null, $params = array ()) {
        if ($symbol === null)
            throw new ArgumentsRequired ($this->id . ' fetchOpenOrders requires a $symbol argument');
        $market = $this->market ($symbol);
        $response = $this->privatePostMyOrdersSymbol (array_merge (array (
            'symbol' => $market['id'],
        ), $params));
        $orders = $response['your_open_orders'];
        return $this->parse_orders($orders, $market, $since, $limit);
    }

    public function nonce () {
        return $this->milliseconds ();
    }

    public function sign ($path, $api = 'public', $method = 'GET', $params = array (), $headers = null, $body = null) {
        $url = $this->urls['api'] . '/' . $this->implode_params($path, $params);
        $query = $this->omit ($params, $this->extract_params($path));
        if ($api === 'public') {
            if ($query)
                $url .= $this->implode_params($path, $query);
        } else {
            $this->check_required_credentials();
            $nonce = $this->nonce ();
            $body = $this->urlencode (array_merge (array (
                'out_order_id' => $nonce,
                'nonce' => $nonce,
            ), $query));
            $auth = $body . $this->secret;
            $headers = array (
                'public-key' => $this->apiKey,
                'api-sign' => $this->hash ($this->encode ($auth), 'sha256'),
                'Content-Type' => 'application/x-www-form-urlencoded',
            );
        }
        return array ( 'url' => $url, 'method' => $method, 'body' => $body, 'headers' => $headers );
    }
}
