<?php

use _MODULE\FilesManagement;

?>
<? jsResourcesAdmin(); ?>
<?= FilesManagement::galleryModal() ?><? if ($_APP_CONFIG['development']): ?>
    <script id="__bs_script__">//<![CDATA[
        document.write("<script async src='http://HOST:3333/browser-sync/browser-sync-client.js?v=2.26.3'><\/script>".replace("HOST", location.hostname));
        //]]></script><? endif ?>
</body>
</html>