<?php

namespace App\Classes;
use App\Classes\Exchange;

use Exception as Exception; // a common import
class bitfinex extends Exchange {

    public function describe () {
        return array_replace_recursive (parent::describe (), array (
            'id' => 'bitfinex',
            'name' => 'Bitfinex',
            'countries' => array ( 'VG' ),
            'version' => 'v1',
            'rateLimit' => 1500,
            'certified' => true,
            // new metainfo interface
            'has' => array (
                'CORS' => false,
                'createDepositAddress' => true,
                'deposit' => true,
                'fetchClosedOrders' => true,
                'fetchDepositAddress' => true,
                'fetchTradingFees' => true,
                'fetchFundingFees' => true,
                'fetchMyTrades' => true,
                'fetchOHLCV' => true,
                'fetchOpenOrders' => true,
                'fetchOrder' => true,
                'fetchTickers' => true,
                'fetchTransactions' => true,
                'fetchDeposits' => false,
                'fetchWithdrawals' => false,
                'withdraw' => true,
            ),
            'timeframes' => array (
                '1m' => '1m',
                '5m' => '5m',
                '15m' => '15m',
                '30m' => '30m',
                '1h' => '1h',
                '3h' => '3h',
                '6h' => '6h',
                '12h' => '12h',
                '1d' => '1D',
                '1w' => '7D',
                '2w' => '14D',
                '1M' => '1M',
            ),
            'urls' => array (
                'logo' => 'https://user-images.githubusercontent.com/1294454/27766244-e328a50c-5ed2-11e7-947b-041416579bb3.jpg',
                'api' => 'https://api.bitfinex.com',
                'www' => 'https://www.bitfinex.com',
                'doc' => array (
                    'https://bitfinex.readme.io/v1/docs',
                    'https://github.com/bitfinexcom/bitfinex-api-node',
                ),
            ),
            'api' => array (
                'v2' => array (
                    'get' => array (
                        'candles/trade:{timeframe}:{symbol}/{section}',
                        'candles/trade:{timeframe}:{symbol}/last',
                        'candles/trade:{timeframe}:{symbol}/hist',
                    ),
                ),
                'public' => array (
                    'get' => array (
                        'book/{symbol}',
                        // 'candles/{symbol}',
                        'lendbook/{currency}',
                        'lends/{currency}',
                        'pubticker/{symbol}',
                        'stats/{symbol}',
                        'symbols',
                        'symbols_details',
                        'tickers',
                        'today',
                        'trades/{symbol}',
                    ),
                ),
                'private' => array (
                    'post' => array (
                        'account_fees',
                        'account_infos',
                        'balances',
                        'basket_manage',
                        'credits',
                        'deposit/new',
                        'funding/close',
                        'history',
                        'history/movements',
                        'key_info',
                        'margin_infos',
                        'mytrades',
                        'mytrades_funding',
                        'offer/cancel',
                        'offer/new',
                        'offer/status',
                        'offers',
                        'offers/hist',
                        'order/cancel',
                        'order/cancel/all',
                        'order/cancel/multi',
                        'order/cancel/replace',
                        'order/new',
                        'order/new/multi',
                        'order/status',
                        'orders',
                        'orders/hist',
                        'position/claim',
                        'position/close',
                        'positions',
                        'summary',
                        'taken_funds',
                        'total_taken_funds',
                        'transfer',
                        'unused_taken_funds',
                        'withdraw',
                    ),
                ),
            ),
            'fees' => array (
                'trading' => array (
                    'tierBased' => true,
                    'percentage' => true,
                    'maker' => 0.1 / 100,
                    'taker' => 0.2 / 100,
                    'tiers' => array (
                        'taker' => [
                            [0, 0.2 / 100],
                            [500000, 0.2 / 100],
                            [1000000, 0.2 / 100],
                            [2500000, 0.2 / 100],
                            [5000000, 0.2 / 100],
                            [7500000, 0.2 / 100],
                            [10000000, 0.18 / 100],
                            [15000000, 0.16 / 100],
                            [20000000, 0.14 / 100],
                            [25000000, 0.12 / 100],
                            [30000000, 0.1 / 100],
                        ],
                        'maker' => [
                            [0, 0.1 / 100],
                            [500000, 0.08 / 100],
                            [1000000, 0.06 / 100],
                            [2500000, 0.04 / 100],
                            [5000000, 0.02 / 100],
                            [7500000, 0],
                            [10000000, 0],
                            [15000000, 0],
                            [20000000, 0],
                            [25000000, 0],
                            [30000000, 0],
                        ],
                    ),
                ),
                'funding' => array (
                    'tierBased' => false, // true for tier-based/progressive
                    'percentage' => false, // fixed commission
                    // Actually deposit fees are free for larger deposits (> $1000 USD equivalent)
                    // these values below are deprecated, we should not hardcode fees and limits anymore
                    // to be reimplemented with bitfinex funding fees from their API or web endpoints
                    'deposit' => array (
                        'BTC' => 0.0004,
                        'IOTA' => 0.5,
                        'ETH' => 0.0027,
                        'BCH' => 0.0001,
                        'LTC' => 0.001,
                        'EOS' => 0.24279,
                        'XMR' => 0.04,
                        'SAN' => 0.99269,
                        'DASH' => 0.01,
                        'ETC' => 0.01,
                        'XRP' => 0.02,
                        'YYW' => 16.915,
                        'NEO' => 0,
                        'ZEC' => 0.001,
                        'BTG' => 0,
                        'OMG' => 0.14026,
                        'DATA' => 20.773,
                        'QASH' => 1.9858,
                        'ETP' => 0.01,
                        'QTUM' => 0.01,
                        'EDO' => 0.95001,
                        'AVT' => 1.3045,
                        'USDT' => 0,
                        'TRX' => 28.184,
                        'ZRX' => 1.9947,
                        'RCN' => 10.793,
                        'TNB' => 31.915,
                        'SNT' => 14.976,
                        'RLC' => 1.414,
                        'GNT' => 5.8952,
                        'SPK' => 10.893,
                        'REP' => 0.041168,
                        'BAT' => 6.1546,
                        'ELF' => 1.8753,
                        'FUN' => 32.336,
                        'SNG' => 18.622,
                        'AID' => 8.08,
                        'MNA' => 16.617,
                        'NEC' => 1.6504,
                        'XTZ' => 0.2,
                    ),
                    'withdraw' => array (
                        'BTC' => 0.0004,
                        'IOTA' => 0.5,
                        'ETH' => 0.0027,
                        'BCH' => 0.0001,
                        'LTC' => 0.001,
                        'EOS' => 0.24279,
                        'XMR' => 0.04,
                        'SAN' => 0.99269,
                        'DASH' => 0.01,
                        'ETC' => 0.01,
                        'XRP' => 0.02,
                        'YYW' => 16.915,
                        'NEO' => 0,
                        'ZEC' => 0.001,
                        'BTG' => 0,
                        'OMG' => 0.14026,
                        'DATA' => 20.773,
                        'QASH' => 1.9858,
                        'ETP' => 0.01,
                        'QTUM' => 0.01,
                        'EDO' => 0.95001,
                        'AVT' => 1.3045,
                        'USDT' => 20,
                        'TRX' => 28.184,
                        'ZRX' => 1.9947,
                        'RCN' => 10.793,
                        'TNB' => 31.915,
                        'SNT' => 14.976,
                        'RLC' => 1.414,
                        'GNT' => 5.8952,
                        'SPK' => 10.893,
                        'REP' => 0.041168,
                        'BAT' => 6.1546,
                        'ELF' => 1.8753,
                        'FUN' => 32.336,
                        'SNG' => 18.622,
                        'AID' => 8.08,
                        'MNA' => 16.617,
                        'NEC' => 1.6504,
                        'XTZ' => 0.2,
                    ),
                ),
            ),
            'commonCurrencies' => array (
                'ABS' => 'ABYSS',
                'AIO' => 'AION',
                'ATM' => 'ATMI',
                'BAB' => 'BCH',
                'CTX' => 'CTXC',
                'DAD' => 'DADI',
                'DAT' => 'DATA',
                'DSH' => 'DASH',
                'HOT' => 'Hydro Protocol',
                'IOS' => 'IOST',
                'IOT' => 'IOTA',
                'IQX' => 'IQ',
                'MIT' => 'MITH',
                'MNA' => 'MANA',
                'NCA' => 'NCASH',
                'ORS' => 'ORS Group', // conflict with Origin Sport #3230
                'POY' => 'POLY',
                'QSH' => 'QASH',
                'QTM' => 'QTUM',
                'SEE' => 'SEER',
                'SNG' => 'SNGLS',
                'SPK' => 'SPANK',
                'STJ' => 'STORJ',
                'YYW' => 'YOYOW',
                'UTN' => 'UTNP',
            ),
            'exceptions' => array (
                'exact' => array (
                    'temporarily_unavailable' => '\\ccxt\\ExchangeNotAvailable', // Sorry, the service is temporarily unavailable. See https://www.bitfinex.com/ for more info.
                    'Order could not be cancelled.' => '\\ccxt\\OrderNotFound', // non-existent order
                    'No such order found.' => '\\ccxt\\OrderNotFound', // ?
                    'Order price must be positive.' => '\\ccxt\\InvalidOrder', // on price <= 0
                    'Could not find a key matching the given X-BFX-APIKEY.' => '\\ccxt\\AuthenticationError',
                    'Key price should be a decimal number, e.g. "123.456"' => '\\ccxt\\InvalidOrder', // on isNaN (price)
                    'Key amount should be a decimal number, e.g. "123.456"' => '\\ccxt\\InvalidOrder', // on isNaN (amount)
                    'ERR_RATE_LIMIT' => '\\ccxt\\DDoSProtection',
                    'Ratelimit' => '\\ccxt\\DDoSProtection',
                    'Nonce is too small.' => '\\ccxt\\InvalidNonce',
                    'No summary found.' => '\\ccxt\\ExchangeError', // fetchTradingFees (summary) endpoint can give this vague error message
                    'Cannot evaluate your available balance, please try again' => '\\ccxt\\ExchangeNotAvailable',
                ),
                'broad' => array (
                    'This API key does not have permission' => '\\ccxt\\PermissionDenied', // authenticated but not authorized
                    'Invalid order => not enough exchange balance for ' => '\\ccxt\\InsufficientFunds', // when buying cost is greater than the available quote currency
                    'Invalid order => minimum size for ' => '\\ccxt\\InvalidOrder', // when amount below limits.amount.min
                    'Invalid order' => '\\ccxt\\InvalidOrder', // ?
                    'The available balance is only' => '\\ccxt\\InsufficientFunds', // array ("status":"error","message":"Cannot withdraw 1.0027 ETH from your exchange wallet. The available balance is only 0.0 ETH. If you have limit orders, open positions, unused or active margin funding, this will decrease your available balance. To increase it, you can cancel limit orders or reduce/close your positions.","withdrawal_id":0,"fees":"0.0027")
                ),
            ),
            'precisionMode' => SIGNIFICANT_DIGITS,
            'options' => array (
                'currencyNames' => array (
                    'AGI' => 'agi',
                    'AID' => 'aid',
                    'AIO' => 'aio',
                    'ANT' => 'ant',
                    'AVT' => 'aventus', // #1811
                    'BAT' => 'bat',
                    'BCH' => 'bcash', // undocumented
                    'BCI' => 'bci',
                    'BFT' => 'bft',
                    'BTC' => 'bitcoin',
                    'BTG' => 'bgold',
                    'CFI' => 'cfi',
                    'DAI' => 'dai',
                    'DADI' => 'dad',
                    'DASH' => 'dash',
                    'DATA' => 'datacoin',
                    'DTH' => 'dth',
                    'EDO' => 'eidoo', // #1811
                    'ELF' => 'elf',
                    'EOS' => 'eos',
                    'ETC' => 'ethereumc',
                    'ETH' => 'ethereum',
                    'ETP' => 'metaverse',
                    'FUN' => 'fun',
                    'GNT' => 'golem',
                    'IOST' => 'ios',
                    'IOTA' => 'iota',
                    'LRC' => 'lrc',
                    'LTC' => 'litecoin',
                    'LYM' => 'lym',
                    'MANA' => 'mna',
                    'MIT' => 'mit',
                    'MKR' => 'mkr',
                    'MTN' => 'mtn',
                    'NEO' => 'neo',
                    'ODE' => 'ode',
                    'OMG' => 'omisego',
                    'OMNI' => 'mastercoin',
                    'QASH' => 'qash',
                    'QTUM' => 'qtum', // #1811
                    'RCN' => 'rcn',
                    'RDN' => 'rdn',
                    'REP' => 'rep',
                    'REQ' => 'req',
                    'RLC' => 'rlc',
                    'SAN' => 'santiment',
                    'SNGLS' => 'sng',
                    'SNT' => 'status',
                    'SPANK' => 'spk',
                    'STORJ' => 'stj',
                    'TNB' => 'tnb',
                    'TRX' => 'trx',
                    'USD' => 'wire',
                    'UTK' => 'utk',
                    'USDT' => 'tetheruso', // undocumented
                    'VEE' => 'vee',
                    'WAX' => 'wax',
                    'XLM' => 'xlm',
                    'XMR' => 'monero',
                    'XRP' => 'ripple',
                    'XVG' => 'xvg',
                    'YOYOW' => 'yoyow',
                    'ZEC' => 'zcash',
                    'ZRX' => 'zrx',
                    'XTZ' => 'tezos',
                ),
            ),
        ));
    }

