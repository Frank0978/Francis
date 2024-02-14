function checkPosition(e) {
    if ((e.target.nodeName === 'IMG')) {
        var box = e.target; // Extracts the table cell DOM object from the event
        $.ajax({// Sends the Ajax Request
            type: 'POST', // Type POST
            url: 'index.php', // to index.php script
            dataType: "json", // Data coded sent in JSON
            data: {// Coordinates sent to the server
                x: box.dataset.x,
                y: box.dataset.y
            },
            success: function (result) { // When the server response arrives correctly
                console.log(result);
                if (result.click !== undefined) {
                    $(`#${result.posicionAnteriorJ[0]}${result.posicionAnteriorJ[1]}`).attr("src", `${result.rutaImg[0]}`);
                    $(`#${result.posicionAnteriorIA[0]}${result.posicionAnteriorIA[1]}`).attr("src", `${result.rutaImg[0]}`);
                    $(`#${result.click[0]}${result.click[1]}`).attr("src", `${result.rutaImg[1]}`);
                    $(`#${result.clickIA[0]}${result.clickIA[1]}`).attr("src", `${result.rutaImg[2]}`);
                }
                if (result.error !== undefined) {
                    alert('Casilla de movimiento no permitida intentalo de nuevo');
                }
                if (result.gameRes !== undefined) { // If the response info has a gameRes property
                    switch (result.gameRes) {
                        case 0: // If the value is 1 show You Win!!
                            $(`#${result.posicionAnteriorJ[0]}${result.posicionAnteriorJ[1]}`).attr("src", `${result.rutaImg[0]}`);
                            $(`#${result.posicionAnteriorIA[0]}${result.posicionAnteriorIA[1]}`).attr("src", `${result.rutaImg[0]}`);
                            $(`#${result.clickJ[0]}${result.clickJ[1]}`).attr("src", `${result.rutaImg[1]}`);
                            $("#mensaje").text("You Win!!");
                            break;
                        case 1: // If the value is - 1 show You lost!!
                            $(`#${result.posicionAnteriorJ[0]}${result.posicionAnteriorJ[1]}`).attr("src", `${result.rutaImg[0]}`);
                            $(`#${result.posicionAnteriorIA[0]}${result.posicionAnteriorIA[1]}`).attr("src", `${result.rutaImg[0]}`);
                            $(`#${result.clickIA[0]}${result.clickIA[1]}`).attr("src", `${result.rutaImg[2]}`);
                            $("#mensaje").text("You Lost!!");
                            break;
                    }
                    $('table').unbind('click'); // Removes the event handler on the table
                }
            },
            error: function (xhr, status, error) {
                var errorMessage = xhr.status + ': ' + xhr.statusText;
                alert('Error - ' + errorMessage);
            }
        });
    }
}
;

// Establish a handler to run when the DOM is loaded. 

$(document).ready(function () {
    $('table').click(checkPosition); // Establish a handler to run on all elements components of table
});
