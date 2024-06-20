var client;
var i=0;
self.addEventListener("message", (event) => {

    client=event.source;

    if (event.data==='Start_counter'){
        setInterval(function (){
            i=i+1;
            const data={
                'message' : 'hi',
                'cu': i,
            }
            sendData_toClient(data)
        },1000)
    }
});

function sendData_toClient(data){
    self.clients.matchAll({ type: 'window' }).then(function(clients) {
        clients.forEach(function(client) {
            if (client instanceof WindowClient) {
                client.postMessage(data);
            }
        });
    });
}
