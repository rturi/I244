window.onload = function() {

    var beadArray = document.querySelectorAll(".bead");

    for (var i = 0; i < beadArray.length; i++) {
        beadArray[i].onclick = function () {
            if (window.getComputedStyle(this).cssFloat == "undefined") {
                this.style.cssFloat = "right";
            } else if (window.getComputedStyle(this).cssFloat == "left") {
                this.style.cssFloat = "right";
            } else {
                this.style.cssFloat = "left";
            }
        }
    }

}