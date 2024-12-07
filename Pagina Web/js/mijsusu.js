$(function() {

  cargargrilla();

  $( "#txt" ).on( "keyup", function() {
    cargargrilla();
  });

});

function cargargrilla()
{
  $.ajax({
    type: "POST",
    url: 'grillausu.php',
    data: 'txt='+$("#txt").val(),
    success: function(response)
    {  
      $('#menu3').html(response);
    }
  });
}

$(document).ready(function(){
  $("#regiones").change(function() {
      $.ajax({
          type: "POST",
          url: 'cargar_combobox.php',
          data: 'id='+$("#regiones").val()+'&tipo=1',
          success: function(response)
          {  
              $("#provincia").html(response);        
          }
      });
  });
  $("#provincia").change(function() {
      $.ajax({
          type: "POST",
          url: 'cargar_combobox.php',
          data: 'id='+$("#provincia").val()+'&tipo=2',
          success: function(response)
          {  
              $("#comuna").html(response);        
          }
      });
  });
});