const express = require('express')
var http = require('http')
var path = require('path')
const app = express()
const port = 3000
const mysql = require('mysql2');

const { WebSocketServer }  = require('ws');
const server = http.createServer(app);

const wss = new WebSocketServer({ server});
let customers = {};

wss.on('connection', function connection(ws) {
  ws.on('error', console.error);

  console.log('Client is connected');
  
  ws.on('message', function message(data) {
    const getData = JSON.parse(data);

     if(getData.type && getData.type == "customer"){
        customers[getData.customer_id] = getData.status;
        customerOnlineStatus(getData);
     }

     wss.clients.forEach(function each(client) {
      if (client.readyState === WebSocket.OPEN) {
            client.send(JSON.stringify(getData));
      }
    });

     ws.customer_id = getData.customer_id;
  });

  ws.on('close', function message(data) {

    console.log('Client connection close.');

    if (ws.customer_id && customers[ws.customer_id]) {
      customers[ws.customer_id] = "offline";
      customerOnlineStatus({ customer_id: ws.customer_id, status: "offline" });
      const offlineData = { customer_id: ws.customer_id, status: "offline" };
      wss.clients.forEach(client => {
        if (client.readyState === WebSocket.OPEN) {
          client.send(JSON.stringify(offlineData));
        }
      });

      console.log(`Customer ${ws.customer_id} is now offline.`);
    }
  });

});

function customerOnlineStatus(response){
    
    const connection = mysql.createConnection({
        host: 'localhost',
        user: 'root',
        password: '',
        database: 'hipster_db'
        });

    connection.connect(err => {
        if (err) {
            console.error('MySQL connection failed:', err);
        } else {
            console.log('Connected to MySQL');
        }
    });
    
     connection.query(
      'UPDATE customers SET status = ? WHERE id = ?',
      [response.status === 'online' ? 'online' : 'offline', response.customer_id],
      (err) => {
        if (err) console.error('DB update error:', err);
        else console.log(`User ${response.customer_id} set to ${response.status}`);
      }
    );
}

server.listen(port ,() => {
  console.log('Express server listening on port ' + port);
});