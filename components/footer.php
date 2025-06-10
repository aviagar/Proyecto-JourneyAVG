<footer>
    <?php
    if (!empty($GLOBALS['scripts_adicionales'])) {
        echo $GLOBALS['scripts_adicionales'];
    }
    ?>
    <div id="iconosFooter">
        <img alt="logo" src="img/Iconos/Logo.svg" id="logo2" class="logo">
        <img alt="facebook" src="img/Iconos/Facebook.svg" id="facebook" class="redes">
        <img alt="twitter" src="img/Iconos/Twitter.svg" id="twitter" class="redes">
        <img alt="instagram" src="img/Iconos/Instagram.svg" id="instagram" class="redes">
    </div>
    <div id="textoFooter">
        <a href="<?= PUBLIC_PATH ?>index.php?vista=accesibilidad" class="enlaces">Accesibilidad</a>
        <a href="<?= PUBLIC_PATH ?>index.php?vista=politicaPrivacidad" id="privacidad" class="enlaces">Política de privacidad</a>
        <a href="<?= PUBLIC_PATH ?>index.php?vista=condicionesGenerales" id="condiciones" class="enlaces">Condiciones generales</a>
        <a href="<?= PUBLIC_PATH ?>index.php?vista=ayuda" id="ayuda" class="enlaces">Ayuda</a>
        <span>© Journey 2025</span>
    </div>
</footer>