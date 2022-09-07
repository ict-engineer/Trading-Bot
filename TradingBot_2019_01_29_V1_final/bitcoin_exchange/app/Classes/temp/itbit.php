<?php

namespace ccxt;

// PLEASE DO NOT EDIT THIS FILE, IT IS GENERATED AND WILL BE OVERWRITTEN:
// https://github.com/ccxt/ccxt/blob/master/CONTRIBUTING.md#how-to-contribute-code

use Exception as Exception; // a common import

class itbit extends Exchange {

    public function describe () {
        return array_replace_recursive (parent::describe (), array (
            'id' => 'itbit',
            'name' => 'itBit',
            'countries' => array ( 'US' ),
            'rateLimit' => 2000,
            'version' => 'v1',
            'has' => array (
                'CORS' => true,
                'createMarketOrder' => false,
            ),
            'urls' => array (
                'logo' => 'https://user-images.githubusercontent.com/1294454/27822159-66153620-60ad-11e7-89e7-005f6d7f3de0.jpg',
                'api' => 'https://api.itbit.com',
                'www' => 'https://www.itbit.com',
                'doc' => array (
                    'https://api.itbit.com/docs',
                    'https://www.itbit.com/api',
                ),
            ),
            'api' => array (
                'public' => array (
                    'get' => array (
                        'markets/{symbol}/ticker',
                        'markets/{symbol}/order_book',
                        'markets/{symbol}/trades',
                    ),
                ),
                'private' => array (
                    'get' => array (
                        'wallets',
                        'wallets/{walletId}',
                        'wallets/{walletId}/balances/{currencyCode}',
                        'wallets/{walletId}/funding_history',
                        'wallets/{walletId}/trades',
                        'wallets/{walletId}/orders',
                        'wallets/{walletId}/orders/{id}',
                    ),
                    'post' => array (
                        'wallet_transfers',
                        'wallets',
                        'wallets/{walletId}/cryptocurrency_deposits',
                        'wallets/{walletId}/cryptocurrency_withdrawals',
                        'wallets/{walletId}/orders',
                        'wire_withdrawal',
                    ),
                    'delete' => array (
                        'wallets/{walletId}/orders/{id}',
                    ),
                ),
            ),
            'markets' => array (
                'BTC/USD' => array ( 'id' => 'XBTUSD', 'symbol' => 'BTC/USD', 'base' => 'BTC', 'quote' => 'USD' ),
                'BTC/SGD' => array ( 'id' => 'XBTSGD', 'symbol' => 'BTC/SGD', 'base' => 'BTC', 'quote' => 'SGD' ),
                'BTC/EUR' => array ( 'id' => 'XBTEUR', 'symbol' => 'BTC/EUR', 'base' => 'BTC', 'quote' => 'EUR' ),
            ),
            'fees' => array (
                'trading' => array (
                    'maker' => 0,
                    'taker' => 0.2 / 100,
                ),
            ),
        ));
    }

    public function fetch_order_book ($symbol, $limit = null, $params = array ()) {
        $orderbook = $this->publicGetMarketsSymbolOrderBook (array_merge (array (
            'symbol' => $this->market_id($symbol),
        ), $params));
        return $this->parse_order_book($orderbook);
    }

    public function fetch_ticker ($symbol, $params = array ()) {
        $ticker = $this->publicGetMarketsSymbolTicker (array_merge (array (
            'symbol' => $this->market_id($symbol),
        ), $params));
        $serverTimeUTC = $this->safe_string($ticker, 'serverTimeUTC');
        if (!$serverTimeUTC)
            throw new ExchangeError ($this->id . ' fetchTicker returned a bad response => ' . $this->json ($ticker));
        $timestamp = $this->parse8601 ($serverTimeUTC);
        $vwap = $this->safe_float($ticker, 'vwap24h');
        $baseVolume = $this->safe_float($ticker, 'volume24h');
        $quoteVolume = null;
        if ($baseVolume !== null && $vwap !== null)
            $quoteVolume = $baseVolume * $vwap;
        $last = $this->safe_float($ticker, 'lastPrice');
        return array (
            'symbol' => $symbol,
            'timestamp' => $timestamp,
            'datetime' => $this->iso8601 ($timestamp),
            'high' => $this->safe_float($ticker, 'high24h'),
            'low' => $this->safe_float($ticker, 'low24h'),
            'bid' => $this->safe_float($ticker, 'bid'),
            'bidVolume' => null,
            'ask' => $this->safe_float($ticker, 'ask'),
            'askVolume' => null,
            'vwap' => $vwap,
            'open' => $this->safe_float($ticker, 'openToday'),
            'close' => $last,
            'last' => $last,
            'previousClose' => null,
            'change' => null,
            'percentage' => null,
            'average' => null,
            'baseVolume' => $baseVolume,
            'quoteVolume' => $quoteVolume,
            'info' => $ticker,
        );
    }

