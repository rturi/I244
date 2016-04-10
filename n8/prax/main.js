window.onload = function() {

    // only for gallery pages
    if (document.querySelectorAll("#gallery").length != 0) {

        var galleryImgArray = document.querySelectorAll("#gallery a");

        for (var i = 0; i < galleryImgArray.length; i++) {
            galleryImgArray[i].onclick = function() {
                showDetails(this);
                return false;
            }
        }

    }

    function showDetails(el) {

        if (document.querySelectorAll("#hoidja").length != 0) {

            var hoidja = document.querySelector("#hoidja img");

            hoidja.src = el.parentNode.href;


            //document.querySelector("#inf").innerHTML = el.alt;
            //
            //hoidja.onload = function() {
            //    suurus(this);
            //}


            $.get(el.href, "html", function(data){
                document.getElementById('sisu').innerHTML=data;
            });

            document.querySelector("#hoidja").style.display = "initial";
        }

        } //showDetails()


    function suurus(el) {
        el.removeAttribute("height"); // eemaldab suuruse
        el.removeAttribute("width");
        if (el.width > window.innerWidth || el.height > window.innerHeight) {  // ainult liiga suure pildi korral
            if (window.innerWidth >= window.innerHeight) { // lai aken
                el.height = window.innerHeight * 0.9; // 90% kõrgune
                if (el.width > window.innerWidth) { // kas element läheb ikka üle piiri?
                    el.removeAttribute("height");
                    el.width = window.innerWidth * 0.9;
                }
            } else { // kitsas aken
                el.width = window.innerWidth * 0.9;   // 90% laiune
                if (el.height > window.innerHeight) { // kas element läheb ikka üle piiri?
                    el.removeAttribute("width");
                    el.height = window.innerHeight * 0.9;
                }
            }
        }
    }

}

function hideDetails() {
    document.querySelector("#hoidja").style.display = "none";
}