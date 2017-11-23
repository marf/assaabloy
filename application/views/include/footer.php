
        
        <script src="js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="<?php echo base_url(); ?>admin_content/plugins/iCheck/icheck.min.js"></script>

        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="<?php echo base_url(); ?>js/datepicker-it.js"></script>

        <script src="js/app.js"></script>

        <!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
        <script>
            window.ga=function(){ga.q.push(arguments)};ga.q=[];ga.l=+new Date;
            ga('create','UA-XXXXX-Y','auto');ga('send','pageview')
        </script>

        <script>
            $(function () {
                $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
                });
            });

            $( function() {
                $( "#datepicker" ).datepicker($.datepicker.regional['it']);
              } );

        </script>

        <script src="https://www.google-analytics.com/analytics.js" async defer></script>
    </body>
</html>
