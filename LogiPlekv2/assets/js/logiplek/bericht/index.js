var timerId, contactId, searchValue, contactList;
contactList = new Array();

$(document).ready(function () {
    $('#searchInput').on('input', function (e) {
        searchValue = e.target.value;
        searchCheck();
    });

    $('#sendButton').on('click', function () {
        if($('#berichtInput').val() !== '')
        {
            $.ajax({
                url: base_url + "bericht/verstuur_bericht",
                dataType: 'text',
                type: "POST",
                data: {contactId: contactId, bericht: $('#berichtInput').val()},
                success: function () {
                    getChatHistory(contactId);
                }
            })
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
                    '<input type="hidden" id="contactID" value="'+ index +'"> '+ object +
                    '</li>'
                );
                contactList.push(object);
            });
            $('.contactButton').on('click', function (e) {
                contactId = e.target.childNodes[0].value;
                $('#contactNaam').html(e.target.childNodes[1].nodeValue);
                openChat();
            });
        }
    });
});

function openChat()
{
    $('#chatRightColumn').show();
    getChatHistory(contactId);
    clearTimeout(timerId);
    timerId = setTimeout(autoRefresh, 2000);
}

function searchCheck() {
    if (searchValue != '') {
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
                    '<input type="hidden" id="contactID" value="'+ object['id'] +'"> '+ object['voornaam'] + ' ' + object['achternaam'] +
                    '</li>'
                );
            });
            $('.contactSearchButton').on('click', function (e) {
                contactId = e.target.childNodes[0].value;
                $('#contactNaam').html(e.target.childNodes[1].nodeValue);
                $('#searchInput').val('').trigger('input');

                if(contactList.indexOf(e.target.childNodes[1].nodeValue) === -1)
                {
                    $('#ContactList').prepend(
                        '<li class="contactButton list-group-item">' +
                        '<input type="hidden" id="contactID" value="'+ contactId +'"> '+ e.target.childNodes[1].nodeValue +
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
                getChatHistory(contactId)
            }
        }
    });
    timerId = setTimeout(autoRefresh, 2000);
}

function getChatHistory(contactId) {
    $("#chatberichten").empty();
    document.getElementById('berichtInput').value = '';
    $.ajax({
        url: base_url + "bericht/get_chat",
        dataType: 'text',
        type: "POST",
        data: {contactId: contactId},
        success: function (result) {
            var obj = $.parseJSON(result);
            var currentDate = '';
            $.each(obj, function (index, object) {
                var newDate = getCorrectDate(object['verstuurd_op']);
                if (currentDate !== newDate) {
                    $('#chatberichten').append(
                        '<span class="chatberichtDate">' + newDate + '</span>'
                    );
                }
                if ('ontvanger' in object) {
                    $('#chatberichten').append(
                        '<div class="chatberichtRechts">' + object['tekst'] + '</div>'
                    );
                }
                else {
                    $('#chatberichten').append(
                        '<div class="chatberichtLinks">' + object['tekst'] + '</div>'
                    );
                }
                currentDate = newDate;
            });
            var element = document.getElementById("chatberichten");
            element.scrollTop = element.scrollHeight;
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