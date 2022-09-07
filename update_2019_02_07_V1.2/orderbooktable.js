$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


$(document).ready(function() {
    $('.orderbookList').DataTable( {
        "searching":      false,
        "info":           false,
        "ordering":       false,
        "scrollY":        "200px",
        "scrollCollapse": true,
        "paging":         false
    } );

    var exchangeSets, exchangeItemsString = "", initialBaseSets, initialBaseString = "", initialQuoteSets, initialQuoteString = "";
    var baseSets, baseString = "", quoteSets, quoteString = "";
    var inputMoney  = 1000;
    var firstExchangeObj;
    var realFlag = false;
    var finalPrice = 1000;

    getExchangeSets();

    getBaseCurrency(1, function(){
        getQuoteCurrency(1, initialBaseSets[0]['name']);
    });

    function getQuoteCurrency(exchange_id, baseCurrency, callback='0'){

        // console.log("exchange_id=", exchange_id);
        // console.log("baseCurrency", baseCurrency);

        $.ajax({
            url: "../getQuoteCurrency",
            type: "POST",
            data: {exchange_id:exchange_id, baseCurrency:baseCurrency},
            success: function(res){
                res             = JSON.parse(res);
                // console.log("ok");
                // console.log(res);

                length              = res.length;

                quoteSets           = res;
                quoteString         = "";
                for(i=0; i<length; i++){
                    quoteString += "<option value='" + res[i] + "'>" +
                                res[i] + "</option>";
                }

                if(initialQuoteString == ""){
                    initialQuoteString  = quoteString;
                    initialQuoteSets    = quoteSets;
                }
                if(callback!='0')callback();
            }
        });

    }

    function getBaseCurrency(exchange_id, callback='0'){
        $.ajax({
            url: "../getBaseCurrency",
            type: "POST",
            data: {exchange_id:exchange_id},
            success: function(res){
                res             = JSON.parse(res);
                // console.log("middle testing", res);

                length          = res.length;
                baseSets        = res;
                baseString      = "";
                for(i=0; i<length; i++){
                    baseString += "<option value='" + res[i]['name'] + "'>" +
                                    res[i]['name'] + "</option>";
                }

                if(initialBaseString == ""){
                    initialBaseSets     = baseSets;
                    initialBaseString   = baseString;
                }
                if(callback!='0')callback();
            }
        });
    }

    function getExchangeSets(){
        $.ajax({
            url: "../getExchangeSets",
            type: "POST",
            success: function(res){
                res         = JSON.parse(res);
                // console.log(res);
                length      = res.length;

                exchangeSets = res;

                for(i=0; i<length; i++){
                    exchangeItemsString += "<option value='" + exchangeSets[i]['exchange_id'] + "," + exchangeSets[i]['exchange_name'] + "'>" +
                                            exchangeSets[i]['exchange_name'] + "</option>";
                }

            }

        })
    }


    $("#exchangeAddBtn").click(function(){
        var html = "";
        var stepNumber  = 1;
        var positionStr = "";
        var sellTypeValue = 0;
        var initialBase = "";
        var sellTitle   = "Selling";
        var sellTitleStyle  = "red";

        if($.trim($("#exchanges").html())==""){
            stepNumber  = 1;
            positionStr = '<input type="text" name="position" id="position" value="1000" style="width: 103px;height: 20px;">';
        }else{
            var stepNumberObj = $("#exchanges input.stepNumber:last");
            var lastStep      = stepNumberObj.val();
            stepNumber        = parseInt(lastStep) + 1;

            sellTypeObj       = $("select.sellType:last");
            sellTypeValue     = parseInt(sellTypeObj.val());
            sellTypeValue     = (sellTypeValue + 1)%2;

            if(sellTypeValue == 1){
                sellTitle       = "Buying";
                sellTitleStyle  = "green";
            }

            initialBase       = $("select.quoteCurrency").val();

            positionStr = "";
        }

        html = '<div class="exchangeOrderbook">' +
                    '<input type="hidden" class="stepNumber" value="' + stepNumber + '">' +
                    '<button type="button" class="btn btn-warning btn-circle btn-lg exchangeRemoveBtn"><i class="glyphicon glyphicon-remove"></i></button>' +
                    '<div class="exchangeArea">' +
                        '<table class="exchangeSelector">' +
                            '<tr>' +
                                '<td class="stepField">Step' + ' ' + stepNumber + '</td>' +
                                '<td colspan="2">' +
                                '</td>' +
                            '</tr>' +

                            '<tr>' +
                                '<td>Exchange:</td>' +
                                '<td colspan="2">' +
                                    '<select class="exchangeItems">' +
                                        exchangeItemsString +
                                    '</select>' +
                                '</td>' +
                            '</tr>' +

                            '<tr>' +
                                '<td>Action:</td>' +
                                '<td style="width:100px;">' +
                                    '<select class="sellType">' +
                                        '<option value="0">Buy with</option>' +
                                        '<option value="1">Sell</option>' +
                                    '</select>' +
                                '</td>' +
                                '<td>to</td>' +
                            '</tr>' +

                            '<tr>' +
                                '<td>Asset:</td>' +
                                '<td style="width:100px;">' +
                                    '<select class="baseCurrency">' +
                                        initialBaseString +
                                    '</select>' +
                                '</td>' +
                                '<td style="width:100px;">' +
                                    '<select class="quoteCurrency">' +
                                        initialQuoteString +
                                    '</select>' +
                                '</td>' +
                            '</tr>' +

                            '<tr>' +
                                '<td>PositionSize:</td>' +
                                '<td>' + positionStr + '</td>' +
                                '<td></td>' +
                            '</tr>' +

                            '<tr>' +
                                '<td>Price:</td>' +
                                '<td colspan="2"></td>' +
                            '</tr>' +

                            '<tr>' +
                                '<td>Order Type:</td>' +
                                '<td colspan="2">' +
                                    '<select class="orderType">' +
                                        '<option>Market Order</option>' +
                                    '</select>' +
                                '</td>' +
                            '</tr>' +
                        '</table>' +
                        '<button class="runBtn">Run</button>' +
                    '</div>' +

                    '<div class="orderbookArea">' +
                        '<div class="orderbookTitle">Order Book</div>' +
                        '<div class="orderbookType" style="color:red;">Selling</div>' +

                        '<table class="orderbookList">' +
                            '<thead style="width: 100%; display: table; text-align:center;">' +
                                '<th style="width:30%; text-align: center;">Price</th>' +
                                '<th style="width:40%; text-align: center;">Amount</th>' +
                                '<th style="width:30%; text-align: center;">Total:</th>' +
                            '</thead>' +

                            '<tbody class="orderbookContent" style="height: 200px; overflow-y: overlay; overflow-x: hidden; display: block; width:100%;">' +

                            '</tbody>' +
                            '<tfoot></tfoot>' +
                        '</table>' +
                    '</div>' +
                '</div>';

        $("#exchanges").append(html);


        $('.baseCurrency').select2();
        $('.quoteCurrency').select2();
        $('.exchangeItems').select2();
        var exchange        = $("#exchanges select.exchangeItems:last").val();
        var baseCurrency    = $("#exchanges select.baseCurrency:last").val();
        var quoteCurrency   = $("#exchanges select.quoteCurrency:last").val();
        var sellType        = $("#exchanges select.sellType:last").val();
        var orderbookObj    = $("#exchanges tbody.orderbookContent:last");

        if(stepNumber!=1){
            console.log("SellTypeValue>>>>>>", sellTypeValue);
            console.log("initialBase>>>>>>", initialBase);

            $("#exchanges select.sellType:last").val(sellTypeValue);
            // $(".baseCurrency:last").val(initialBase);

            $("div.orderbookType:last").html(sellTitle);
            $("div.orderbookType:last").css("color", sellTitleStyle);
        }


        if(sellType == 0)
            sellType = "bids";
        else
            sellType = "asks";
        dataset             = {exchange:exchange, baseCurrency:baseCurrency, quoteCurrency:quoteCurrency, sellType:sellType};

        // getOrderbook(sellType, dataset, orderbookObj);
        // getTicker(sellType, dataset, tickerObj);
    });


    $(document).on("change", ".sellType", function(){
        // console.log("change");

        var item        = $(this);
        var text        = "Buying";
        var color       = "green";
        var headText    = "Bid";

        if(item.val() == 1){
            text        = "Buying";
            color       = "green";
            headText    = "Bid";
        }else if(item.val() == 0){
            text        = "Selling";
            color       = "red";
            headText    = "Ask";
        }else{

        }
        var parent          = item.parent().parent().parent().parent().parent();
        var orderbookType   = (parent.next()).find('.orderbookType');

        orderbookType.html(text);
        orderbookType.css("color", color);

        parent.parent().find('.orderbookArea .orderbookList thead tr th:nth-child(2)').html(headText);
    });


    $(document).on("click", ".exchangeRemoveBtn", function(){
        var item            = $(this);
        var exchangeBlock   = item.parent();
        var temp            = exchangeBlock;
        var lastStep        = $("#exchanges .stepNumber:last").val();
        var curStep         = exchangeBlock.find('.stepNumber').val();

        if(curStep == 1)firstExchangeObj = exchangeBlock.next().find('.exchangeArea');

        if(curStep < lastStep){
            while(exchangeBlock = exchangeBlock.next()){
                curStepObj      = exchangeBlock.find('.stepNumber');
                var curStep     = curStepObj.val();
                var newStep     = curStep - 1;
                curStepObj.val(newStep);

                var stepField   = exchangeBlock.find('.stepField');
                stepField.html("Step " + newStep);
                if(curStep == lastStep)break;
            }
        }

        temp.remove();
    });


    $(document).on("change", ".quoteCurrency, .sellType", function(){
        var parent          = $(this).closest('.exchangeArea');

        var exchange        = parent.find("select.exchangeItems").val();
        var baseCurrency    = parent.find("select.baseCurrency").val();
        var quoteCurrency   = parent.find("select.quoteCurrency").val();
        var sellType        = parent.find("select.sellType").val();
        var orderbookObj    = parent.next().find("tbody.orderbookContent");
        var tickerObj       = parent.find(".exchangeSelector tbody");

        dataset = {exchange:exchange, baseCurrency:baseCurrency, quoteCurrency:quoteCurrency, sellType:sellType};
        if(sellType == 0)
            sellType = "bids";
        else
            sellType = "asks";
        // console.log(dataset);

        // getOrderbook(sellType, dataset, orderbookObj);
        // getTicker(sellType, dataset, tickerObj, function(){
        //     checkProfit(parent);
        // });
    });


    $(document).on("change", ".exchangeItems", function(){
        var parent          = $(this).closest('.exchangeArea');
        var exchange        = $(this).val();
        var exchange_id     = (exchange.split(','))[0];
        var orderbookObj    = parent.next().find("tbody.orderbookContent");
        var tickerObj       = parent.find(".exchangeSelector tbody");
        getBaseCurrency(exchange_id, function(){
            var baseCurrencyObj     = parent.find("select.baseCurrency");
            baseCurrencyObj.html(baseString);
            var baseCurrency        = baseCurrencyObj.val();

            getQuoteCurrency(exchange_id, baseSets[0]['name'], function(){
                var quoteCurrencyObj   = parent.find("select.quoteCurrency");
                quoteCurrencyObj.html(quoteString);
                var quoteCurrency   = quoteCurrencyObj.val();
                var sellType        = parent.find("select.sellType").val();

                dataset = {exchange:exchange, baseCurrency:baseCurrency, quoteCurrency:quoteCurrency, sellType:sellType};
                if(sellType == 0)
                    sellType = "bids";
                else
                    sellType = "asks";

                // getOrderbook(sellType, dataset, orderbookObj);
                // getTicker(sellType, dataset, tickerObj, function(){
                //     checkProfit(parent);
                // });
            });


        })
    });


    $(document).on("change", ".baseCurrency", function(){
        var parent          = $(this).closest('.exchangeArea');

        var exchange        = parent.find("select.exchangeItems").val();
        var baseCurrency    = $(this).val();
        var quoteCurrencyObj= parent.find("select.quoteCurrency");
        var quoteCurrency   = quoteCurrencyObj.val();
        var sellType        = parent.find("select.sellType").val();
        var orderbookObj    = parent.next().find("tbody.orderbookContent");
        var tickerObj       = parent.find(".exchangeSelector tbody");

        exchange_id         = (exchange.split(','))[0];
        getQuoteCurrency(exchange_id, baseCurrency, function(){

            quoteCurrencyObj.html(quoteString);
            quoteCurrency   = quoteCurrencyObj.val();
            dataset = {exchange:exchange, baseCurrency:baseCurrency, quoteCurrency:quoteCurrency, sellType:sellType};

            if(sellType == 0)
                sellType = "bids";
            else
                sellType = "asks";

            // getOrderbook(sellType, dataset, orderbookObj);
            // getTicker(sellType, dataset, tickerObj, function(){
            //     checkProfit(parent);
            // });
        });
    });


    $(document).on("click", ".runBtn", function(){
        runClickFunc($(this));
    });


    function runClickFunc(elementObj, callback=''){
        console.log("Run Button Clikced!");

        var parent          = elementObj.closest('.exchangeArea');
        var exchange        = parent.find("select.exchangeItems").val();
        var baseCurrency    = parent.find("select.baseCurrency").val();
        var quoteCurrency   = parent.find("select.quoteCurrency").val();
        var sellType        = parent.find("select.sellType").val();
        var orderbookObj    = parent.next().find("tbody.orderbookContent");
        var tickerObj       = parent.find(".exchangeSelector tbody");

        dataset = {exchange:exchange, baseCurrency:baseCurrency, quoteCurrency:quoteCurrency, sellType:sellType};
        if(sellType == 0)
            sellType = "asks";
        else
            sellType = "bids";
        // console.log(dataset);

        if(callback == ''){
            getOrderbook(sellType, dataset, orderbookObj, parent);
        }
        else{
            getOrderbook(sellType, dataset, orderbookObj, parent, function(){
                callback();
            });
        }
        // getTicker(sellType, dataset, tickerObj, function(){
        //     checkProfit(parent);
        // });
    }

    $("#runReal").click(function(){
        actionType  = $("#runReal").html();
        if(actionType == "Real Time"){
            realFlag    = true;
            $("#runReal").html("Real Stop");
            setTimeout(refreshExchange, 1000);
        }else{
            $("#runReal").html("Real Time");
            realFlag    = false;
        }
    });


    $("#runAllBtn").click(function(){
        $(".exchangeOrderbook").each(function(){
            var runBtn          = $(this).find('.runBtn');
            runClickFunc(runBtn);
        });
    });

    function runAll(callback = ''){
        var num = $(".exchangeOrderbook").size();

        $(".exchangeOrderbook").each(function(){
            var runBtn          = $(this).find('.runBtn');
            if(callback == ''){
                runClickFunc(runBtn);
            }
            else{
                runClickFunc(runBtn, function(){
                    num--;
                    if(num == 0)callback();
                })
            }
        });
    }

    function refreshExchange(){
        if(realFlag == false)return;
        var parent              = $("#exchanges");
        var current             = parent.first('.exchangeOrderbook');
        var length              = parent.find('.exchangeOrderbook').length;

        if(length != 0){
            if(realFlag == true){
                runAll(function(){
                    setTimeout(refreshExchange, 1000);
                })

            }
        }else{
            if(realFlag == true)setTimeout(refreshExchange, 1000);
        }
    }



    // setTimeout(refreshArea, 2000);
    function refreshArea() {
        if(realFlag == false)return;
        var parent              = $("#exchanges");
        var current             = parent.first('.exchangeOrderbook');
        var length              = parent.find('.exchangeOrderbook').length;

        //check the exist any exchanges
        if(length != 0){
            refreshForm(current, length, function(){
                // console.log("refresh");
                if(realFlag == true)setTimeout(refreshArea, 20000);
            });
        }else{
            if(realFlag == true)setTimeout(refreshArea, 1000);
        }
    }

    function refreshForm(current, length, callback){
        // console.log("this is refresh area");
        var exchange        = current.find(".exchangeItems").val();
        var baseCurrency    = current.find(".baseCurrency").val();
        var quoteCurrencyObj= current.find(".quoteCurrency");
        var quoteCurrency   = quoteCurrencyObj.val();
        var sellType        = current.find(".sellType").val();
        var orderbookObj    = current.find(".orderbookContent");
        var tickerObj       = current.find(".exchangeSelector tbody");
        dataset = {exchange:exchange, baseCurrency:baseCurrency, quoteCurrency:quoteCurrency, sellType:sellType};

        if(sellType == 0)
            sellType = "bids";
        else
            sellType = "asks";

        refreshProcess();

        async function refreshProcess(){

            for(i=0;i<length;i++){
                await refreshRun(sellType, dataset, orderbookObj, tickerObj, current, function(){
                    current         = current.next();

                    exchange        = current.find(".exchangeItems").val();
                    baseCurrency    = current.find(".baseCurrency").val();
                    quoteCurrencyObj= current.find(".quoteCurrency");
                    quoteCurrency   = quoteCurrencyObj.val();
                    sellType        = current.find(".sellType").val();
                    orderbookObj    = current.find(".orderbookContent");
                    tickerObj       = current.find(".exchangeSelector tbody");
                    dataset = {exchange:exchange, baseCurrency:baseCurrency, quoteCurrency:quoteCurrency, sellType:sellType};

                    if(sellType == 0)
                        sellType = "bids";
                    else
                        sellType = "asks";
                    // console.log(sellType);
                });
            }
        }
        callback();
    }

    function refreshRun(sellType, dataset, orderbookObj, tickerObj, current, callback){

        parent  = orderbookObj.parent().parent().prev();

        getOrderbook(sellType, dataset, orderbookObj, parent, function(){
            callback();
        });
        // getTicker(sellType, dataset, tickerObj, function(){
        //     exchangeArea    = current.find('.exchangeArea');
        //     // console.log("this is exchange area!");
        //     // console.log(exchangeArea);
        //     callback();
        //     // checkProfit(exchangeArea);
        // });
    }

    function getOrderbook(sellType, dataset, orderbookObj, parent, callback='0'){
        // console.log(sellType, dataset);
        var baseCurrency, quoteCurrency, positionBase, positionQuote, orgbaseCurrency;
        var tickerObj, assetpair;




        $.ajax({
            url: "../getOrderBook",
            type: "POST",
            data: dataset,
            success: function(ret){

                orgbaseCurrency         = dataset['baseCurrency'];
                tickerObj = orderbookObj.parent().parent().prev().find(".exchangeSelector tbody");
                var prevOrderbookArea   = tickerObj.parent().parent().parent().prev();
                var prevStep            = (prevOrderbookArea.find(".stepField")).html();
                var prevQuote           = prevOrderbookArea.find('tr:nth-child(5) td:nth-child(3)').html();

                if(prevStep == undefined){
                    inputMoney          = $("#position").val();
                    positionBase        = inputMoney;
                    firstExchangeObj    = tickerObj.parent().parent();//to get the profit
                }
                else{
                    positionBase         = prevQuote;
                }



                ret             = JSON.parse(ret);
                // get the asset pair from orderbook api
                assetpair       = ret["assetpair"];
                baseCurrency    = (assetpair.split('/'))[0];
                quoteCurrency   = (assetpair.split('/'))[1];

                res         = ret["orderbook"][sellType];
                length      = res.length;
                var html    = "";
                var bid=[], total=[], quantity=[];

                for(i=0; i<length; i++){
                    item           = res[i];
                    bid[i]         = 1/item[0];
                    total[i]       = item[1];
                    quantity[i]    = item[0];
                    // console.log("(bid, total, quantity)->", bid[i], ", ", total[i], ", ", quantity[i]);
                }

                var WeBoughtAllVolume   =   false, index = 0, count = 0;
                var DesiredVol          =   positionBase;
                var BoughtVolume = 0, VOLMulPrice = 0;
                var realQuantity = [], realBid = [], realTotal = [];
                var bestPrice = 0;

                // this part is one that cauculate the price
                while(index<length && WeBoughtAllVolume == false){
                    var VolumeLeftToBuy     = DesiredVol - BoughtVolume;
                    var SellVolume;

                    if(orgbaseCurrency == baseCurrency)
                        SellVolume          = total[index];
                    else
                        SellVolume          = total[index] * quantity[index];

                    if(VolumeLeftToBuy <= SellVolume){
                        VOLMulPrice         =   VOLMulPrice + VolumeLeftToBuy * bid[index];
                        BoughtVolume        =   BoughtVolume + VolumeLeftToBuy;
                        WeBoughtAllVolume   =   true;

                        realQuantity[index] =   quantity[index];
                        realBid[index]      =   bid[index];
                        realTotal[index]    =   VolumeLeftToBuy * bid[index];
                    }else{
                        VOLMulPrice         =   VOLMulPrice + SellVolume * bid[index];
                        BoughtVolume        =   BoughtVolume + SellVolume;

                        realQuantity[index] =   quantity[index];
                        realBid[index]      =   bid[index];
                        realTotal[index]    =   SellVolume * bid[index];
                    }
                    count++;
                    index++;
                }


                if(WeBoughtAllVolume){
                    bestPrice       = VOLMulPrice / BoughtVolume;

                    // that is why asset reverse !!! markabel!
                    if(orgbaseCurrency == baseCurrency)
                        positionQuote   = positionBase / bestPrice;
                    else
                        positionQuote   = positionBase * bestPrice;

                    if(positionQuote>=100)
                        positionQuote = positionQuote.toFixed(2);
                    else
                        positionQuote = positionQuote.toFixed(8);

                    var realPrice     = 1 / bestPrice;
                    if(realPrice>=100)
                        priceString     = '1' + baseCurrency + ' = ' + realPrice.toFixed(2) + quoteCurrency;
                    else
                        priceString     = '1' + baseCurrency + ' = ' + realPrice.toFixed(8) + quoteCurrency;

                    if(prevStep == undefined){
                        tickerObj.find('tr:nth-child(6) td:nth-child(2)').html(priceString);
                        tickerObj.find('tr:nth-child(5) td:nth-child(3)').html(positionQuote);
                    }else{
                        tickerObj.find('tr:nth-child(6) td:nth-child(2)').html(priceString);
                        tickerObj.find('tr:nth-child(5) td:nth-child(2)').html(positionBase);
                        tickerObj.find('tr:nth-child(5) td:nth-child(3)').html(positionQuote);
                    }

                    for(i=0; i<count; i++){
                        realData        = "(" + realQuantity[i] + ", " + realBid[i] + ", " + realTotal[i] + ")";
                        console.log("(quantity, bid, total)======>", realData);
                    }

                    console.log("the order count====>", count);
                    console.log("END");
                    console.log("<<<<<<<<<<<<<<<>>>>>>>>>>>>>>>>>>>");

                    headString  =   '<th style="width:30%; text-align: center;">Price / ' + baseCurrency + '</th>' +
                                    '<th style="width:40%; text-align: center;">' + baseCurrency + ' Amount</th>' +
                                    '<th style="width:30%; text-align: center;">Total:(' + quoteCurrency + ')</th>';
                    orderbookObj.prev().find('tr').html(headString);

                    for(i=0; i<length; i++){
                        var orderQuantity, orderTotal1, orderTotal2;

                        if(quantity[i] >= 1000){
                            orderQuantity   = quantity[i].toFixed(5);
                        }else if(quantity[i] < 1){
                            orderQuantity   = quantity[i].toFixed(8);
                        }
                        else{
                            orderQuantity   = quantity[i].toFixed(7);
                        }


                        if(total[i] >= 1000){
                            orderTotal1     = total[i].toFixed(5);
                        }else if(total[i] < 1){
                            orderTotal1     = total[i].toFixed(8);
                        }
                        else{
                            orderTotal1     = total[i].toFixed(6);
                        }


                        if(quantity[i]*total[i] >= 1000){
                            orderTotal2         = (quantity[i]*total[i]).toFixed(2);
                        }else if(quantity[i]*total[i] >= 100){
                            orderTotal2         = (quantity[i]*total[i]).toFixed(4);
                        }else{
                            orderTotal2         = (quantity[i]*total[i]).toFixed(6);
                        }


                        html += "<tr style='width:100%;'>" +
                                    "<td style='width:30%; border-top: none; border-bottom: none;'>" + orderQuantity + "</td>" +
                                    "<td style='width:40%; border-top: none; border-bottom: none;'>" + orderTotal1 + "</td>" +
                                    "<td style='width:30%; border-top: none; border-bottom: none;'>" + orderTotal2 + "</td>" +
                                "</tr>";
                    }

                    orderbookObj.html(html);
                    if(prevStep != undefined)
                        checkProfit(parent);
                }else{
                    alert("Too Much Position Size!");
                }

                if(callback != '0')callback();
            }
        });
    }

    function getTicker(sellType, dataset, tickerObj, callback='0'){
        $.ajax({
            url: "../getTicker",
            type: "POST",
            data: dataset,
            success: function(ret){
                ret         = JSON.parse(ret);
                // console.log(ret);

                var price, priceString, positionBase, positionQuote;
                var flag        = 0;

                ask             = ret['ask'];
                bid             = ret['bid'];
                symbol          = ret['symbol'];

                if(sellType == 'bids')
                    price       = bid;
                else
                    price       = ask;

                baseCurrency    = (symbol.split('/'))[0];
                quoteCurrency   = (symbol.split('/'))[1];

                orgBase         = dataset['baseCurrency'];
                orgQuote        = dataset['quoteCurrency'];

                if(orgBase != baseCurrency){
                    flag        = 1;
                }

                // if(price>=100)
                //     priceString     = '1' + baseCurrency + ' = ' + price.toFixed(2) + quoteCurrency;
                // else
                //     priceString     = '1' + baseCurrency + ' = ' + price.toFixed(4) + quoteCurrency;


                var prevOrderbookArea   = tickerObj.parent().parent().parent().prev();
                var prevStep            = (prevOrderbookArea.find(".stepField")).html();
                var prevQuote           = prevOrderbookArea.find('tr:nth-child(5) td:nth-child(3)').html();

                if(prevStep == undefined){
                    inputMoney          = $("#position").val();
                    positionBase         = inputMoney;
                    firstExchangeObj    = tickerObj.parent().parent();//to get the profit
                }
                else{
                    positionBase    = prevQuote;
                }

                if(flag){
                    positionQuote = (positionBase / price);
                }else{
                    positionQuote = (positionBase * price);
                }

                positionQuote = positionQuote.toFixed(4);

                // console.log("Position Quote = ", positionQuote);
                var newOrderStr;


                var orderbookObj      = tickerObj.parent().parent().next();
                var orderbookContent  = orderbookObj.find(".orderbookContent");
                var priceSum = 0, volumeSum = 0;
                var number = 0;

                orderbookContent.find("tr").each(function(){
                    number++;
                    var orderItem     = $(this);
                    var volume, orderPrice;
                    volume            = parseFloat(orderItem.find("td:nth-child(1)").html());
                    orderPrice        = parseFloat(orderItem.find("td:nth-child(2)").html());
                    priceSum         += orderPrice*volume;
                    volumeSum        += volume;
                    // if(number == 50)return false;
                });


                var realPrice         = priceSum / volumeSum;
                realPrice             = 1 / realPrice;

                // console.log("real price", realPrice);

                if(flag){
                    positionQuote = (positionBase / realPrice);
                }else{
                    positionQuote = (positionBase * realPrice);
                }

                if(positionQuote>=100)
                    positionQuote = positionQuote.toFixed(2);
                else
                    positionQuote = positionQuote.toFixed(4);


                if(realPrice>=100)
                    priceString     = '1' + baseCurrency + ' = ' + realPrice.toFixed(2) + quoteCurrency;
                else
                    priceString     = '1' + baseCurrency + ' = ' + realPrice.toFixed(4) + quoteCurrency;

                if(prevStep == undefined){
                    tickerObj.find('tr:nth-child(6) td:nth-child(2)').html(priceString);
                    tickerObj.find('tr:nth-child(5) td:nth-child(3)').html(positionQuote);
                }else{
                    tickerObj.find('tr:nth-child(6) td:nth-child(2)').html(priceString);
                    tickerObj.find('tr:nth-child(5) td:nth-child(2)').html(positionBase);
                    tickerObj.find('tr:nth-child(5) td:nth-child(3)').html(positionQuote);
                }

                if(callback != '0')callback();
            }
        });
    }


    function getTickerValue(dataset, callback='0'){0
        $.ajax({
            url: "../getTicker",
            type: "POST",
            data: dataset,
            success: function(ret){
                ret         = JSON.parse(ret);
                ask             = ret['ask'];
                bid             = ret['bid'];
                symbol          = ret['symbol'];
                finalPrice      = ask;
                if(callback != '')callback();
            }
        });
    }


    function checkProfit(lastExchangeObj){
        firstExchangeType   = firstExchangeObj.find(".exchangeItems").val();
        lastExchangeType    = lastExchangeObj.find(".exchangeItems").val();

        firstExchange       = (firstExchangeType.split(','))[1];
        lastExchange        = (lastExchangeType.split(','))[1];

        baseCurrency        = firstExchangeObj.find(".baseCurrency").val();
        resultCurrency      = lastExchangeObj.find(".quoteCurrency").val();

        // console.log("Profit test");
        // console.log(firstExchange);
        // console.log(lastExchange);

        // if(firstExchange == lastExchange && baseCurrency == resultCurrency){
        var asset           = firstExchangeObj.find("#position").val();
        var result          = lastExchangeObj.find(".exchangeSelector tbody tr:nth-child(5) td:nth-child(3)").html();
        if(baseCurrency == resultCurrency){
            profit          = ((result - asset)/asset * 100).toFixed(2) + '%';
            $(".profitArea").html(profit);
        }else{


            $.ajax({
                url: "../getProfit",
                type: "POST",
                data: {baseCurrency: baseCurrency, quoteCurrency:resultCurrency},
                success: function(ret){
                    ret         = JSON.parse(ret);
                    console.log(ret);
                    rate        = ret['rate'];
                    result      = result/rate;
                    profit      = ((result - asset)/asset * 100).toFixed(2) + '%';

                    $(".profitArea").html(profit);
                }
            });
        }
        return;
    }
} );
