<!-- Global site tag (gtag.js) - Google Analytics -->
<?php if (isset($data['config']->config_site_ga_code) && !empty($data['config']->config_site_ga_code)) : ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=${config_site_ga_code}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', '${config_site_ga_code}');
    </script>
<?php endif; ?>