var timerId, contactId, searchValue, contactList, currentDate = '';
contactList = new Array();

$(document).ready(function () {
    $('#searchInput').on('input', function (e) {
        searchValue = e.target.value;
        searchCheck();
    });

    $('#sendButton').on('click', function () {
        if ($('#berichtInput').val() !== '') {
            $.ajax({
                url: base_url + "bericht/verstuur_bericht",
                dataType: 'text',
                type: "POST",
                data: {contactId: contactId, bericht: $('#berichtInput').val()},
                success: function (result) {
                    var obj = $.parseJSON(result);
                    $('.chatberichtOngelezen').remove();
                    printChatMessages(obj);
                    document.getElementById('berichtInput').value = '';
                    $('#berichtInput').focus();
                }
            });
        }
    });

    $('#terugButton').on('click', function () {
        $('#chatContainer').hide();
        $('#contactContainer').show();
        clearTimeout(timerId);
    });

    $('#berichtInput').on('keyup', function (e) {
        if (e.keyCode === 13) {
            $('#sendButton').click();
        }
    });

    $.ajax({
        url: base_url + "bericht/get_contacten",
        dataType: 'text',
        type: "POST",
        success: function (result) {
            $('#ContactList').empty();
            var obj = $.parseJSON(result);
            $.each(obj, function (index, object) {
                $('#ContactList').append(
                    '<li class="contactButton list-group-item">' +
                    '<input type="hidden" id="contactID" value="' + object['contact'] + '">' +
                    object['voornaam'] + ' ' + object['achternaam'] +
                    (object['aantal_ongelezen'] === '0' ? '' : '<div class="ongelezenNumber">' + object['aantal_ongelezen'] + '</div>') +
                    '</li>'
                );
                contactList.push(object);
            });
            $('.contactButton').on('click', function (e) {
                contactId = e.target.childNodes[0].value;
                $('#contactNaam').html(e.target.childNodes[1].nodeValue);
                UpdateTotaalOngelezen();
                UpdateContactOngelezen(this);
                openChat();
            });
        }
    });

    $(window).resize(function () {
        responsive();
    });
});

function openChat() {
    if (window.matchMedia("(max-width: 992px)").matches) {
        $('#contactContainer').hide();
    }
    $('#chatContainer').show();

    getChatHistory(contactId);
    ongelezen = false;
    clearTimeout(timerId);
    timerId = setTimeout(autoRefresh, 2000);
}

function UpdateTotaalOngelezen() {
    var total = 0;
    $.each(contactList, function (index, object) {
        if(object['contact'] !== contactId)
            total += parseInt(object['aantal_ongelezen']);
    });
    $('#totaalOngelezen').html('Berichten ('+ total +')');
}

function UpdateContactOngelezen(element)
{
    if(element.childNodes[2])
    {
        element.childNodes[2].remove();
        $.each(contactList, function (index, object) {
            if(object['contact'] === contactId)
                object['aantal_ongelezen'] = 0;
        });
    }
}

function searchCheck() {
    if (searchValue !== '') {
        $('#ContactSearchDiv').show();
        $('#ContactList').hide();
        contactSearch();
    }
    else {
        $('#ContactSearchDiv').hide();
        $('#ContactList').show();
    }
}

function contactSearch() {
    $.ajax({
        url: base_url + "bericht/contactSearch",
        dataType: 'text',
        type: "POST",
        data: {searchValue: searchValue},
        success: function (result) {
            $('#searchList').empty();
            var obj = $.parseJSON(result);
            $.each(obj, function (index, object) {
                $('#searchList').append(
                    '<li class="contactSearchButton list-group-item">' +
                    '<input type="hidden" id="contactID" value="' + object['id'] + '">' + object['voornaam'] + ' ' + object['achternaam'] +
                    '</li>'
                );
            });
            $('.contactSearchButton').on('click', function (e) {
                contactId = e.target.childNodes[0].value;
                $('#contactNaam').html(e.target.childNodes[1].nodeValue);
                $('#searchInput').val('').trigger('input');

                if (contactList.indexOf(e.target.childNodes[1].nodeValue) === -1) {
                    $('#ContactList').prepend(
                        '<li class="contactButton list-group-item">' +
                        '<input type="hidden" id="contactID" value="' + contactId + '">' + e.target.childNodes[1].nodeValue +
                        '</li>'
                    );
                    $('.contactButton').on('click', function (e) {
                        contactId = e.target.childNodes[0].value;
                        $('#contactNaam').html(e.target.childNodes[1].nodeValue);
                        openChat();
                    });
                    contactList.push(e.target.childNodes[1].nodeValue);
                }
                openChat();
            });
        }
    });
}


