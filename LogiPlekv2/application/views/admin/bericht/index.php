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
                <div class="row"></div>
                        <div class="col-lg-10">
                            <input id="berichtInput" placeholder="Bericht" value="">
                        </div>
                        <div class="col-lg-2" id="sendButton">
                            <label id="sendButton"><i class="fa fa-send-o" style="font-size:36px"></i></label>
                        </div>
            </div>

        </div>
    </div>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function(){
        $('.contactButton').on('click',function (e){
            $("#chatberichten").empty();
            var contactId = e.target.childNodes[1].value;
            $.ajax({
                url: "<?php echo base_url();?>bericht/get_Chat",
                dataType: 'text',
                type: "POST",
                data: {contactId: contactId},
                success: function (result) {
                    var obj = $.parseJSON(result);
                    $.each(obj,function(index, object) {
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

                    });
                }
            })
        });
    });
</script>