    public function parse_trade ($trade, $market) {
        $timestamp = $this->parse8601 ($trade['timestamp']);
        $id = (string) $trade['matchNumber'];
        return array (
            'info' => $trade,
            'timestamp' => $timestamp,
            'datetime' => $this->iso8601 ($timestamp),
            'symbol' => $market['symbol'],
            'id' => $id,
            'order' => $id,
            'type' => null,
            'side' => null,
            'price' => $this->safe_float($trade, 'price'),
            'amount' => $this->safe_float($trade, 'amount'),
        );
    }

    public function fetch_trades ($symbol, $since = null, $limit = null, $params = array ()) {
        $market = $this->market ($symbol);
        $response = $this->publicGetMarketsSymbolTrades (array_merge (array (
            'symbol' => $market['id'],
        ), $params));
        return $this->parse_trades($response['recentTrades'], $market, $since, $limit);
    }

    public function fetch_balance ($params = array ()) {
        $response = $this->fetch_wallets ();
        $balances = $response[0]['balances'];
        $result = array ( 'info' => $response );
        for ($b = 0; $b < count ($balances); $b++) {
            $balance = $balances[$b];
            $currency = $balance['currency'];
            $account = array (
                'free' => floatval ($balance['availableBalance']),
                'used' => 0.0,
                'total' => floatval ($balance['totalBalance']),
            );
            $account['used'] = $account['total'] - $account['free'];
            $result[$currency] = $account;
        }
        return $this->parse_balance($result);
    }

    public function fetch_wallets ($params = array ()) {
        if (!$this->uid)
            throw new AuthenticationError ($this->id . ' fetchWallets requires uid API credential');
        $request = array (
            'userId' => $this->uid,
        );
        return $this->privateGetWallets (array_merge ($request, $params));
    }

    public function fetch_wallet ($walletId, $params = array ()) {
        $wallet = array (
            'walletId' => $walletId,
        );
        return $this->privateGetWalletsWalletId (array_merge ($wallet, $params));
    }

    public function fetch_open_orders ($symbol = null, $since = null, $limit = null, $params = array ()) {
        return $this->fetch_orders($symbol, $since, $limit, array_merge (array (
            'status' => 'open',
        ), $params));
    }

    public function fetch_closed_orders ($symbol = null, $since = null, $limit = null, $params = array ()) {
        return $this->fetch_orders($symbol, $since, $limit, array_merge (array (
            'status' => 'filled',
        ), $params));
    }

    public function fetch_orders ($symbol = null, $since = null, $limit = null, $params = array ()) {
        $walletIdInParams = (is_array ($params) && array_key_exists ('walletId', $params));
        if (!$walletIdInParams)
            throw new ExchangeError ($this->id . ' fetchOrders requires a $walletId parameter');
        $walletId = $params['walletId'];
        $response = $this->privateGetWalletsWalletIdOrders (array_merge (array (
            'walletId' => $walletId,
        ), $params));
        $orders = $this->parse_orders($response, null, $since, $limit);
        return $orders;
    }