    public function fetch_funding_fees ($params = array ()) {
        $this->load_markets();
        $response = $this->privatePostAccountFees ($params);
        $fees = $response['withdraw'];
        $withdraw = array ();
        $ids = is_array ($fees) ? array_keys ($fees) : array ();
        for ($i = 0; $i < count ($ids); $i++) {
            $id = $ids[$i];
            $code = $id;
            if (is_array ($this->currencies_by_id) && array_key_exists ($id, $this->currencies_by_id)) {
                $currency = $this->currencies_by_id[$id];
                $code = $currency['code'];
            }
            $withdraw[$code] = $this->safe_float($fees, $id);
        }
        return array (
            'info' => $response,
            'withdraw' => $withdraw,
            'deposit' => $withdraw,  // only for deposits of less than $1000
        );
    }

    public function fetch_trading_fees ($params = array ()) {
        $this->load_markets();
        $response = $this->privatePostSummary ($params);
        return array (
            'info' => $response,
            'maker' => $this->safe_float($response, 'maker_fee'),
            'taker' => $this->safe_float($response, 'taker_fee'),
        );
    }

    public function fetch_markets ($params = array ()) {
        $markets = $this->publicGetSymbolsDetails ();
        $result = array ();
        for ($p = 0; $p < count ($markets); $p++) {
            $market = $markets[$p];
            $id = strtoupper ($market['pair']);
            $baseId = mb_substr ($id, 0, 3);
            $quoteId = mb_substr ($id, 3, 6);
            $base = $this->common_currency_code($baseId);
            $quote = $this->common_currency_code($quoteId);
            $symbol = $base . '/' . $quote;
            $precision = array (
                'price' => $market['price_precision'],
                'amount' => $market['price_precision'],
            );
            $limits = array (
                'amount' => array (
                    'min' => $this->safe_float($market, 'minimum_order_size'),
                    'max' => $this->safe_float($market, 'maximum_order_size'),
                ),
                'price' => array (
                    'min' => pow (10, -$precision['price']),
                    'max' => pow (10, $precision['price']),
                ),
            );
            $limits['cost'] = array (
                'min' => $limits['amount']['min'] * $limits['price']['min'],
                'max' => null,
            );
            $result[] = array (
                'id' => $id,
                'symbol' => $symbol,
                'base' => $base,
                'quote' => $quote,
                'baseId' => $baseId,
                'quoteId' => $quoteId,
                'active' => true,
                'precision' => $precision,
                'limits' => $limits,
                'info' => $market,
            );
        }
        return $result;
    }

