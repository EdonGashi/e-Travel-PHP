<?php
require_once("../resources/config.php");

if (!isset($_SESSION)) {
    session_start();
}

require(databaza);
$db = new repository;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['komenti']))
{
    if (!isset($_SESSION['Username']) || !isset($_SESSION['Emri']) || !isset($_SESSION['Mbiemri']))	{
        header("Location: /login.php");
    } else {
        $komenti = $_POST['komenti'];
        $komentuesi = $_SESSION['Username'];
        $db->execute("Insert Into forumi(ChatID, Komentuesi, Komenti, Data) values (%d,%s,%s, Now())", $_GET["id"], $komentuesi, $komenti);
        header('Location: /lokacionet.php?id='. $_GET['id']);
	    exit;
    }
}

$header_titulli = "Lokacionet";
$css_includes = Array("../css/form.css", "../css/site.css");
$header_style = <<< STYLE
#googleMap {
    height: 100%;
    margin: 0;
    padding: 0;
}
STYLE;
require(templates_header);
?>

<section class="permbajtje">
    <?php
	if (!isset($_GET["id"]))
	{
        echo "<h1>Lokacionet</h1>";
        $rows = $db->lokacionet;
        foreach ($rows as $rreshti) {
            echo "<section style='padding: 12px; margin-top: 20px; border: 1px solid #ccc'>";
            echo "<form method='GET' action='" . $_SERVER["PHP_SELF"] . "'>";
            if (file_exists("img/content/" . $rreshti['Foto'])) {
                echo "<img src='img/content/" . $rreshti['Foto'] . "' style='float:left; margin: 0 15px 5px 0' width='200px;' />";
            }
            
            echo "<h1 style='display: inline-block; margin-top: 5px'>" . htmlentities($rreshti['Vendi']) . "</h1>";
            echo "<p class='padded'>";
            if (strlen($rreshti['Pershkrimi']) > 260) {
                echo htmlentities(substr($rreshti['Pershkrimi'], 0, 260));
                echo "...";
            } else {
                echo htmlentities($rreshti['Pershkrimi']);
            }
            echo "</p>";
            
			echo "<div style='text-align: right'><button class='button button-small' type='submit' name='id' value=" . $rreshti['Lid'] . ">Lexo me shume</button></div>";
            echo "</form>";
            echo "<div style='clear: both'></div>";
            echo "</section>";
		}
	} else {
		$rreshti = $db->get_data("SELECT * FROM lokacione WHERE Lid=%d", $_GET['id']);
        if (empty($rreshti))
        {
            echo "<h1>Lokacioni nuk ekziston.</h1>";
            require(templates_footer);
            exit;
        }
        
        $rreshti = $rreshti[0];
		echo "<div class='padded'>
		        <h1 style='margin-bottom: 15px; font-size: 30px'>" . htmlentities($rreshti['Vendi']) . "</h1>";
        
        if (file_exists("img/content/" . $rreshti['Foto'])) {
            echo "<img src='img/content/" . $rreshti['Foto'] . "' style='margin: 5px 0 10px 15px; float: right; width='280;' />";
        }
        
        echo "<p style='text-align: justify; line-height: 1.4'> " . htmlentities($rreshti["Pershkrimi"]) . "</p>
              </div><div style='clear: both'></div>";
    ?>

    <script
        src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDY0kkJiTPVd2U7aTOAwhc9ySH6oHxOIYM&sensor=false">
    </script>
    <script src="js/merr_koordinatat.js"></script>
    <script>
        function shfaqMap(lat, lng) {
            document.getElementById("harta-mbajtesi").innerHTML = '<div id="googleMap" style="width: 100%; height: 200px;"></div>';
            var myCenter = new google.maps.LatLng(lat, lng);
            var mapProp = {
                center: myCenter,
                zoom: 10,
                disableDefaultUI: true,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
            };

            var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(lat, lng)
            });

            marker.setMap(map);
        }

        var shfaqurGabimin = false;

        function gabim() {
            if (shfaqurGabimin) return;
            shfaqurGabimin = true;
            document.getElementById("harta-mbajtesi").innerHTML = "<p>Nuk ka koordinata per kete lokacion.</p>";
        }

        function inicializo() {
            lexoKoordinatat("<?php echo $rreshti["Vendi"] ?>", shfaqMap, gabim);
        }
    </script>
    <section id="harta-mbajtesi" class="padded">
    </section>

    <section class="padded">
        <h1 style="float: left; margin: 5px 15px 0 0; vertical-align: top">Komento: </h1>
        <form style="overflow: hidden;" name="KomentForma" method="post">
            <textarea name="komenti" cols="120" rows="5" maxlength="300"></textarea>
            <button style='float:right; margin-top:10px;' class='button' type="submit" name="<?php $_GET['id'] ?>">Dergo</button>
        </form>
    </section>
    <script src="<?php echo jquery; ?>"></script>
    <script>
        $(document).ready(function () {
            inicializo();
        });
    </script>
    <hr />
    <?php       
		$x = $rreshti;
		$rreshti_forum = $db->get_data("SELECT * FROM forumi WHERE ChatID=%d Order By Data desc", $_GET["id"]);
		foreach ($rreshti_forum as $rreshti) {
            echo "<div class='padded'>";
			echo "<h3>" . $rreshti['Komentuesi'] . " (". $rreshti['Data'] .")</h1>";
			echo "<p style='padding-top: 10px'>" . htmlentities($rreshti['Komenti']) . "</p>";
            echo "</div><hr />";
		}
	}
    ?>
</section>

<?php require(templates_footer); ?>