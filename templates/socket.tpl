{literal}
<script type="text/javascript" src="js/socket.io.js"></script>
<script>
 var socket = io.connect('http://50.17.240.59/blocks');

$(document).ready(function() {
    
  socket.on('connect', function (data) {
    console.log('****************** CONNECT ************');
    show_message('Websocket connected');
   });   
    
  socket.on('new_block_event', function (data) {
      var block = data.block;
      console.log(block);
      new_block_found(block);
      
  });
  
  
});
</script>
{/literal}