         <!-- END MAIN -->
        </div>

      <!-- END ROW -->
      </div>

    <!-- END CONTAINER -->
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