         <!-- END MAIN -->
        </div>

      <!-- END ROW -->
      </div>

    <!-- END CONTAINER -->
    </div>

    <div id="footer">
       <span class="muted credit pull-right"><a href="http://www.mauricekleine.nl" target="_blank">&copy 2015 Maurice Kleine</a></span>
    </div>

    <!-- SCRIPTS -->
    <script src="<?php echo asset_url() ?>js/jquery.min.js"></script> 
    <script src="<?php echo asset_url() ?>js/bootstrap.min.js"></script>    
<?php if(!empty($js)): ?>
  <?php foreach($js as $script): ?>
  <script src="<?php echo asset_url() . 'js/' . $script . '.js'?>"></script>
  <?php endforeach ?>    
<?php endif ?>
    <script src="<?php echo asset_url() ?>js/logiplek/logiplek.js"></script>

  </body>
</html>