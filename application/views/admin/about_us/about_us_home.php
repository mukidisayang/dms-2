<?php
/*
#Author: Cengkuru Micheal
9/2/14
10:49 AM
*/
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="card">

    <div class="card-body text-default-light">
        <p>
            <?php
            //if user has permission
            if (check_my_access('add_about_us_articles')) {
                ?>
                <a class="btn ink-reaction btn-floating-action btn-primary"
                                           href="<?= base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) ?>/add_article"><i class="fa fa-plus"></i></a>

            <?php
            }

            ?>




        </p>
        <div class="table-responsive">
        											<table class="table datatable no-margin">
                                                        <thead>
                                                        <tr>
                                                            <th>title</th>
                                                            <th>cover</th>


                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php

                                                        foreach ($all_about_us_paginated as $row) {

                                                            ?>
                                                            <tr>

                                                                <td class="hidden-xs">


                                                                    <?= ucwords($row['title']) ?><br>
                                                                    <small>
                                                                        <?php
                                                                        //if user has permission
                                                                        if (check_my_access('edit_about_us_article')) {
                                                                            ?>
                                                                            <a href="<?= base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/edit_about_us/' . encryptValue($row['id']) ?>"><i class="md md-edit"></i> </a>
                                                                        <?php
                                                                        }

                                                                        ?>
                                                                        <?php
                                                                        //if user has permission
                                                                        if (check_my_access('delete_about_us_article')) {
                                                                            ?>
                                                                            <a class="action_btn" href="" data-id="<?= $row['id'] ?>"
                                                                               data-action="delete_article"
                                                                               data-title="Delete  <?= ucwords($row['title']) ?>" data-toggle="modal"
                                                                               data-target="#myModal"><i class="md md-delete"></i></a>
                                                                        <?php
                                                                        }

                                                                        ?>
                                                                        <?= ucwords(time_ago($row['dateadded'])) ?>
                                                                        | <?= ucwords(get_user_info_by_id($row['author'], 'fullname')) ?>
                                                                    </small>
                                                                </td>


                                                                <td>
                                                                    <?php
                                                                    if ($row['cover_image']) {
                                                                        //if there is a cover image
                                                                        ?>
                                                                        <a href="<?= base_url() . 'uploads/about_us/' . $row['cover_image'] ?>"
                                                                           class="fancybox" title="<?= $row['title'] ?>">
                                                                            <img class="img-rounded" width="32px" height="32px"
                                                                                 src="<?= base_url() ?>uploads/about_us/<?= get_thumbnail($row['cover_image']) ?>">
                                                                        </a>


                                                                    <?php

                                                                    } else {
                                                                        ?>
                                                                        <img class="img-rounded" width="32px" height="32px"
                                                                             src="<?= base_url() ?>uploads/noimage.png">
                                                                    <?php

                                                                    }
                                                                    ?>
                                                                    <a style="padding-left: 10px;" class=""
                                                                       href="<?= base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/change_cover/' . encryptValue($row['id']) ?>"><i class="md md-file-upload"></i></a>
                                                                </td>


                                                            </tr>
                                                        <?php

                                                        }
                                                        ?>

                                                        </tbody>
        											</table>
        										</div>


    </div><!--end .card-body -->
</div>


<!-- Modal -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Logo</h4>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!--jquery here-->


<script>
    $(document).ready(function () {
        $('.fancybox').fancybox();

        //when ann action butoon is clicked
        $('.action_btn').click(function () {
            //get model content
            var modal_title = $(this).data('title');
            var action = $(this).data('action');
            //alert($(this).data('id'));


            //replace the model title
            $("#myModalLabel").html(modal_title);

            //replace modal content
            $(".modal-body").html('<img src="<?=base_url()?>images/loading.gif" />');

            //switch depending on action
            switch (action) {

                case 'delete_article':
                    var _data =
                    {
                        ajax: action,
                        id: $(this).data('id')
                    };
                    $.ajax({
                        url: "<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/ajax_calls') ?>",
                        type: 'POST',
                        data: _data,
                        success: function (msg) {

                            $('.modal-body').html(msg);

                        }
                    });
                    break;

            }
        });


    });


</script>


<!--end jquery-->



