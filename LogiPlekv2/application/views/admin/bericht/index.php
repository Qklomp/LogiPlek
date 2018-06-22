<ol class="breadcrumb">
    <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
    <li class="active">Berichten</li>
</ol>

<div class="panel panel-default">

    <div class="panel-heading">
        <ul class="list-inline">
            <li><h2><?php echo $title ?></h2></li>
        </ul>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4 col-sm-12 container" id="contactContainer">
                <div class="row">
                    <input type="text" id="searchInput" class="form-control" placeholder="..."/>
                </div>
                <div class="row" style="display: none;" id="ContactSearchDiv">
                    <ul class="list-group" id="searchList">

                    </ul>
                </div>
                <div class="row" style="display: block" id="ContactDiv">
                    <ul class="list-group" id="ContactList">
                    </ul>
                </div>
            </div>
            <div class="col-md-8 col-sm-12 container" style="display: none;" id="chatRightColumn">
                <div id="contactNaam" class="row">
                    &nbsp;
                </div>
                <div id="chatberichten" class="row">
                </div>
                <br>
                <div class="row">
                    <input id="berichtInput" placeholder="Bericht" value="">
                    <input type="button" id="sendButton" class="btn btn-primary" value="Send"/>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript"></script>
<script>
    var timerId, contactId, searchValue, contactList;
    contactList = new Array();

    $(document).ready(function () {
        $('#searchInput').on('input', function (e) {
            searchValue = e.target.value;
            searchCheck();
        });

        $('#sendButton').on('click', function () {
            $.ajax({
                url: "<?php echo base_url();?>bericht/verstuur_bericht",
                dataType: 'text',
                type: "POST",
                data: {contactId: contactId, bericht: $('#berichtInput').val()},
                success: function () {
                    getChatHistory(contactId);
                }
            })
        });

        $.ajax({
            url: "<?php echo base_url();?>bericht/get_contacten",
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
            url: "<?php echo base_url();?>bericht/contactSearch",
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
            url: "<?php echo base_url();?>bericht/refreshCheck",
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
            url: "<?php echo base_url();?>bericht/get_chat",
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
</script>
