#!/var/local/node/bin/node

var HostName = '192.168.0.32';

var http    = require('http'),
    url     = require('url'),
    fs      = require('fs'),
    io      = require('socket.io').listen(80);


    
var spawn = require('child_process').spawn;    
var tail = spawn("tail", ["-f", '/opt/bitcoin/.bitcoin/debug.log']);

var counter = 0;    
var test = io
   .of('/blocks')
   .on('connection', function (socket) {
       socket.on('test_event', function (data) {
           console.log(data);
       });
       
});


  tail.stdout.on("data", function (data) {
      var new_block_info = ExtractBlockFromLog(data);
      if (new_block_info !== null) {
           console.log(new_block_info);
           test.emit ('new_block_event' , {'block' : new_block_info})
         }                            
  }); 

function ExtractBlockFromLog(data)
{
    var str = data.toString(),
        regex = /^SetBestChain: new best=([a-z0-9]*)\s*height=(\d*)\s\s*work=(\d*)\n$/,
        match = str.match(regex);
    if (match !== null) {
           result = {
               'best' : match[1],
               'height' : match[2],
               'work' : match[3],
           }
           return result;
         }               
      else return null;             
    
}