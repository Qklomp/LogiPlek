//Klantnaam
function Klant(str)
{
    if (str=="")
    {
        document.getElementById("txtHint").innerHTML="";
        return;
    }
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","select.php?q="+str,true);
    xmlhttp.send();
}

//Stops
function Stops(str)
{
    if (str=="")
    {
        document.getElementById("Colliweergave").innerHTML="";
        return;
    }
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById("Colliweergave").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","stops.php?q="+str,true);
    xmlhttp.send();
}

function Toggle(){

    var klantnummer = false;
    var emballrageMee = false;
    var emballageRetour  = false;
    var verzendButton = false;
    if(document.getElementById("vrachtwagen").selectedIndex != "0"){
        klantnummer = true;
        if(document.getElementById("Klantnummer").value != ''){
            emballrageMee = true;
            element = document.getElementById('emballageMee');
            elements = element.getElementsByTagName('input');

            for (var i = 0; i < elements.length; i++)
            {
                if(elements[i].nodeName === 'INPUT' && elements[i].value !== '')
                {
                    emballageRetour = true;
                    break;
                }
            }
            if(emballageRetour)
            {
                element = document.getElementById('emballageRetour');
                elements = element.getElementsByTagName('input');
                console.log(elements[1].value);
                for (var i = 0; i < elements.length; i++)
                {
                    if(elements[i].nodeName === 'INPUT' && elements[i].value !== '')
                    {
                        verzendButton = true;
                        break;
                    }
                }
            }

        }
    }

    if(klantnummer){
        document.getElementById("klantnummer").classList.remove("collapse")
        if(emballrageMee){
            document.getElementById("emballageMee").classList.remove("collapse")
        }if(emballageRetour){
            document.getElementById("emballageRetour").classList.remove("collapse")
        }if(verzendButton){
            document.getElementById("verzendButton").classList.remove("collapse")
        }
    }
}