    public function parse_order ($order, $market = null) {
        $side = $order['side'];
        $type = $order['type'];
        $symbol = $this->markets_by_id[$order['instrument']]['symbol'];
        $timestamp = $this->parse8601 ($order['createdTime']);
        $amount = $this->safe_float($order, 'amount');
        $filled = $this->safe_float($order, 'amountFilled');
        $remaining = $amount - $filled;
        $fee = null;
        $price = $this->safe_float($order, 'price');
        $cost = $price * $this->safe_float($order, 'volumeWeightedAveragePrice');
        return array (
            'id' => $order['id'],
            'info' => $order,
            'timestamp' => $timestamp,
            'datetime' => $this->iso8601 ($timestamp),
            'lastTradeTimestamp' => null,
            'status' => $order['status'],
            'symbol' => $symbol,
            'type' => $type,
            'side' => $side,
            'price' => $price,
            'cost' => $cost,
            'amount' => $amount,
            'filled' => $filled,
            'remaining' => $remaining,
            'fee' => $fee,
            // 'trades' => $this->parse_trades($order['trades'], $market),
        );
    }

    public function nonce () {
        return $this->milliseconds ();
    }

    public function create_order ($symbol, $type, $side, $amount, $price = null, $params = array ()) {
        if ($type === 'market')
            throw new ExchangeError ($this->id . ' allows limit orders only');
        $walletIdInParams = (is_array ($params) && array_key_exists ('walletId', $params));
        if (!$walletIdInParams)
            throw new ExchangeError ($this->id . ' createOrder requires a walletId parameter');
        $amount = (string) $amount;
        $price = (string) $price;
        $market = $this->market ($symbol);
        $order = array (
            'side' => $side,
            'type' => $type,
            'currency' => str_replace ($market['quote'], '', $market['id']),
            'amount' => $amount,
            'display' => $amount,
            'price' => $price,
            'instrument' => $market['id'],
        );
        $response = $this->privatePostWalletsWalletIdOrders (array_merge ($order, $params));
        return array (
            'info' => $response,
            'id' => $response['id'],
        );
    }

    public function fetch_order ($id, $symbol = null, $params = array ()) {
        $walletIdInParams = (is_array ($params) && array_key_exists ('walletId', $params));
        if (!$walletIdInParams)
            throw new ExchangeError ($this->id . ' fetchOrder requires a walletId parameter');
        return $this->privateGetWalletsWalletIdOrdersId (array_merge (array (
            'id' => $id,
        ), $params));
    }

    public function cancel_order ($id, $symbol = null, $params = array ()) {
        $walletIdInParams = (is_array ($params) && array_key_exists ('walletId', $params));
        if (!$walletIdInParams)
            throw new ExchangeError ($this->id . ' cancelOrder requires a walletId parameter');
        return $this->privateDeleteWalletsWalletIdOrdersId (array_merge (array (
            'id' => $id,
        ), $params));
    }

    public function sign ($path, $api = 'public', $method = 'GET', $params = array (), $headers = null, $body = null) {
        $url = $this->urls['api'] . '/' . $this->version . '/' . $this->implode_params($path, $params);
        $query = $this->omit ($params, $this->extract_params($path));
        if ($method === 'GET' && $query)
            $url .= '?' . $this->urlencode ($query);
        if ($method === 'POST' && $query)
            $body = $this->json ($query);
        else
            $body = '';
        if ($api === 'private') {
            $this->check_required_credentials();
            $nonce = (string) $this->nonce ();
            $timestamp = $nonce;
            $auth = array ( $method, $url, $body, $nonce, $timestamp );
            $message = $nonce . str_replace ('\\/', '/', $this->json ($auth));
            $hash = $this->hash ($this->encode ($message), 'sha256', 'binary');
            $binaryUrl = $this->encode ($url);
            $binhash = $this->binary_concat($binaryUrl, $hash);
            $signature = $this->hmac ($binhash, $this->encode ($this->secret), 'sha512', 'base64');
            $headers = array (
                'Authorization' => $this->apiKey . ':' . $signature,
                'Content-Type' => 'application/json',
                'X-Auth-Timestamp' => $timestamp,
                'X-Auth-Nonce' => $nonce,
            );
        }
        return array ( 'url' => $url, 'method' => $method, 'body' => $body, 'headers' => $headers );
    }

    public function request ($path, $api = 'public', $method = 'GET', $params = array (), $headers = null, $body = null) {
        $response = $this->fetch2 ($path, $api, $method, $params, $headers, $body);
        if (is_array ($response) && array_key_exists ('code', $response))
            throw new ExchangeError ($this->id . ' ' . $this->json ($response));
        return $response;
    }
}