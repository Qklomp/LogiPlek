function Toggle(object) {
    switch (object) {
        case 'klantOmlaag':
            if(validation('emballageInfo'))
            {
                document.getElementById("emballageInfo").style.display = "none";
                document.getElementById("emballageMee").style.display = "block";
            }

            $([document.documentElement, document.body]).animate({
                scrollTop: $("#emballageMee").offset().top - 30
            }, 200);

            break;
        case 'emballageMeeOmhoog':
            document.getElementById("emballageInfo").style.display = "block";
            document.getElementById("emballageMee").style.display = "none";

            $([document.documentElement, document.body]).animate({
                scrollTop: $("#emballageInfo").offset().top - 30
            }, 200);

            break;
        case 'emballageMeeOmlaag':
            validation("emballageMee");
            document.getElementById("emballageMee").style.display = "none";
            document.getElementById("emballageRetour").style.display = "block";

            $([document.documentElement, document.body]).animate({
                scrollTop: $("#emballageRetour").offset().top - 30
            }, 200);

            break;
        case 'emballageRetourOmhoog':
            document.getElementById("emballageMee").style.display = "block";
            document.getElementById("emballageRetour").style.display = "none";

            $([document.documentElement, document.body]).animate({
                scrollTop: $("#emballageMee").offset().top - 30
            }, 200);

            break;
        case 'emballageRetourOmlaag':
            if(validation("all"))
            {
                document.getElementById("emballageInfo").style.display = "none";
                document.getElementById("emballageMee").style.display = "none";
                document.getElementById("emballageRetour").style.display = "none";
                document.getElementById("emballageControle").style.display = "block";

                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#emballageControle").offset().top - 30
                }, 200);
            }
            break;
        case 'emballageControleTerug':
            $('#verzendDiv').hide();
            document.getElementById("emballageInfo").style.display = "none";
            document.getElementById("emballageMee").style.display = "none";
            document.getElementById("emballageRetour").style.display = "block";
            document.getElementById("emballageControle").style.display = "none";

            $([document.documentElement, document.body]).animate({
                scrollTop: $("#emballageRetour").offset().top - 30
            }, 200);

            break;
    }
}

function responsive() {
    if(!$('#emballageControle').is(':visible')){
        if(window.matchMedia("(min-width: 769px)").matches){
            document.getElementById("emballageInfo").style.display = "block";
            document.getElementById("emballageMee").style.display = "block";
            document.getElementById("emballageRetour").style.display = "block";
        }
        else
        {
            document.getElementById("emballageInfo").style.display = "block";
            document.getElementById("emballageMee").style.display = "none";
            document.getElementById("emballageRetour").style.display = "none";
        }
    }
}

var emballageInfoVal, emballageMeeVal, emballageRetourVal;

function validation(objectSet) {
    if(objectSet === 'all' || objectSet === 'emballageMee')
    {
        $('#emballageMeeControleContainer').empty();
        emballageMeeVal = false;
        var container = document.getElementById('emballageMee');
        var elements = Array.prototype.slice.call(container.getElementsByTagName('input'));

        elements.forEach(function (element) {
            if (element.value !== '0' && element.value !== '') {
                emballageMeeVal = true;
                $('#emballageMeeControleContainer').append(
                    '<tr>' +
                    '<td>' + (element.id).split('mee')[0] + '</td>' +
                    '<td><p id="DatumValue">' + element.value + '</p></td>' +
                    '</tr>'
                );
            }
        });
        if (!emballageMeeVal) {
            $('#emballageMeeControleContainer').append(
                '<tr><td colspan="2">Er zijn geen items geselecteerd voor de meegenomen emballage.</td></tr>'
            );
        }
    }
    if(objectSet === 'all' || objectSet === 'emballageRetour')
    {
        $('#emballageRetourControleContainer').empty();
        emballageRetourVal = false;
        container = document.getElementById('emballageRetour');
        elements = Array.prototype.slice.call(container.getElementsByTagName('input'));

        elements.forEach(function (element) {
            if (element.value !== '0' && element.value !== '') {
                emballageRetourVal = true;
                $('#emballageRetourControleContainer').append(
                    '<tr>' +
                    '<td>' + (element.id).split('retour')[0] + '</td>' +
                    '<td><p id="DatumValue">' + element.value + '</p></td>' +
                    '</tr>'
                );
            }
        });
        if (!emballageRetourVal) {
            $('#emballageRetourControleContainer').append(
                '<tr><td colspan="2">Er zijn geen items geselecteerd voor de geretourneerde emballage.</td></tr>'
            );
        }
    }
    if(objectSet === 'all' || objectSet === 'emballageInfo')
    {
        emballageInfoVal = false;
        if ($('#form').parsley().validate()) {
            emballageInfoVal = true;

            $('#KentekenValue').html($('#Vrachtwagen').val());
            $('#KlantnummerValue').html($('#Klantnummer').val());
            $('#DatumValue').html($('#Toegevoegd_op').val());
        }
    }
    if(emballageMeeVal || emballageRetourVal)
    {
        $('#verzendDiv').show();
        $('#emballageControleWarning').hide();
    }
    else
    {
        $('#verzendDiv').hide();
        $('#emballageControleWarning').show();
    }
    return emballageInfoVal;
}

function submitFormFunction() {
    $('#verzendButton').attr('disabled', 'disabled');
}

$(document).ready(function () {
    $(window).resize(function() {
        responsive();
    });

    $(window).keydown(function(event){
        if(event.keyCode === 13) {
            event.preventDefault();
            $('#emballageRetourOmlaag').click();
            return false;
        }
    });
});