    public function calculate_fee ($symbol, $type, $side, $amount, $price, $takerOrMaker = 'taker', $params = array ()) {
        $market = $this->markets[$symbol];
        $rate = $market[$takerOrMaker];
        $cost = $amount * $rate;
        $key = 'quote';
        if ($side === 'sell') {
            $cost *= $price;
        } else {
            $key = 'base';
        }
        return array (
            'type' => $takerOrMaker,
            'currency' => $market[$key],
            'rate' => $rate,
            'cost' => floatval ($this->currency_to_precision($market[$key], $cost)),
        );
    }

    public function fetch_balance ($params = array ()) {
        $this->load_markets();
        $balanceType = $this->safe_string($params, 'type', 'exchange');
        $query = $this->omit ($params, 'type');
        $balances = $this->privatePostBalances ($query);
        $result = array ( 'info' => $balances );
        for ($i = 0; $i < count ($balances); $i++) {
            $balance = $balances[$i];
            if ($balance['type'] === $balanceType) {
                $currency = $balance['currency'];
                $uppercase = strtoupper ($currency);
                $uppercase = $this->common_currency_code($uppercase);
                $account = $this->account ();
                $account['free'] = floatval ($balance['available']);
                $account['total'] = floatval ($balance['amount']);
                $account['used'] = $account['total'] - $account['free'];
                $result[$uppercase] = $account;
            }
        }
        return $this->parse_balance($result);
    }

