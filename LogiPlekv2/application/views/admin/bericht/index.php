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
            <div class="col-md-4" style="min-height: 1000px">
                <ul class="list-group">
                    <?php foreach ($contacten as $key => $value): ?>
                        <li class="contactButton list-group-item">
                            <input type="hidden" id="contactID" value="<?php echo $key; ?>"> <?php echo $value?>
                        </li>
                        <hr>
                    <?php endforeach ?>
                </ul>
            </div>
            <div class="col-md-8 container" style="min-height: 1000px">
                <div id="chatberichten">
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-10">
                        <input id="berichtInput" placeholder="Bericht" value="">
                    </div>
                    <div class="col-lg-2">
                        <button id="sendButton" class="fa fa-send-o" style="font-size:36px"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function(){
        $('.contactButton').on('click',function (e){
            contactId = e.target.childNodes[1].value;
            getChatHistory(contactId);
        });


        $('#sendButton').on('click',function (e){
            console.log(contactId);
            $.ajax({
                url: "<?php echo base_url();?>bericht/verstuur_bericht",
                dataType: 'text',
                type: "POST",
                data: {contactId: contactId, bericht: $('#berichtInput').val()},
                success: function (result) {
                    getChatHistory(contactId);
                }
            })
        });
    });
    function getChatHistory(contactId)
    {
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
                $.each(obj,function(index, object) {
                    var newDate = getCorrectDate(object['verstuurd_op']);
                    if(currentDate !== newDate)
                    {
                        $('#chatberichten').append(
                            '<span class="chatberichtDate">' + newDate + '</span>'
                        );
                    }
                    if('ontvanger' in object)
                    {
                        $('#chatberichten').append(
                            '<div class="chatberichtRechts">' + object['tekst'] + '</div>'
                        );
                    }
                    else
                    {
                        $('#chatberichten').append(
                            '<div class="chatberichtLinks">' + object['tekst'] + '</div>'
                        );
                    }
                    currentDate = newDate;
                });
            }
        })
    }
    function getCorrectDate(badDate)
    {
        var temp = new Date(badDate);
        var day = temp.getDate();
        var month = temp.getMonth() + 1;
        var year = temp.getFullYear();

        return day + '-' + month + '-' + year;
    }
</script>