function autoRefresh() {
    $.ajax({
        url: base_url + "bericht/refreshCheck",
        dataType: 'text',
        type: "POST",
        success: function (result) {
            var obj = $.parseJSON(result);
            if (obj['status'] === "1") {
                getOngelezenBerichten(contactId);
            }
        }
    });
    timerId = setTimeout(autoRefresh, 2000);
}

function getOngelezenBerichten(contactId) {
    document.getElementById('berichtInput').value = '';
    $.ajax({
        url: base_url + "bericht/get_ongelezen",
        dataType: 'text',
        type: 'POST',
        data: {contactId: contactId},
        success: function (result) {
            var obj = $.parseJSON(result);
            printChatMessages(obj);
        }
    });
}

var ongelezen = false;
function printChatMessages(obj) {
    $.each(obj, function (index, object) {
        var newDate = getCorrectDate(object['verstuurd_op']);

        if(object['status'] === '0' && !ongelezen && ('afzender' in object)) {
            $('#chatberichten').append(
                '<span class="chatberichtOngelezen">- Ongelezen berichten -</span>'
            );
            ongelezen = true;
        }
        if (currentDate !== newDate) {
            $('#chatberichten').append(
                '<span class="chatberichtDate">' + newDate + '</span>'
            );
        }
        if ('ontvanger' in object) {
            $('#chatberichten').append(
                '<div class="chatberichtRechts">' +
                '<div class="chatberichtMessage">' + object['tekst'] + '</div>' +
                '<div class="chatberichtStamp">' + getCorrectTime(object['verstuurd_op']) + '</div>' +
                '</div>'
            );
        }
        else {
            $('#chatberichten').append(
                '<div class="chatberichtLinks">' +
                '<div class="chatberichtMessage">' + object['tekst'] + '</div>' +
                '<div class="chatberichtStamp">' + getCorrectTime(object['verstuurd_op']) + '</div>' +
                '</div>'
            );
        }
        currentDate = newDate;
    });
    var element = document.getElementById("chatberichten");
    element.scrollTop = element.scrollHeight;
}

function getChatHistory(contactId) {
    $("#chatberichten").empty();
    document.getElementById('berichtInput').value = '';
    $.ajax({
        url: base_url + "bericht/get_berichten",
        dataType: 'text',
        type: "POST",
        data: {contactId: contactId},
        success: function (result) {
            var obj = $.parseJSON(result);
            currentDate = '';
            printChatMessages(obj);
        }
    });
}

function getCorrectDate(badDate) {
    var temp = new Date(badDate);
    var day = temp.getDate();
    var month = temp.getMonth() + 1;
    var year = temp.getFullYear();

    return day + '-' + month + '-' + year;
}

function getCorrectTime(badTime) {
    var temp = new Date(badTime);
    var hour = temp.getHours();
    var minutes = (temp.getMinutes() < 10 ? '0' : '') + temp.getMinutes();
    var seconds = (temp.getSeconds() < 10 ? '0' : '') + temp.getSeconds();

    return hour + ':' + minutes + ':' + seconds;
}

function responsive() {
    if ($('#chatContainer').is(':visible')) {
        if (window.matchMedia("(min-width: 992px)").matches) {
            document.getElementById("chatContainer").style.display = "block";
            document.getElementById("contactContainer").style.display = "block";
        }
        else {
            document.getElementById("chatContainer").style.display = "block";
            document.getElementById("contactContainer").style.display = "none";
        }
    }
}