    public function fetch_order_book ($symbol, $limit = null, $params = array ()) {
        $this->load_markets();
        $request = array (
            'symbol' => $this->market_id($symbol),
        );
        if ($limit !== null) {
            $request['limit_bids'] = $limit;
            $request['limit_asks'] = $limit;
        }
        $orderbook = $this->publicGetBookSymbol (array_merge ($request, $params));
        return $this->parse_order_book($orderbook, null, 'bids', 'asks', 'price', 'amount');
    }

    public function fetch_tickers ($symbols = null, $params = array ()) {
        $this->load_markets();
        $tickers = $this->publicGetTickers ($params);
        $result = array ();
        for ($i = 0; $i < count ($tickers); $i++) {
            $ticker = $this->parse_ticker($tickers[$i]);
            $symbol = $ticker['symbol'];
            $result[$symbol] = $ticker;
        }
        return $result;
    }

    public function fetch_ticker ($symbol, $params = array ()) {
        $this->load_markets();
        $market = $this->market ($symbol);
        $ticker = $this->publicGetPubtickerSymbol (array_merge (array (
            'symbol' => $market['id'],
        ), $params));
        return $this->parse_ticker($ticker, $market);
    }

    public function parse_ticker ($ticker, $market = null) {
        $timestamp = $this->safe_float($ticker, 'timestamp') * 1000;
        $symbol = null;
        if ($market !== null) {
            $symbol = $market['symbol'];
        } else if (is_array ($ticker) && array_key_exists ('pair', $ticker)) {
            $id = $ticker['pair'];
            if (is_array ($this->markets_by_id) && array_key_exists ($id, $this->markets_by_id))
                $market = $this->markets_by_id[$id];
            if ($market !== null) {
                $symbol = $market['symbol'];
            } else {
                $baseId = mb_substr ($id, 0, 3);
                $quoteId = mb_substr ($id, 3, 6);
                $base = $this->common_currency_code($baseId);
                $quote = $this->common_currency_code($quoteId);
                $symbol = $base . '/' . $quote;
            }
        }
        $last = $this->safe_float($ticker, 'last_price');
        return array (
            'symbol' => $symbol,
            'timestamp' => $timestamp,
            'datetime' => $this->iso8601 ($timestamp),
            'high' => $this->safe_float($ticker, 'high'),
            'low' => $this->safe_float($ticker, 'low'),
            'bid' => $this->safe_float($ticker, 'bid'),
            'bidVolume' => null,
            'ask' => $this->safe_float($ticker, 'ask'),
            'askVolume' => null,
            'vwap' => null,
            'open' => null,
            'close' => $last,
            'last' => $last,
            'previousClose' => null,
            'change' => null,
            'percentage' => null,
            'average' => $this->safe_float($ticker, 'mid'),
            'baseVolume' => $this->safe_float($ticker, 'volume'),
            'quoteVolume' => null,
            'info' => $ticker,
        );
    }

