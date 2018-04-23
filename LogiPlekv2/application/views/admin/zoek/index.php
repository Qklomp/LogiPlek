<ol class="breadcrumb">
  <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
  <li class="active">Zoekresultaten</li>
</ol>

<?php echo (isset($toegevoegd)) ? '<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert">×</button>De gegevens zijn toegevoegd!</div>' : '' ?>
<?php echo (isset($aangepast)) ? '<div class="alert alert-dismissable alert-info"><button type="button" class="close" data-dismiss="alert">×</button>De gegevens zijn aangepast!</div>' : '' ?>
<?php echo (isset($verwijderd)) ? '<div class="alert alert-dismissable alert-warning"><button type="button" class="close" data-dismiss="alert">×</button>De gegevens zijn verwijderd!</div>' : '' ?>

<div class="panel panel-default table-responsive">

  <div class="panel-heading">
    <ul class="list-inline">   
      <li><h2><?php echo $title ?> <small><?php echo $hits ?> <?php echo ($hits > 1) ? 'resultaten' : 'resultaat' ?> voor zoekterm: <i><?php echo $query ?></i></h2></li>
    </ul>    
  </div>

  <div class="panel-body">

    <?php if (count($autos) != 0): ?>
      <table class="table table-striped table-bordered table-hover table-condensed searchTable">
        <h3 class="text-center"><i class="fa fa-truck"></i> <?php echo count($autos)?> auto<?php echo (count($autos) > 1) ? '\'s' : '' ?> </h3>
        <thead> 
          <tr>
            <th>Autonummer</th>
            <th>Kenteken</th>
            <th>Km-stand</th>
            <th>Route</th>
            <th>Type</th>        
            <th class="narrow text-center"></th>
          </tr>
        </thead> 

        <tbody>
          <?php foreach ($autos as $auto): ?>
          <tr> 
            <td><a href="/autos/<?php echo $auto['id']?>">&nbsp;<?php echo $auto['autonummer'] ?></a></a></td>        
            <td><a href="/autos/<?php echo $auto['id']?>">&nbsp;<?php echo $auto['kenteken'] ?></a></td>
            <td><a href="/autos/<?php echo $auto['id']?>">&nbsp;<?php echo $auto['kmstand'] ?></a></td>
            <td><a href="/autos/<?php echo $auto['id']?>">&nbsp;<?php echo $auto['routenummer'] ?></a></td>
            <td><a href="/autos/<?php echo $auto['id']?>">&nbsp;<?php echo $auto['type'] ?></a></td>
            <td class="text-center"><a href="/autos/<?php echo $auto['id']?>"><i class="glyphicon glyphicon-search"></i></a></td> 
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    <?php endif ?>

    <?php if (count($koeriers) != 0): ?>
      <table class="table table-striped table-bordered table-hover table-condensed searchTable">
        <h3 class="text-center"><i class="fa fa-rocket"></i> <?php echo count($koeriers)?> koerier<?php echo (count($koeriers) > 1) ? 's' : '' ?> </h3>
        <thead> 
          <tr>
            <th>Naam</th>
            <th>Contact</th>
            <th>Telefoonnummer</th>
            <th>Mobiel</th>        
            <th>Kosten/Km</th>
            <th>Koeling</th>
            <th>Omgeving</th>
            <th class="narrow text-center"></th>
          </tr>
        </thead> 

        <tbody>
          <?php foreach ($koeriers as $koerier): ?>
            <tr>          
              <td><a href="/koeriers/<?php echo $koerier['id']?>">&nbsp;<?php echo $koerier['naam'] ?></a></td>                
              <td><a href="/koeriers/<?php echo $koerier['id']?>">&nbsp;<?php echo $koerier['contact'] ?></a></td>
              <td><a href="/koeriers/<?php echo $koerier['id']?>">&nbsp;<?php echo $koerier['nummer'] ?></a></td>
              <td><a href="/koeriers/<?php echo $koerier['id']?>">&nbsp;<?php echo $koerier['contact_nummer'] ?></a></td>
              <td><a href="/koeriers/<?php echo $koerier['id']?>">&nbsp;<?php echo $koerier['kosten_km'] ?></a></td>
              <td><a href="/koeriers/<?php echo $koerier['id']?>">&nbsp;<?php echo $koerier['koeling'] ?></a></td>
              <td><a href="/koeriers/<?php echo $koerier['id']?>">&nbsp;<?php echo $koerier['omgeving'] ?></a></td>
              <td class="text-center"><a href="/koeriers/<?php echo $koerier['id']?>"><i class="glyphicon glyphicon-search"></i></a></td> 
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    <?php endif ?>

    <?php if (count($personeel) != 0): ?>
      <table class="table table-striped table-bordered table-hover table-condensed searchTable">
        <h3 class="text-center"><i class="fa fa-users"></i> <?php echo count($personeel)?> personeel </h3>
        <thead> 
          <tr>
            <th>Naam</th>
            <th>Telefoonnummer</th>
            <th>Mobiel</th>
            <th>Adres</th>
            <th>Woonplaats</th>
            <th class="narrow text-center"></th>
          </tr>
        </thead> 
        <tbody>    
          <?php foreach ($personeel as $personeel): ?>
          <tr> 
            <td><a href="/personeel/<?php echo $personeel['id']?>">&nbsp;<?php echo $personeel['voornaam'] . ' ' . $personeel['achternaam'] ?></a></td>     
            <td><a href="/personeel/<?php echo $personeel['id']?>">&nbsp;<?php echo $personeel_telefoon[$personeel['id']]['vast'] ?></a></td>
            <td><a href="/personeel/<?php echo $personeel['id']?>">&nbsp;<?php echo $personeel_telefoon[$personeel['id']]['mobiel'] ?></a></td>
            <td><a href="/personeel/<?php echo $personeel['id']?>">&nbsp;<?php echo $personeel['straat'] . ' ' . $personeel['huisnummer'] ?></a></td>
            <td><a href="/personeel/<?php echo $personeel['id']?>">&nbsp;<?php echo $personeel['plaats'] ?></a></td>        
            <td class="text-center"><a href="/personeel/<?php echo $personeel['id']?>"><i class="glyphicon glyphicon-search"></i></a></td> 
           </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    <?php endif ?>

    <?php if (count($routes) != 0): ?>
      <table class="table table-striped table-bordered table-hover table-condensed searchTable">
        <h3 class="text-center"><i class="fa fa-road"></i> <?php echo count($routes)?> route<?php echo (count($routes) > 1) ? 's' : '' ?> </h3>
        <thead> 
          <tr>
            <th>Route</th>
            <th>Snelnummer</th>
            <th>Telefoonnummer</th>
            <th>Type</th>  
            <?php foreach (array('ma', 'di', 'wo', 'do', 'vr', 'za', 'zo') as $dag) {
              echo '<th class="narrow">' . $dag . '</th>';
            }?>  
            <th class="narrow text-center"></th>
          </tr>
        </thead>  

        <tbody>
          <?php foreach ($routes as $route): ?>
          <tr> 
            <td><a href="/routes/<?php echo $route['id']?>">&nbsp;<?php echo $route['routenummer'] ?></a></a></td>        
            <td><a href="/routes/<?php echo $route['id']?>">&nbsp;<?php echo $route['snelnummer'] ?></a></td>
            <td><a href="/routes/<?php echo $route['id']?>">&nbsp;<?php echo $route['telefoonnummer'] ?></a></td>
            <td><a href="/routes/<?php echo $route['id']?>">&nbsp;<?php echo $route['type'] ?></a></td>
            <?php foreach (array('ma', 'di', 'wo', 'do', 'vr', 'za', 'zo') as $dag) {
              echo '<td class="text-center">' . (isset($route_tijden[$route['id']][$dag]) ? $route_tijden[$route['id']][$dag] : '') . '</td>';
            }?>       
            <td class="text-center"><a href="/routes/<?php echo $route['id']?>"><i class="glyphicon glyphicon-search"></i></a></td> 
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    <?php endif ?>

    <?php if (count($steunpunten) != 0): ?>
      <table class="table table-striped table-bordered table-hover table-condensed searchTable">
        <h3 class="text-center"><i class="glyphicon glyphicon-shopping-cart"></i> <?php echo count($steunpunten)?> steunpunt<?php echo (count($steunpunten) > 1) ? 'en' : '' ?> </h3>
        <thead> 
          <tr>
            <th>Naam</th>
            <th>Contact</th>
            <th>Telefoonnummer</th>
            <th>Mobiel</th>
            <th>Adres</th>
            <th>Plaats</th>        
            <th></th>
            <th class="narrow text-center"></th>
          </tr>
        </thead> 

        <tbody>
          <?php foreach ($steunpunten as $steunpunt): ?>
            <tr>
              <td><a href="/steunpunten/<?php echo $steunpunt['id']?>">&nbsp;<?php echo $steunpunt['naam'] ?></a></td>        
              <td><a href="/steunpunten/<?php echo $steunpunt['id']?>">&nbsp;<?php echo $steunpunt['contact'] ?></a></td>
              <td><a href="/steunpunten/<?php echo $steunpunt['id']?>">&nbsp;<?php echo $steunpunten_telefoon[$steunpunt['id']]['vast'] ?></a></td>
              <td><a href="/steunpunten/<?php echo $steunpunt['id']?>">&nbsp;<?php echo $steunpunten_telefoon[$steunpunt['id']]['mobiel'] ?></a></td>
              <td><a href="/steunpunten/<?php echo $steunpunt['id']?>">&nbsp;<?php echo $steunpunt['straat'] . ' ' . $steunpunt['huisnummer'] ?></a></td>
              <td><a href="/steunpunten/<?php echo $steunpunt['id']?>">&nbsp;<?php echo $steunpunt['plaats'] ?></a></td>
              <td class="text-center assortiment">
                <?php foreach ($assortimenten as $a): ?> 
                  <?php if(isset($steunpunt_assortiment[$steunpunt['id']][$a['id']])): ?>
                    <span class="label label-success" id="<?php echo $a['id'] ?>"><?php echo $a['type']?></span>
                  <?php endif ?>
                <?php endforeach ?>
              </td>
              <td class="text-center"><a href="/steunpunten/<?php echo $steunpunt['id']?>"><i class="glyphicon glyphicon-search"></i></a></td> 
            </tr>
          <?php endforeach ?>     
        </tbody>
      </table>
    <?php endif ?>
  </div>

  <div class="panel-footer">   
  </div>
</div>