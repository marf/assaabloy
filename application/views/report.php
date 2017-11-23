  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
    $( function() {
      $.datepicker.setDefaults($.datepicker.regional['it']);
      $( "#datepicker" ).datepicker();
    } );
  </script>
  <div class="container">
  <br>
    <div style="text-align: center"><h1>Inserisci report</h1></div>
    <br>
    <?php echo isset($error) ? $error : ''; ?>
    <br>
    <form method="POST" action="<?php echo base_url(); ?>report"> 
      <div class="form-group row">
        <label for="inputPassword3" class="col-sm-2 col-form-label"><b>Data</b></label>
        <div class="col-sm-3">
          <input type="text" class="form-control" id="datepicker" name='date' value="<?php echo isset($info[0]) ? $info[0] : ''; ?>">
        </div>
      </div>
      <div class="form-group row">
        <label for="inputPassword3" class="col-sm-2 col-form-label"><b>OFO</b></label>
        <div class="col-sm-6">
          <input type="text" class="form-control" id="ofo" name='ofo' placeholder="17/05389" value="<?php echo isset($info[1]) ? $info[1] : ''; ?>">
        </div>
      </div>
      <div class="form-group row">
        <label for="inputPassword3" class="col-sm-2 col-form-label"><b>Numero chiamata</b></label>
        <div class="col-sm-6">
          <input type="text" class="form-control" id="callNumber" name='callNumber' placeholder="17/0000005766" value="<?php echo isset($info[2]) ? $info[2] : ''; ?>">
        </div>
      </div>
      <div class="form-group row">
        <label for="inputPassword3" class="col-sm-2 col-form-label"><b>Cliente</b></label>
        <div class="col-sm-6">
          <input type="text" class="form-control" id="client" name='client' placeholder="COOP" value="<?php echo isset($info[8]) ? $info[8] : ''; ?>">
        </div>
      </div>
      <div class="form-group row">
        <label for="inputPassword3" class="col-sm-2 col-form-label"><b>Sede intervento</b></label>
        <div class="col-sm-6">
          <input type="text" class="form-control" id="interventionPlace" name='interventionPlace' placeholder="Rubiera" value="<?php echo isset($info[9]) ? $info[9] : ''; ?>">
        </div>
      </div>
      <div class="form-group row">
        <label for="inputPassword3" class="col-sm-2 col-form-label"><b>Numero tecnici</b></label>
        <div class="col-sm-2">
          <input type="number" class="form-control" id="techNumber" name='techNumber' placeholder="1" value="1" value="<?php echo isset($info[3]) ? $info[3] : ''; ?>">
        </div>
      </div>
      <div class="form-group row">
        <label for="inputPassword3" class="col-sm-2 col-form-label"><b>Ore manodopera</b></label>
        <div class="col-sm-2">
          <input type="number" step="0.1" class="form-control" id="totalWHours" name='totalWHours' placeholder="1,5" value="<?php echo isset($info[4]) ? $info[4] : ''; ?>">
        </div>
        <label for="inputPassword3" class="col-sm-2 col-form-label"><h6 id="totalWHoursCost"><?php echo isset($WCost) ? $WCost : '&euro; 0,00'; ?></h6></label>
      </div>
      <div class="form-group row">
        <label for="inputPassword3" class="col-sm-2 col-form-label"><b>Ore vaggio</b></label>
        <div class="col-sm-2">
          <input type="number" step="0.1" class="form-control" id="totalTHours" name='totalTHours' placeholder="1" value="<?php echo isset($info[5]) ? $info[5] : ''; ?>">
        </div>
        <label for="inputPassword3" class="col-sm-3 col-form-label"><h6 id="totalTHoursCost"><?php echo isset($TCost) ? $TCost : '&euro; 0,00'; ?></h6></label>
      </div>
      <div class="form-group row">
        <label for="inputPassword3" class="col-sm-2 col-form-label"><b>Chilometraggio</b></label>
        <div class="col-sm-2">
          <input type="number" step="0.1" class="form-control" id="km" name='km' placeholder="40" value="<?php echo isset($info[6]) ? $info[6] : ''; ?>">
        </div>
        <label for="inputPassword3" class="col-sm-2 col-form-label"><h6 id="totalKmCost"><?php echo isset($kmCost) ? $kmCost : '&euro; 0,00'; ?></h6></label>
      </div>
      <div class="form-group row">
        <label for="inputPassword3" class="col-sm-2 col-form-label">Costo ricambi (opzionale)</label>
        <div class="col-sm-2">
          <input type="number" step="0.01" class="form-control" id="spareCost" name='spareCost' placeholder="150,00" value="<?php echo isset($info[7]) ? $info[7] : ''; ?>">
        </div>
      </div>
      <div class="form-group row">
        <label for="inputPassword3" class="col-sm-4 col-form-label"><h1 id="totalServices"><?php echo isset($total) ? $total : '&euro; 0,00'; ?></h1></label>
      </div>
      <!--<fieldset class="form-group row">
        <legend class="col-form-legend col-sm-2">Radios</legend>
        <div class="col-sm-10">
          <div class="form-check">
            <label class="form-check-label">
              <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1" checked>
              Option one is this and that&mdash;be sure to include why it's great
            </label>
          </div>
          <div class="form-check">
            <label class="form-check-label">
              <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2">
              Option two can be something else and selecting it will deselect option one
            </label>
          </div>
          <div class="form-check disabled">
            <label class="form-check-label">
              <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios3" value="option3" disabled>
              Option three is disabled
            </label>
          </div>
        </div>
      </fieldset>
      <div class="form-group row">
        <label class="col-sm-2">Checkbox</label>
        <div class="col-sm-10">
          <div class="form-check">
            <label class="form-check-label">
              <input class="form-check-input" type="checkbox"> Check me out
            </label>
          </div>
        </div>
      </div>-->
      <div class="form-group row">
        <div class="col-sm-10">
          <button type="submit" class="btn btn-primary btn-lg">Inserisci</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script src="js/report.js"></script>