    public function parse_trade ($trade, $market) {
        $timestamp = intval (floatval ($trade['timestamp'])) * 1000;
        $side = strtolower ($trade['type']);
        $orderId = $this->safe_string($trade, 'order_id');
        $price = $this->safe_float($trade, 'price');
        $amount = $this->safe_float($trade, 'amount');
        $cost = $price * $amount;
        $fee = null;
        if (is_array ($trade) && array_key_exists ('fee_amount', $trade)) {
            $feeCost = -$this->safe_float($trade, 'fee_amount');
            $feeCurrency = $this->safe_string($trade, 'fee_currency');
            if (is_array ($this->currencies_by_id) && array_key_exists ($feeCurrency, $this->currencies_by_id))
                $feeCurrency = $this->currencies_by_id[$feeCurrency]['code'];
            $fee = array (
                'cost' => $feeCost,
                'currency' => $feeCurrency,
            );
        }
        return array (
            'id' => (string) $trade['tid'],
            'info' => $trade,
            'timestamp' => $timestamp,
            'datetime' => $this->iso8601 ($timestamp),
            'symbol' => $market['symbol'],
            'type' => null,
            'order' => $orderId,
            'side' => $side,
            'price' => $price,
            'amount' => $amount,
            'cost' => $cost,
            'fee' => $fee,
        );
    }

    public function fetch_trades ($symbol, $since = null, $limit = 50, $params = array ()) {
        $this->load_markets();
        $market = $this->market ($symbol);
        $request = array (
            'symbol' => $market['id'],
            'limit_trades' => $limit,
        );
        if ($since !== null)
            $request['timestamp'] = intval ($since / 1000);
        $response = $this->publicGetTradesSymbol (array_merge ($request, $params));
        return $this->parse_trades($response, $market, $since, $limit);
    }

    public function fetch_my_trades ($symbol = null, $since = null, $limit = null, $params = array ()) {
        if ($symbol === null)
            throw new ArgumentsRequired ($this->id . ' fetchMyTrades requires a $symbol argument');
        $this->load_markets();
        $market = $this->market ($symbol);
        $request = array ( 'symbol' => $market['id'] );
        if ($limit !== null)
            $request['limit_trades'] = $limit;
        if ($since !== null)
            $request['timestamp'] = intval ($since / 1000);
        $response = $this->privatePostMytrades (array_merge ($request, $params));
        return $this->parse_trades($response, $market, $since, $limit);
    }

