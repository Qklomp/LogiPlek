//Klantnaam
function Klant(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    }
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "select.php?q=" + str, true);
    xmlhttp.send();
}

//Stops
function Stops(str) {
    if (str == "") {
        document.getElementById("Colliweergave").innerHTML = "";
        return;
    }
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("Colliweergave").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "stops.php?q=" + str, true);
    xmlhttp.send();
}

function Toggle() {

    var klantnummer = false;
    var emballrage = false;
    var verzendButton = false;
    if (document.getElementById("Vrachtwagen").selectedIndex !== 0) {
        klantnummer = true;
        if (document.getElementById("Klantnummer").value !== "") {
            emballrage = true;
            element1 = document.getElementById('emballageMee');
            elements1 = Array.prototype.slice.call(element1.getElementsByTagName('input'));
            element2 = document.getElementById('emballageRetour');
            elements2 = Array.prototype.slice.call(element2.getElementsByTagName('input'));
            var elements = elements1.concat(elements2);

            for (var i = 0; i < elements.length; i++) {
                if (elements[i].nodeName === 'INPUT' && elements[i].value !== "0") {
                    verzendButton = true
                    break;
                }
            }


        }
    }

    if (klantnummer) {
        document.getElementById("klantnummer").classList.remove("collapse")
        if (emballrage) {
            document.getElementById("emballageMee").classList.remove("collapse")
            document.getElementById("emballageRetour").classList.remove("collapse")
            if (verzendButton) {
                document.getElementById("verzendButton").classList.remove("collapse")
            } else {
                document.getElementById("verzendButton").classList.add("collapse")
            }
        }else{
            document.getElementById("verzendButton").classList.add("collapse")
            document.getElementById("emballageRetour").classList.add("collapse")
            document.getElementById("emballageMee").classList.add("collapse")
        }
    }else{
        document.getElementById("verzendButton").classList.add("collapse")
        document.getElementById("emballageRetour").classList.add("collapse")
        document.getElementById("emballageMee").classList.add("collapse")
        document.getElementById("klantnummer").classList.add("collapse")
    }
}



