import asyncio
from peregrinearb import load_exchange_graph, getResult_Single, bellman_ford
from peregrinearb import create_weighted_multi_exchange_digraph, bellman_ford_multi, getResult_Multi
import json
import flask
from flask import request, jsonify
from flask_cors import CORS
from multiprocessing import Process

app = flask.Flask(__name__)
CORS(app)
app.config["DEBUG"] = True
loop = asyncio.get_event_loop()

# multi mode api
@app.route("/api/multimode" ,methods=['POST'])
def multimode():
    request_json    = request.json
    exchanges       = {}
    exchanges       = request_json['exchanges']
    baseCurrency    = request_json['baseCurrency']
    positionSize    = request_json['positionSize']
    profitLimit     = request_json['profitLimit']

    # asyncio.set_event_loop(loop)

    asyncio.set_event_loop(
        asyncio.new_event_loop()
    )

    graph = create_weighted_multi_exchange_digraph(exchanges, fees=True, log=True)
    graph, paths = bellman_ford_multi(graph, baseCurrency, loop_from_source=True, unique_paths=False)

    num     = 0
    results = {}
    for path in paths:
        temp = getResult_Multi(graph, path, print_output=True, round_to=6, shorten=False, starting_amount=positionSize)
        if(temp == 0):
            continue
        
        resultSize  = len(temp)
        resultRate  = temp[resultSize-1]['money']/positionSize*100
        if resultRate < profitLimit:
            continue

        flag = 0
        for i in range(num):
            if results[i] == temp:
                flag = 1
                break
        
        if flag == 1:
            continue

        results[num]    = {}
        results[num]    = temp
        num = num + 1

    # print(num)

    return json.dumps(results)

    # results = []
    
    # for book in books:
    #     if book['id'] == id:
    #         results.append(book)
    
    # return jsonify(results)

# single mode api
@app.route("/api/singlemode", methods=['POST'])
def singlemode():
    request_json    = request.json
    # print(request_json)
    exchange        = request_json['exchange']
    baseCurrency    = request_json['baseCurrency']
    positionSize    = request_json['positionSize']
    profitLimit     = request_json['profitLimit']


    # asyncio.set_event_loop(loop)

    asyncio.set_event_loop(
        asyncio.new_event_loop()
    )


    graph = loop.run_until_complete(load_exchange_graph(exchange))
    # paths = bellman_ford(graph, baseCurrency, unique_paths=True)

    paths = bellman_ford(graph, baseCurrency, loop_from_source=True, ensure_profit=False, unique_paths=False)
    
    num     = 0
    results = {}
    for path in paths:
        temp = getResult_Single(graph, path, round_to=6, depth=False, starting_amount=positionSize)
        if temp == 0:
            continue
        
        resultSize  = len(temp)
        resultRate  = temp[resultSize-1]['resulting_amount']/positionSize*100
        
        if resultRate < profitLimit:
            continue

        flag = 0
        for i in range(num):
            if results[i] == temp:
                flag = 1
                break
        
        if flag == 1:
            continue

        results[num]    = {}
        results[num]    = temp
        num = num + 1
    # print(num)

    return json.dumps(results)

app.run()