    public function create_order ($symbol, $type, $side, $amount, $price = null, $params = array ()) {
        $this->load_markets();
        $orderType = $type;
        if (($type === 'limit') || ($type === 'market'))
            $orderType = 'exchange ' . $type;
        $amount = $this->amount_to_precision($symbol, $amount);
        $order = array (
            'symbol' => $this->market_id($symbol),
            'amount' => $amount,
            'side' => $side,
            'type' => $orderType,
            'ocoorder' => false,
            'buy_price_oco' => 0,
            'sell_price_oco' => 0,
        );
        if ($type === 'market') {
            $order['price'] = (string) $this->nonce ();
        } else {
            $order['price'] = $this->price_to_precision($symbol, $price);
        }
        $result = $this->privatePostOrderNew (array_merge ($order, $params));
        return $this->parse_order($result);
    }

    public function cancel_order ($id, $symbol = null, $params = array ()) {
        $this->load_markets();
        return $this->privatePostOrderCancel (array ( 'order_id' => intval ($id) ));
    }

    public function parse_order ($order, $market = null) {
        $side = $order['side'];
        $open = $order['is_live'];
        $canceled = $order['is_cancelled'];
        $status = null;
        if ($open) {
            $status = 'open';
        } else if ($canceled) {
            $status = 'canceled';
        } else {
            $status = 'closed';
        }
        $symbol = null;
        if ($market === null) {
            $exchange = strtoupper ($order['symbol']);
            if (is_array ($this->markets_by_id) && array_key_exists ($exchange, $this->markets_by_id)) {
                $market = $this->markets_by_id[$exchange];
            }
        }
        if ($market !== null)
            $symbol = $market['symbol'];
        $orderType = $order['type'];
        $exchange = mb_strpos ($orderType, 'exchange ') !== false;
        if ($exchange) {
            $parts = explode (' ', $order['type']);
            $orderType = $parts[1];
        }
        $timestamp = intval (floatval ($order['timestamp']) * 1000);
        $result = array (
            'info' => $order,
            'id' => (string) $order['id'],
            'timestamp' => $timestamp,
            'datetime' => $this->iso8601 ($timestamp),
            'lastTradeTimestamp' => null,
            'symbol' => $symbol,
            'type' => $orderType,
            'side' => $side,
            'price' => $this->safe_float($order, 'price'),
            'average' => $this->safe_float($order, 'avg_execution_price'),
            'amount' => $this->safe_float($order, 'original_amount'),
            'remaining' => $this->safe_float($order, 'remaining_amount'),
            'filled' => $this->safe_float($order, 'executed_amount'),
            'status' => $status,
            'fee' => null,
        );
        return $result;
    }

    public function fetch_open_orders ($symbol = null, $since = null, $limit = null, $params = array ()) {
        $this->load_markets();
        if ($symbol !== null)
            if (!(is_array ($this->markets) && array_key_exists ($symbol, $this->markets)))
                throw new ExchangeError ($this->id . ' has no $symbol ' . $symbol);
        $response = $this->privatePostOrders ($params);
        $orders = $this->parse_orders($response, null, $since, $limit);
        if ($symbol !== null)
            $orders = $this->filter_by($orders, 'symbol', $symbol);
        return $orders;
    }

    public function fetch_closed_orders ($symbol = null, $since = null, $limit = null, $params = array ()) {
        $this->load_markets();
        $request = array ();
        if ($limit !== null)
            $request['limit'] = $limit;
        $response = $this->privatePostOrdersHist (array_merge ($request, $params));
        $orders = $this->parse_orders($response, null, $since, $limit);
        if ($symbol !== null)
            $orders = $this->filter_by($orders, 'symbol', $symbol);
        $orders = $this->filter_by($orders, 'status', 'closed');
        return $orders;
    }

    public function fetch_order ($id, $symbol = null, $params = array ()) {
        $this->load_markets();
        $response = $this->privatePostOrderStatus (array_merge (array (
            'order_id' => intval ($id),
        ), $params));
        return $this->parse_order($response);
    }

    public function parse_ohlcv ($ohlcv, $market = null, $timeframe = '1m', $since = null, $limit = null) {
        return [
            $ohlcv[0],
            $ohlcv[1],
            $ohlcv[3],
            $ohlcv[4],
            $ohlcv[2],
            $ohlcv[5],
        ];
    }

