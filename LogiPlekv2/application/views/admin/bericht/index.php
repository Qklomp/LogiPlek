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
        <div class="col-md-4 col-sm-12 container" id="contactContainer">
            <div class="row">
                <input type="text" class="form-control" id="searchInput" placeholder="..."/>
            </div>
            <hr style="margin-bottom: 5px;">
            <div class="row" style="display: block" id="ContactDiv">
                <ul class="list-group" id="ContactList">
                </ul>
            </div>
            <div class="row" style="display: none;" id="ContactSearchDiv">
                <ul class="list-group" id="searchList">

                </ul>
            </div>
        </div>
        <div class="col-md-8 col-sm-12 container" style="display: none;" id="chatContainer">
            <div class="row" id="chatContainerHeader">
                <div id="terugButtonDiv">
                    <i id="terugButton" class="fa fa-chevron-circle-left"></i>
                </div>
                <div id="contactNaam"></div>
            </div>
            <div id="chatberichten" class="row">

            </div>
            <div class="row" id="chatContainerFooter">
                <input id="berichtInput" placeholder="Bericht..." value="">
                <button type="button" id="sendButton" class="btn btn-primary">
                    <i class="fa fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>
