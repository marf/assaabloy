rates = [];
newWHoursCost = 0;
newTHoursCost = 0;
newKmCost = 0;
spareCost = 0;
techNumber = 1;

$(document).ready(function() {
    $.ajax({url: base_url+"getRates", success: function(result){
        rates = JSON.parse(result);
    }}).done(function() {
        newWHoursCost = parseFloat(parseFloat($('#totalWHours').val().replace(',','.'))*parseFloat(rates[0].value)).toFixed(2);
        newTHoursCost = parseFloat($('#techNumber').val()*parseFloat($('#totalTHours').val().replace(',','.'))*parseFloat(rates[1].value)).toFixed(2);
        newKmCost = parseFloat(parseFloat($('#km').val().replace(',','.'))*parseFloat(rates[2].value)).toFixed(2);

        newWHoursCost = isNaN(newWHoursCost) ? 0 : newWHoursCost;
        newTHoursCost = isNaN(newTHoursCost) ? 0 : newTHoursCost;
        newKmCost = isNaN(newKmCost) ? 0 : newKmCost;

        console.log(newWHoursCost+' '+newTHoursCost+' '+' '+newKmCost)

      });

    $('#techNumber').keyup(function() {

        if($(this).val() == '')
        {
            $('#totalTHoursCost').html('&euro; 0,00');
            newTHoursCost = 0;
        }
        else if($(this).val().match(/^\d+$/))
        {
            techNumber = parseInt($(this).val());
        
            if($('#totalTHours').val() != '')
            {
                newTHoursCost = parseFloat(techNumber*parseFloat($('#totalTHours').val().replace(',','.'))*parseFloat(rates[1].value)).toFixed(2);
                $('#totalTHoursCost').html('&euro; '+newTHoursCost);
            }
        }
        updateTotal();
      });

    $('#totalWHours').keyup(function() {
        if($(this).val() == '')
        {
            $('#totalWHoursCost').html('&euro; 0,00');
            newWHoursCost = 0;
        }
        else if($(this).val().match(/^[0-9]+([,.][0-9]+)?$/))
        {
            newWHoursCost = parseFloat(parseFloat($(this).val().replace(',','.'))*parseFloat(rates[0].value)).toFixed(2);
            $('#totalWHoursCost').html('&euro; '+newWHoursCost);
        }
        updateTotal();
      });
    
      $('#totalTHours').keyup(function() {
        if($(this).val() == '')
        {
            $('#totalTHoursCost').html('&euro; 0,00');
            newTHoursCost = 0;
        }
        else if($(this).val().match(/^[0-9]+([,.][0-9]+)?$/))
        {
            newTHoursCost = parseFloat(techNumber*(parseFloat($(this).val().replace(',','.'))*parseFloat(rates[1].value))).toFixed(2);
            $('#totalTHoursCost').html('&euro; '+newTHoursCost);
        }
        updateTotal();
      });

      $('#km').keyup(function() {
        if($(this).val() == '')
        {
            $('#totalKmCost').html('&euro; 0,00');
            newKmCost = 0;
        }
        else if($(this).val().match(/^[0-9]+([,.][0-9]+)?$/))
        {
            newKmCost = parseFloat(parseFloat($(this).val().replace(',','.'))*parseFloat(rates[2].value)).toFixed(2);
            $('#totalKmCost').html('&euro; '+newKmCost);
        }
        updateTotal();
      });

      $('#spareCost').keyup(function() {
        if($(this).val() == '')
        {
            spareCost = 0;
        }
        else if($(this).val().match(/^\d+[\.,\,]?\d+$/))
        {
            spareCost = parseFloat(parseFloat($(this).val().replace(',','.'))*parseFloat(rates[2].value)).toFixed(2);
        }
        updateTotal();
      });

      function updateTotal()
      {
          $('#totalServices').html('&euro; '+parseFloat(parseFloat(newWHoursCost)+parseFloat(newTHoursCost)+parseFloat(newKmCost)+parseFloat(spareCost)).toFixed(2));
      }
});