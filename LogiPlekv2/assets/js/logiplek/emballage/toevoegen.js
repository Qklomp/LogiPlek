function Toggle() {
    if (screen.width > 480) {
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


        if (emballrage) {
            document.getElementById("emballageMee").style.display = "block";
            document.getElementById("emballageRetour").style.display = "block";
            if (verzendButton) {
                document.getElementById("verzendButton").style.display = "block";
            } else {
                document.getElementById("verzendButton").style.display = "none";
            }
        } else {
            document.getElementById("verzendButton").style.display = "none";
            document.getElementById("emballageRetour").style.display = "none";
            document.getElementById("emballageMee").style.display = "none";
        }

    }
}


function mobileToggle(object) {
    switch (object) {
        case 'klantOmlaag':
            //input


            if (validation("vrachtwagen")) {
                console.log("Vrachtwagen gedaan")
                if (validation("klantnummer")) {
                    document.getElementById("vrachtwagen").style.display = "none";
                    document.getElementById("klantnummer").style.display = "none";
                    document.getElementById("emballageMee").style.display = "inline-block";
                    document.getElementById("emballageRetour").style.display = "none";
                    document.getElementById("verzendButton").style.display = "none";

                    //buttons
                    document.getElementById("klantOmlaag").style.display = "none";
                    document.getElementById("emballageMeeOmhoog").style.display = "inline-block";
                    document.getElementById("emballageMeeOmlaag").style.display = "inline-block";
                    document.getElementById("emballageRetourOmhoog").style.display = "none";
                }
            }
            break;
        case 'emballageMeeOmhoog':
            //input

            document.getElementById("vrachtwagen").style.display = "inline-block";
            document.getElementById("klantnummer").style.display = "inline-block";
            document.getElementById("emballageMee").style.display = "none";
            document.getElementById("emballageRetour").style.display = "none";
            document.getElementById("verzendButton").style.display = "none";

            //buttons
            document.getElementById("klantOmlaag").style.display = "inline-block";
            document.getElementById("emballageMeeOmhoog").style.display = "none";
            document.getElementById("emballageMeeOmlaag").style.display = "none";
            document.getElementById("emballageRetourOmhoog").style.display = "none";
            break;
        case 'emballageMeeOmlaag':
            //input

            if (validation("emballageMee")) {
                document.getElementById("vrachtwagen").style.display = "none";
                document.getElementById("klantnummer").style.display = "none";
                document.getElementById("emballageMee").style.display = "none";
                document.getElementById("emballageRetour").style.display = "inline-block";
                document.getElementById("verzendButton").style.display = "inline-block";

                //buttons
                document.getElementById("klantOmlaag").style.display = "none";
                document.getElementById("emballageMeeOmhoog").style.display = "none";
                document.getElementById("emballageMeeOmlaag").style.display = "none";
                document.getElementById("emballageRetourOmhoog").style.display = "inline-block";
            }

            break;
        case 'emballageRetourOmhoog':
            //input
            document.getElementById("vrachtwagen").style.display = "none";
            document.getElementById("klantnummer").style.display = "none";
            document.getElementById("emballageMee").style.display = "inline-block";
            document.getElementById("emballageRetour").style.display = "none";
            document.getElementById("verzendButton").style.display = "none";

            //buttons
            document.getElementById("klantOmlaag").style.display = "none";
            document.getElementById("emballageMeeOmhoog").style.display = "inline-block";
            document.getElementById("emballageMeeOmlaag").style.display = "inline-block";
            document.getElementById("emballageRetourOmhoog").style.display = "none";
            break;
    }

}

function validation(naam) {
    var container = document.getElementById(naam);
    var elements = Array.prototype.slice.call(container.getElementsByTagName('input'));
    var selectthingy = Array.prototype.slice.call(container.getElementsByTagName('select'));

    console.log(selectthingy);
    if (typeof selectthingy != 'undefined') {
        if (selectthingy.selectedIndex === 0) {
            console.log('dgfhfhf');
            document.getElementById("errorVrachtwagen").innerHTML = "Welke vrachtwagen rij jij? Er moet wel eentje geselecteerd worden!";
            return false;
        } else {
            return true;
        }
    }
    console.log(elements.length);
    if (elements.length !== 0) {
        elements.forEach(function (element) {
            console.log(element.id);
            if (element.value !== "0") {
                return true;
            } else {
                document.getElementById("error" + element.id);
                document.getElementById("error" + element.id).innerHTML = "GRAFTAK!";
                return false;
            }
        })
    }
}

function maak_vrachtwagen_cookie(functie_id) {
    console.log("functie id:")
    console.log(functie_id);
    if(functie_id != 0 && functie_id !=3){
        var today = new Date();
        var expiry = new Date(today.getTime() + 12 * 3600 * 1000);
        var value = document.getElementById("Vrachtwagen").selectedIndex;
        var name = "VrachtwagenSelectedIndex";
        console.log(name + "=" + escape(value) + "; path=/; expires=" + expiry.toGMTString());
        document.cookie = name + "=" + escape(value) + "; path=/; expires=" + expiry.toGMTString();
        var name = "VrachtwagenValue";
        var value = document.getElementById("Vrachtwagen").value;
        document.cookie = name + "=" + escape(value) + "; path=/; expires=" + expiry.toGMTString();
    }
}

function doSomething() {
    var myCookieValue = getCookie("VrachtwagenValue");
    var myCoockieSelectedIndex = getCookie("VrachtwagenSelectedIndex");
    console.log(myCoockieSelectedIndex);
    console.log(myCookieValue);
    if (myCoockieSelectedIndex == null) {
        // do cookie doesn't exist stuff;
    }
    else {
        // do cookie exists stuff
        document.getElementById("Vrachtwagen").selectedIndex = myCoockieSelectedIndex;
        var isErNog = false;
        for (var i = 0; i < document.getElementById("Vrachtwagen").options.length; i++) {
            if (document.getElementById("Vrachtwagen").options[i].value === myCookieValue) {
                isErNog = true;
                document.getElementById("Vrachtwagen").selectedIndex = i;
                break;
            } else {
            }
        }
    }
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

$(document).ready(function () {
    console.log("MyCookie");
    doSomething();

});
