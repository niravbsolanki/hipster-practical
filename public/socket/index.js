const express = require('express')
var http = require('http')
var path = require('path')
const app = express()
const port = 3000
const { WebSocketServer }  = require('ws');
const server = http.createServer(app);

const wss = new WebSocketServer({ server});

wss.on('connection', function connection(ws) {
  ws.on('error', console.error);

  console.log('Client is connected');
  
  ws.on('message', function message(data) {
    const getData = JSON.parse(data);
    
     wss.clients.forEach(function each(client) {
      if (client.readyState === WebSocket.OPEN) {
            client.send(JSON.stringify(getData));
      }
    });
  });

//   ws.send('something');

  ws.on('close', function message(data) {
    console.log('Client connection close.');
  });

});

server.listen(port ,() => {
  console.log('Express server listening on port ' + port);
});