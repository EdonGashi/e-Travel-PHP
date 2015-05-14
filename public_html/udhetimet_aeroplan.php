<?php
require_once("../resources/config.php");

$header_titulli = "Udhetimet Aeroplan";
$css_includes = Array("css/form.css", "css/site.css");
$script_includes = jquery;
$header_script = <<< SCRIPT
  $( document ).ready( function () {
    $( ".id-submit" ).click ( function () {
      $( "input[id=udhetimiId]" ).val( this.id );
    });
  });
SCRIPT;

require(templates_header);
require(databaza);

$repo = new repository();
$rez = $repo->get_data("Select * From udhetimetAeroplan Where Data >= Now()");
?>

<section class="permbajtje">
<h2 style="margin-bottom:10px;">Udhetimet me aeroplan</h2>
<?php

	echo "<form method='Post' action='rezervo_aeroplan.php'><input type='hidden' id='udhetimiId' name='udhetimiId'>";
    echo "<table class='tabela' cellspacing='0'> <thead><th align='left'>Prej</th><th align='left'>Deri</th><th align='left'>Nr Ulseve</th><th align='left'>Data</th><th align='left'>Cmimi</th><th style='width: auto;'></th></thead>";
    foreach ($rez as $rreshti){
        echo "<tr><td>".$rreshti['Prej']."</td><td>".$rreshti['Deri']."</td><td>".$rreshti['Ulese']."</td><td>".$rreshti['Data']."</td><td>".$rreshti['Cmimi']." &#8364;</td><td style='text-align: center'>"
                . "<input type='submit' value='Rezervo' class='button button-small id-submit' id='id_".$rreshti['Rid']."'></td></tr>";
    }
    echo "</form></table>";
?>

</section>

<?php
require(templates_footer);
?>
