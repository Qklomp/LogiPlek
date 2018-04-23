<ol class="breadcrumb">
  <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
  <li><a href="/ritregistratie/">Ritregistratie</a></li>
  <li>Extern</li>
  <li class="active"><?php echo $title; ?></li>
</ol>


<div class="panel panel-default">

  <div class="panel-heading">
    <ul class="list-inline">   
      <li><h2>Externe ritten, <?php echo $title ?></h2></li>
    </ul>    
  </div>

  <div class="panel-body">

    <div id="spinner" class="text-center text-success">
      <i class="fa fa-spinner fa-spin fa-5x"></i>
    </div>
    <div id="content" style="overflow-x: scroll;">
      <canvas id="myChart"></canvas>
    </div>

  </div>
  <div class="panel-footer">
    <ul class="list-inline">          
      <!-- <li><a href="/autos/toevoegen/" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i> Toevoegen</a></li> -->
    </ul>
  </div>
</div>