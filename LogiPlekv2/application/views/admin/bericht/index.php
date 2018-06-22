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
