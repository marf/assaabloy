  <div class="container">
  <br>
    <div style="text-align: center"><h1>Reports</h1></div>
    <br>
    <?php echo isset($error) ? $error : ''; ?>
    <br>
    <div class="form-group">
      <label for="sel1">Mese:</label>
      <select class="form-control" id="months">
        <option value=0>Tutti</option>
        <option value=1>Gennaio</option>
        <option value=2>Febbraio</option>
        <option value=3>Marzo</option>
        <option value=4>Aprile</option>
        <option value=5>Maggio</option>
        <option value=6>Giugno</option>
        <option value=7>Luglio</option>
        <option value=8>Agosto</option>
        <option value=9>Settembre</option>
        <option value=10>Ottobre</option>
        <option value=11>Novembre</option>
        <option value=12>Dicembre</option>
      </select>
    </div>
    <br>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Data</th>
          <th>OFO</th>
          <th>Numero chiamata</th>
          <th>Cliente</th>
          <th>Sede intervento</th>
          <th>Numero tecnici</th>
          <th>Ore manodopera</th>
          <th>Ore viaggio</th>
          <th>Km</th>
          <th>Costo totale</th>
          <th>Azioni</th>
        </tr>
      </thead>
      <tbody class="reports">
        <?php 
          /*for($i = 0; $i < count($reports); $i++)
          {
            echo "<tr><th>".($i+1)."</th>
            <td>".$reports[$i]->date."</td>
            <td>".$reports[$i]->ofo."</td>
            <td>".$reports[$i]->callNumber."</td>
            <td>".$reports[$i]->client."</td>
            <td>".$reports[$i]->interventionPlace."</td>
            <td>".$reports[$i]->techNum."</td>
            <td>".$reports[$i]->totalWHours."</td>
            <td>".$reports[$i]->totalTHours."</td>
            <td>".$reports[$i]->km."</td>
            <td>".$reports[$i]->totalCost."</td></tr>";

            $i++;
          }*/
        ?>
      </tbody>
    </table>
  </div>
</div>

<script>
$("#months")
  .change(function () {
    var str = "";
    $( "#months option:selected" ).each(function() {
      loadReports($(this).val());
    });
  })
  .change();

  $('body').on('click', 'button.delete', function() {
    var r = confirm("Sei sicuro di volere cancellare questo report?");
    if (r == true) {
      //$('.table').find("[data-row='" + $(this).data( "report" ) + "']").remove();
      deleteReport($(this).data("report"));
    }

  });

  function loadReports(_month)
  {
    $.ajax({
          url: base_url+"getReportsAsync", 
          method: "POST",
          data: { month : _month },
          success: function(result){
            reports = JSON.parse(result);
            output = "";
            for(var i = 0; i < reports.length; i++)
            {
                output += `<tr class="report" data-row="`+reports[i].id+`"><th>`+(i+1)+`</th>
                            <td>`+reports[i].date+`</td>
                            <td>`+reports[i].ofo+`</td>
                            <td>`+reports[i].callNumber+`</td>
                            <td>`+reports[i].client+`</td>
                            <td>`+reports[i].interventionPlace+`</td>
                            <td>`+reports[i].techNum+`</td>
                            <td>`+reports[i].totalWHours+`</td>
                            <td>`+reports[i].totalTHours+`</td>
                            <td>`+reports[i].km+`</td>
                            <td>&euro; `+parseFloat(reports[i].totalCost).toFixed(2)+`</td>
                            <td><p data-placement="top" data-toggle="tooltip" title="" data-original-title="Edit">
                              <button class="btn btn-danger btn-xs delete" data-title="Edit" data-toggle="modal"  data-report="`+reports[i].id+`" data-target="#edit">
                              <i class="fa fa-trash" aria-hidden="true"></i>
                              </button></p></td>
                            </tr>`
            }
            $('.reports').html(output);
        }});
    }

    function deleteReport(_reportID){
      $.ajax({
          url: base_url+"deleteReportAsync", 
          method: "POST",
          data: { reportID : _reportID },
          success: function(result){
            loadReports($("#months option:selected").val());
        }});
    }


</script>