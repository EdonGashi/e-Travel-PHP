<?php
require_once("../resources/config.php");
$header_titulli = "Kontakti";
$css_includes = Array("css/form.css", "css/site.css");
require(templates_header);
?>

<section class="permbajtje">
    <h1 class="center">Na kontaktoni</h1>
    <form class="form" name="kontaktforma" method="post" action="dergo_mail.php">
        <table>
            <tr>
                <td>
                    <label for="emri">Emri</label>
                </td>
                <td>
                    <input type="text" name="emri" maxlength="50" size="30">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="mbiemri">Mbiemri</label>
                </td>
                <td>
                    <input type="text" name="mbiemri" maxlength="50" size="30">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="email">Email Address</label>
                </td>
                <td>
                    <input type="text" name="email" maxlength="80" size="30">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="komenti">Permbajtja</label>
                </td>
                <td>
                    <textarea name="komenti" maxlength="1000" cols="32" rows="5"></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: right; height: 60px;">
                    <input class="button" type="submit" value="Dergo">
                </td>
            </tr>
        </table>
    </form>
</section>
<?php require(templates_footer); ?>