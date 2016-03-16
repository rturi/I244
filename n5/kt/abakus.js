window.onload = function() {

    var beadArray = document.querySelectorAll(".bead, .flicked");

    for (var i = 0; i < beadArray.length; i++) {
        if (beadArray[i].classList.contains("flicked")) {
            console.log("test" + i);
            beadArray[i].style.cssFloat = "right";
        } else {
            beadArray[i].style.cssFloat = "left";
        }
    }

}