 <!-- Google Tag Manager-->
 <?php if (isset($data['config']->config_site_tm_code) && !empty($data['config']->config_site_tm_code)) : ?>
     <script>
         (function(w, d, s, l, i) {
             w[l] = w[l] || [];
             w[l].push({
                 'gtm.start': new Date().getTime(),
                 event: 'gtm.js'
             });
             var f = d.getElementsByTagName(s)[0],
                 j = d.createElement(s),
                 dl = l != 'dataLayer' ? '&l=' + l : '';
             j.async = true;
             j.src =
                 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
             f.parentNode.insertBefore(j, f);
         })(window, document, 'script', 'dataLayer', '${config_site_tm_code}');
     </script>
     <!-- Google Tag Manager (noscript)-->
     <noscript>
         <iframe src="https://www.googletagmanager.com/ns.html?id=${config_site_tm_code}" height="0" width="0" style="display: none; visibility: hidden;"></iframe>
     </noscript>
 <?php endif; ?>