    public function fetch_ohlcv ($symbol, $timeframe = '1m', $since = null, $limit = null, $params = array ()) {
        $this->load_markets();
        if ($limit === null)
            $limit = 100;
        $market = $this->market ($symbol);
        $v2id = 't' . $market['id'];
        $request = array (
            'symbol' => $v2id,
            'timeframe' => $this->timeframes[$timeframe],
            'sort' => 1,
            'limit' => $limit,
        );
        if ($since !== null)
            $request['start'] = $since;
        $response = $this->v2GetCandlesTradeTimeframeSymbolHist (array_merge ($request, $params));
        return $this->parse_ohlcvs($response, $market, $timeframe, $since, $limit);
    }

    public function get_currency_name ($code) {
        if (is_array ($this->options['currencyNames']) && array_key_exists ($code, $this->options['currencyNames']))
            return $this->options['currencyNames'][$code];
        throw new NotSupported ($this->id . ' ' . $code . ' not supported for withdrawal');
    }

    public function create_deposit_address ($code, $params = array ()) {
        $response = $this->fetch_deposit_address ($code, array_merge (array (
            'renew' => 1,
        ), $params));
        $address = $this->safe_string($response, 'address');
        $this->check_address($address);
        return array (
            'info' => $response['info'],
            'currency' => $code,
            'address' => $address,
            'tag' => null,
        );
    }

    public function fetch_deposit_address ($code, $params = array ()) {
        $name = $this->get_currency_name ($code);
        $request = array (
            'method' => $name,
            'wallet_name' => 'exchange',
            'renew' => 0, // a value of 1 will generate a new $address
        );
        $response = $this->privatePostDepositNew (array_merge ($request, $params));
        $address = $response['address'];
        $tag = null;
        if (is_array ($response) && array_key_exists ('address_pool', $response)) {
            $tag = $address;
            $address = $response['address_pool'];
        }
        $this->check_address($address);
        return array (
            'currency' => $code,
            'address' => $address,
            'tag' => $tag,
            'info' => $response,
        );
    }

    public function fetch_transactions ($code = null, $since = null, $limit = null, $params = array ()) {
        if ($code === null) {
            throw new ArgumentsRequired ($this->id . ' fetchTransactions() requires a $currency $code argument');
        }
        $this->load_markets();
        $currency = $this->currency ($code);
        $request = array (
            'currency' => $currency['id'],
        );
        if ($since !== null) {
            $request['since'] = intval ($since / 1000);
        }
        $response = $this->privatePostHistoryMovements (array_merge ($request, $params));
        //
        //     array (
        //         {
        //             "id":581183,
        //             "txid" => 123456,
        //             "$currency":"BTC",
        //             "method":"BITCOIN",
        //             "type":"WITHDRAWAL",
        //             "amount":".01",
        //             "description":"3QXYWgRGX2BPYBpUDBssGbeWEa5zq6snBZ, offchain transfer ",
        //             "address":"3QXYWgRGX2BPYBpUDBssGbeWEa5zq6snBZ",
        //             "status":"COMPLETED",
        //             "timestamp":"1443833327.0",
        //             "timestamp_created" => "1443833327.1",
        //             "fee" => 0.1,
        //         }
        //     )
        //
        return $this->parseTransactions ($response, $currency, $since, $limit);
    }

    public function parse_transaction ($transaction, $currency = null) {
        $timestamp = $this->safe_float($transaction, 'timestamp_created');
        if ($timestamp !== null) {
            $timestamp = intval ($timestamp * 1000);
        }
        $updated = $this->safe_float($transaction, 'timestamp');
        if ($updated !== null) {
            $updated = intval ($updated * 1000);
        }
        $code = null;
        if ($currency === null) {
            $currencyId = $this->safe_string($transaction, 'currency');
            if (is_array ($this->currencies_by_id) && array_key_exists ($currencyId, $this->currencies_by_id)) {
                $currency = $this->currencies_by_id[$currencyId];
            } else {
                $code = $this->common_currency_code($currencyId);
            }
        }
        if ($currency !== null) {
            $code = $currency['code'];
        }
        $type = $this->safe_string($transaction, 'type'); // DEPOSIT or WITHDRAWAL
        if ($type !== null) {
            $type = strtolower ($type);
        }
        $status = $this->parse_transaction_status ($this->safe_string($transaction, 'status'));
        $feeCost = $this->safe_float($transaction, 'fee');
        if ($feeCost !== null) {
            $feeCost = abs ($feeCost);
        }
        return array (
            'info' => $transaction,
            'id' => $this->safe_string($transaction, 'id'),
            'txid' => $this->safe_string($transaction, 'txid'),
            'timestamp' => $timestamp,
            'datetime' => $this->iso8601 ($timestamp),
            'address' => $this->safe_string($transaction, 'address'),
            'tag' => null, // refix it properly for the tag from description
            'type' => $type,
            'amount' => $this->safe_float($transaction, 'amount'),
            'currency' => $code,
            'status' => $status,
            'updated' => $updated,
            'fee' => array (
                'currency' => $code,
                'cost' => $feeCost,
                'rate' => null,
            ),
        );
    }

