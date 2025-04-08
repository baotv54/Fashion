<script>
    $("body").removeClass("preload");

    document.addEventListener('lazybeforeunveil', function(e) {
        var bg = e.target.getAttribute('data-bg');
        if (bg) e.target.style.backgroundImage = 'url(' + bg + ')';
    });

    if (window.noPS) {
        window.addEventListener("load", (event) => {
            if ($('input[name="Token"]').length > 0) {
                $.getScript('https://www.google.com/recaptcha/apif78f.js?render=6Ldtu4IUAAAAAMQzG1gCw3wFlx_GytlZyLrXcsuK').done(function(s, r) {
                    $('head').append(s);
                    $('input[name="Token"]').each(function() {
                        var flagId = $(this).attr('id');
                        grecaptcha.ready(function() {
                            grecaptcha.execute('6Ldtu4IUAAAAAMQzG1gCw3wFlx_GytlZyLrXcsuK', {
                                action: 'submit'
                            })
                            .then(function(token) {
                                document.getElementById(flagId).value = token;
                            });
                        });
                    });
                });
            }

            $('img[loading="lazy"]').each(function() {
                $(this).removeAttr('loading');
            });
        });
    } else {
        // Jquery touch
        jQuery.event.special.touchstart = {
            setup: function(e, t, n) {
                this.addEventListener("touchstart", n, {
                    passive: !t.includes("noPreventDefault")
                });
            }
        };
        jQuery.event.special.touchmove = {
            setup: function(e, t, n) {
                this.addEventListener("touchmove", n, {
                    passive: !t.includes("noPreventDefault")
                });
            }
        };
    }
</script>
<button class="overplay-all" title="Đóng"></button>
