
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->                      
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <!-- Trigger the modal with a button -->
            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#modalEvent">Dodaj nowe wydarzenie</button>

            <!-- List of events -->


            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Wydarzenia</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <table id="datatable" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Data</th>
                                                <th>Tytuł</th>
                                                <th>Opis</th>
                                                <th>Zdjęcie</th>
                                                <th>Edycja</th>
                                                <th>Usuń</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            global $wm_cms;
                                            $events = $wm_cms->event->getEvents();
                                            foreach ($events as $event) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $event['event_date']; ?>   </td>
                                                    <td><?php echo $event['event_title']; ?> </td>
                                                    <td><?php echo $event['event_content']; ?> </td>
                                                    <td><img class="img-thumbnail" src="<?php
                                                        if (empty($event['event_link'])) {
                                                            echo APP_ASSETS . '/img/desktop.jpg';
                                                        } else {
                                                            echo $event['event_link'];
                                                        }
                                                        ?> "</td>

                                                    <td><a class="btn bg-info" href="?event_id=<?php echo $event['event_id']; ?>">Edycja</a> </td>
                                                    <td><a class="btn bg-danger" href="<?php echo $event['event_id']; ?>">Usuń</a> </td>
                                                </tr>
                                            <?php } ?>    
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- End list of events -->

            
         
        </div> 
		<!-- Form for event events -->
        <div class="container">


            <!-- Modal -->
            <div class="modal fade" id="modalEvent" role="dialog">


                <!-- Modal content-->
                <div class="modal-dialog">  

                    <form id="formEvent" action="<?php echo SITE_PATH; ?>app/c_users.php" method="post" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">


                        <div class="form-group">
                            <label for="event_title">Tytuł</label>
                            <input required="true" type="text" name="event_title" value="<?php echo $this->getData('event_title') ?>" class="form-control" id="title" placeholder="Tytuł">
                        </div>
                        <div class="form-group">
                            <label for="event_content">Podaj treść wpisu</label>
                            <textarea required="true" rows="8" name="event_content" type="textarea"  class="form-control" id="content" placeholder="podaj treść wpisu"><?php echo $this->getData('event_content') ?></textarea>
                        </div>
                        <div class="form-group">
                            <label title="Podaj link jaki checsz dodać" for="event_link">Dodaj link do mediów</label>
                            <input required="true" type="url" id="link" name="event_link" value="<?php echo $this->getData('event_link') ?>" class="form-control" placeholder="link">
                        </div>
                        <button id="addEvent" type="submit" name="addEvent" class="btn btn-primary">Dodaj</button>

                    </form>
                </div> 

            </div>

        </div>
		  <!-- end form event-->
    </div> 
    <script src="<?php echo APP_ASSETS; ?>/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo APP_ASSETS; ?>/js/dataTables.bootstrap.js"></script>


    <!-- Bootstrap Core JavaScript -->


    <script type="text/javascript">
        var $t = jQuery.noConflict();
        $t(document).ready(function () {
            $t('#datatable').dataTable();

            $t('#formEvent').submit(function (e) {
                var title = $t('#title').val();
                var content = $t('#content').val();
                var link = $t('#link').val();
                console.log('formEvent');
                e.preventDefault();
                var dataString = 'event_title=' + title + '&event_content=' + content + '&event_link=' + link;

                $t.ajax({
                    type: "POST",
                    url: "<?php echo SITE_PATH; ?>app/c_users.php",
                    data: dataString,
                    cache: false,
                    success: function (html) {
                        $s('#wmcms-panel-right').html(html);
                        location.reload();
                    }
                });

            });

            $t('#datatable a.bg-danger').click(function (e) {
                e.preventDefault();
                console.log('submin');
                var event_id = $t(this).attr('href');

                var action = 'del';
                console.log(event_id + ' ' + action);


                var dataString = 'event_id=' + event_id + '&action=' + action;
                if (confirm('Czy napewno usunąć wydarzenie ' + event_id)) {
                    $t.ajax({
                        type: "GET",
                        url: "<?php echo SITE_PATH; ?>app/c_event.php",
                        data: dataString,
                        cache: false,
                        success: function () {
                           
                            var events = 'events=events';
                            $t.ajax({
                                type: "POST",
                                url: "<?php echo SITE_PATH; ?>app/c_users.php",
                                data: events,
                                cache: false,
                                success: function (html) {
                                    console.log(html);
                                    $t('.wmcms-panel-right').html(html);

                                }
                            });
                            
                        }
                    });
                }
            });


            $t('#datatable a.bg-info').click(function (e) {
                e.preventDefault();
                console.log('submin');
                var event_id = $t(this).attr('href');

                var action = 'edit';
                console.log(event_id + ' ' + action);


                var dataString = 'event_id=' + event_id + '&action=' + action;

                $t.ajax({
                    type: "GET",
                    url: "<?php echo SITE_PATH; ?>app/c_event.php",
                    data: dataString,
                    cache: false,
                    success: function (html) {
                        //console.log(html);
                        location.reload();
                        $.post("<?php echo SITE_PATH; ?>app/c_event.php", {});
                        $s('#wmcms-panel-right').html(html);
                    }
                });
            });
        });

    </script>
    <script src="<?php echo APP_ASSETS; ?>/js/modal/jquery.js"></script>
    <script src="<?php echo APP_ASSETS; ?>/js/modal/bootstrap.min.js"></script>

</div>
<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->
