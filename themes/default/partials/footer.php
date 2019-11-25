<footer>
    <div class="container">
        <div class="row">

            <div class="col-12 col-sm-6 col-xs-6 col-md-6 col-lg-4">
                <div class="footer-details">
                    <div class="footer-details__headline">
                        About us
                    </div>
                    <div class="footer-details__text">
                        Ut ac turpis enim. Sed placerat imperdiet metus nec placerat. Fusce a nibh ut purus scelerisque
                        convallis. Aenean scelerisque porttitor facilisis. Sed dictum, felis eget molestie interdum,
                        enim dolor posuere velit, in tempor dolor arcu in nisi. Quisque elementum eu metus vitae
                        bibendum.
                    </div>
                </div>
            </div>


            <div class="col-12 col-sm-6 col-xs-6 col-md-6 offset-lg-1 col-lg-3">
                <div class="footer-details">
                    <div class="footer-details__headline">
                        Sitemap
                    </div>
                    <div class="footer-details__links">
                        <ul>
                            <li><a href="#">Lorem ipsum dolor sit amet</a></li>
                            <li><a href="#">Curabitur elementum libero</a></li>
                            <li><a href="#">Vestibulum id tellus viverra</a></li>
                            <li><a href="#">Nullam posuere velit</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xs-6 col-md-6 offset-lg-1 col-lg-3">
                <div class="footer-details">
                    <div class="footer-details__headline">
                        Follow Us
                    </div>
                    <div class="footer-details__icons">
                        <a href="https://www.facebook.com/" target="_blank">
                            <img src="<?=distSrc('images/social/facebook.svg')?>"/>
                        </a>
                        <a href="https://www.instagram.com/" target="_blank">
                            <img src="<?=distSrc('images/social/instagram.svg')?>"/>
                        </a>
                        <a href="https://www.pinterest.com/" target="_blank">
                            <img src="<?=distSrc('images/social/pinterest.svg')?>"/>
                        </a>
                        <a href="https://twitter.com/" target="_blank">
                            <img src="<?=distSrc('images/social/twitter.svg')?>"/>
                        </a>
                    </div>
                    <div class="mt-4">
                        <a href="<?= webLink('blog') ?>" target="_self" class="btn btn-success transparent reverse">
                            Blog
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</footer>

<?= jsResources();
if ($_APP_CONFIG['development']): ?>
    <script id="__bs_script__">//<![CDATA[
        document.write("<script async src='http://HOST:3333/browser-sync/browser-sync-client.js?v=2.26.3'><\/script>".replace("HOST", location.hostname));
        //]]></script><? endif ?>

</body>
</html>