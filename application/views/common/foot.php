
<!-- Bootstrap core JavaScript
================================================== -->

<?php if(isset($site_message)): ?>
<div id="site_message" data-msg-type="<?php echo $site_message['type']?>">
    <div class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?php if($site_message['type'] == 'W') echo lang('warning');elseif('E' == $site_message['type']) echo lang('error');elseif('I' == $site_message['type']) echo lang('info'); ?></h4>
                </div>
                <div class="modal-body">
                    <p><?php echo $site_message['msg']; ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close');?></button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<?php endif; ?>
</div>

<div id="footer">
    <div class="container">
        <p class="text-muted credit">
            <a href="<?php site_url('users/dash');?>"><?php echo lang('fym');?></a> Copyright &copy; <?php echo lang('fy'); ?>
        </p>
    </div>
</div>

<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo site_url(); ?>assets/js/jquery-1.10.2.min.js"></script>
<script src="<?php echo site_url(); ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo site_url(); ?>assets/js/lang/jquery.lang.min.js"></script>
<?php if(isset($load_extra) && is_array($load_extra)){
    foreach($load_extra as $le){
        switch($le){
            case 'dataTables': ?>
                <script src="<?php echo site_url(); ?>assets/js/datatables/jquery.dataTables.min.js"></script>
                <script src="<?php echo site_url(); ?>assets/js/datatables/bootstrap-dataTables.min.js"></script>
                <script src="<?php echo site_url(); ?>assets/js/datatables/ColumnFilterWidgets.min.js"></script>
            <?php break;
            case 'datatimepicker': ?>
                <script src="<?php echo site_url(); ?>assets/js/moment.min.js"></script>
                <script src="<?php echo site_url(); ?>assets/js/bootstrap-datetimepicker.min.js"></script>
                <script src="<?php echo site_url(); ?>assets/js/bootstrap-datetimepicker.zh-CN.min.js"></script>
            <?php break;
            case 'client_upload': ?>
                <script src="<?php echo site_url(); ?>assets/js/client_upload.js"></script>
            <?php break;
            case 'clients_filter': ?>
                <script src="<?php echo site_url(); ?>assets/js/jquery.ui.widget.min.js"></script>
                <script src="<?php echo site_url(); ?>assets/js/jquery.iframe-transport.min.js"></script>
                <script src="<?php echo site_url(); ?>assets/js/jquery.fileupload.min.js"></script>
                <script src="<?php echo site_url(); ?>assets/js/jquery.fileupload-process.min.js"></script>
                <script src="<?php echo site_url(); ?>assets/js/jquery.fileupload-validate.min.js"></script>
                <script src="<?php echo site_url(); ?>assets/js/handlebars.runtime-v1.1.2.js"></script>
                <script src="<?php echo site_url(); ?>assets/js/templates/row.js"></script>
                <script src="<?php echo site_url(); ?>assets/js/clients_filter.js"></script>
                <?php break;
            case 'dash':?>
                <script src="<?php echo site_url(); ?>assets/js/handlebars.runtime-v1.1.2.js"></script>
                <script src="<?php echo site_url(); ?>assets/js/templates/clients.js"></script>
                <script src="<?php echo site_url(); ?>assets/js/templates/histories.js"></script>
                <script src="<?php echo site_url(); ?>assets/js/dash.js"></script>
                <?php break;
        }
    }
}?>
<script src="<?php echo site_url(); ?>assets/js/site.js"></script>
<?php if('production' == ENVIRONMENT):?>
    <!-- Piwik -->
    <script type="text/javascript">
        var _paq = _paq || [];
        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        (function() {
            var u=(("https:" == document.location.protocol) ? "https" : "http") + "://piwik.keji52.com//";
            _paq.push(['setTrackerUrl', u+'piwik.php']);
            _paq.push(['setSiteId', 1]);
            var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0]; g.type='text/javascript';
            g.defer=true; g.async=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
        })();

    </script>
    <noscript><p><img src="http://piwik.keji52.com/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>
    <!-- End Piwik Code -->
<?php endif; ?>
</body>
</html>