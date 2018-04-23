<ol class="breadcrumb">
  <li><a href="/dashboard/" class="active"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
  <li><a href="" class="active"> Updates</a></li>
</ol>

<div class="col-lg-4 col-lg-offset-4">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3>Updates <small>Werkt iets niet? Mail het naar <a href="mailto:info@mauricekleine.nl">info@mauricekleine.nl</a></h3>
    </div>
    <div class="panel-body">
      <?php foreach ($updates as $update): ?>
        <p><strong><?php echo nl_date($update['datum'])?> </strong> <?php echo $update['update'] ?></p>
        <hr>
      <?php endforeach ?>
    </div>
    <div class="panel-footer">
      <ul class="list-inline">          
        <li><a href="/dashboard/" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-arrow-left"></i> Terug</span></a></li>
      </ul>
    </div>
  </div>
</div>