    public function parse_transaction_status ($status) {
        $statuses = array (
            'CANCELED' => 'canceled',
            'ZEROCONFIRMED' => 'failed', // ZEROCONFIRMED happens e.g. in a double spend attempt (I had one in my movements!)
            'COMPLETED' => 'ok',
        );
        return (is_array ($statuses) && array_key_exists ($status, $statuses)) ? $statuses[$status] : $status;
    }

    public function withdraw ($code, $amount, $address, $tag = null, $params = array ()) {
        $this->check_address($address);
        $name = $this->get_currency_name ($code);
        $request = array (
            'withdraw_type' => $name,
            'walletselected' => 'exchange',
            'amount' => (string) $amount,
            'address' => $address,
        );
        if ($tag)
            $request['payment_id'] = $tag;
        $responses = $this->privatePostWithdraw (array_merge ($request, $params));
        $response = $responses[0];
        $id = $response['withdrawal_id'];
        $message = $response['message'];
        $errorMessage = $this->findBroadlyMatchedKey ($this->exceptions['broad'], $message);
        if ($id === 0) {
            if ($errorMessage !== null) {
                $ExceptionClass = $this->exceptions['broad'][$errorMessage];
                throw new $ExceptionClass ($this->id . ' ' . $message);
            }
            throw new ExchangeError ($this->id . ' withdraw returned an $id of zero => ' . $this->json ($response));
        }
        return array (
            'info' => $response,
            'id' => $id,
        );
    }

    public function nonce () {
        return $this->milliseconds ();
    }

    public function sign ($path, $api = 'public', $method = 'GET', $params = array (), $headers = null, $body = null) {
        $request = '/' . $this->implode_params($path, $params);
        if ($api === 'v2') {
            $request = '/' . $api . $request;
        } else {
            $request = '/' . $this->version . $request;
        }
        $query = $this->omit ($params, $this->extract_params($path));
        $url = $this->urls['api'] . $request;
        if (($api === 'public') || (mb_strpos ($path, '/hist') !== false)) {
            if ($query) {
                $suffix = '?' . $this->urlencode ($query);
                $url .= $suffix;
                $request .= $suffix;
            }
        }
        if ($api === 'private') {
            $this->check_required_credentials();
            $nonce = $this->nonce ();
            $query = array_merge (array (
                'nonce' => (string) $nonce,
                'request' => $request,
            ), $query);
            $query = $this->json ($query);
            $query = $this->encode ($query);
            $payload = base64_encode ($query);
            $secret = $this->encode ($this->secret);
            $signature = $this->hmac ($payload, $secret, 'sha384');
            $headers = array (
                'X-BFX-APIKEY' => $this->apiKey,
                'X-BFX-PAYLOAD' => $this->decode ($payload),
                'X-BFX-SIGNATURE' => $signature,
            );
        }
        return array ( 'url' => $url, 'method' => $method, 'body' => $body, 'headers' => $headers );
    }

    public function handle_errors ($code, $reason, $url, $method, $headers, $body, $response) {
        if (strlen ($body) < 2)
            return;
        if ($code >= 400) {
            if ($body[0] === '{') {
                $feedback = $this->id . ' ' . $this->json ($response);
                $message = null;
                if (is_array ($response) && array_key_exists ('message', $response)) {
                    $message = $response['message'];
                } else if (is_array ($response) && array_key_exists ('error', $response)) {
                    $message = $response['error'];
                } else {
                    throw new ExchangeError ($feedback); // malformed (to our knowledge) $response
                }
                $exact = $this->exceptions['exact'];
                if (is_array ($exact) && array_key_exists ($message, $exact)) {
                    throw new $exact[$message] ($feedback);
                }
                $broad = $this->exceptions['broad'];
                $broadKey = $this->findBroadlyMatchedKey ($broad, $message);
                if ($broadKey !== null) {
                    throw new $broad[$broadKey] ($feedback);
                }
                throw new ExchangeError ($feedback); // unknown $message
            }
        }
    }
}
