const socket = new WebSocket("ws://localhost:8765");

socket.onmessage = function(event){

    const datos = JSON.parse(event.data);

    document.getElementById("datos").textContent =
        JSON.stringify(datos,null,4);

}

socket.onopen=function(){

    console.log("Conectado");

}

socket.onclose=function(){

    console.log("Desconectado");

}