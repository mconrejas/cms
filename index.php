<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS Prototype</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
    <script type="text/javascript" src="./js/ddsort.min.js"></script>

    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <style>
        .cursor-pointer {
            cursor: pointer;
        }
        #drop-area {
            min-height: 500px;
            max-height: 800px;
            overflow-y: scroll;
        }
        #cms-blocks-list {
            list-style: none;
            padding: 2px;
            margin: 0;
        }
        #cms-blocks-list li {
            border: 1px solid gray;
            border-radius: 10px;
            display: inline-block;
            padding: 3px 5px;
            margin: 3px 2px
        }
        #preview-wrapper {
            max-height: 900px;
            padding: 0;
            overflow-y: scroll;
            overflow-x: hidden;
            border: 1px solid gray;
        }

        #preview {
            width: 1600px;
            height: 2000px;
            border: 0px;
        }

        #preview {
            zoom: 0.56;
            -moz-transform: scale(0.56);
            -moz-transform-origin: 0 0;
            -o-transform: scale(0.56);
            -o-transform-origin: 0 0;
            -webkit-transform: scale(0.56);
            -webkit-transform-origin: 0 0;
        }

        @media screen and (-webkit-min-device-pixel-ratio:0) {
            #preview {
                zoom: 1;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid bg-white rounded border p-3 my-5">
        <div id="alert" class='alert d-none' role='alert'></div>
        <?php

        $db = mysqli_connect( 'localhost', 'root', 'test', 'grapestest_db' ) or die( 'DB CONNECT ERROR: (' . mysqli_connect_errno() . ') ' . mysqli_connect_error() );

        $template = [];

        $query = $db->query("
            SELECT * 
            FROM template_parts tp
            LEFT JOIN template t ON t.id = tp.t_id 
            WHERE t.site = 1 AND t.active = 1
            ORDER BY tp.id ASC;
        ");

        if( $query->num_rows > 0 ) {
            while ( $row = $query->fetch_array() ) {
                array_push($template, [
                    'id' => $row['id'], 
                    'site' => $row['site'], 
                    'page' => $row['page'], 
                    'created_by' => $row['created_by'], 
                    'created_at' => $row['created_at'], 
                    'type' => $row['type'], 
                    'fields' => $row['fields']
                ]);
            }
        }

        ?>

        <div class="row">
            <div class="col-6">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="form-tab" data-toggle="tab" href="#form" role="tab" aria-controls="form" aria-selected="true">Form</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="history-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="false">History</a>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="form" role="tabpanel" aria-labelledby="form-tab">
                    <div class="row">
                        <div class="col-12 mb-2">
                            <div class="border rounded">
                                <ul id="cms-blocks-list">
                                </ul>
                            </div>
                        </div>

                        <div class="col-12">
                            <form id="template-form" action="./view.php" method="POST" target="preview_frame">
                                <input id="template" type="hidden" name="blocks" value="">
                                <input id="template-id" type="hidden" name="template_id" value="">

                                <div id="drop-area" class="border rounded p-2" ondrop="dragDrop(event)" ondragover="allowDrop(event)">
                                    <ul id="draggable-list" class="list-group">
                                    </ul>
                                </div>

                                <button type="button" id="btn-view" class="btn btn-warning btn-sm pull-right mt-3 ml-3 px-5">
                                    View
                                </button>

                                <button type="button" id="btn-save" class="btn btn-success btn-sm pull-right mt-3 px-5 disabled" disabled>
                                    Save
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                    <ul class="list-group">
                        <?php
                            $query = $db->query("
                                SELECT * 
                                FROM template 
                                WHERE site = 1 AND active = 0
                                ORDER BY id DESC;
                            ");
                    
                            if( $query->num_rows > 0 ) {
                                while ( $row = $query->fetch_array() ) {
                                    echo "<li id='btn-history' class='list-group-item' data-id='{$row['id']}' style='cursor:pointer;'>Updated by: McRupert Onrejas - {$row['created_at']}</li>";
                                }
                            }
                        ?>
                    </ul>
                </div>
            </div>


                <!-- <div class="row">
                    <div class="col-12 mb-2">
                        <div class="border rounded">
                            <ul id="cms-blocks-list">
                            </ul>
                        </div>
                    </div>

                    <div class="col-12">
                        <form id="template-form" action="./view.php" method="POST" target="preview_frame">
                            <input id="template" type="hidden" name="blocks" value="">

                            <div id="drop-area" class="border rounded p-2" ondrop="dragDrop(event)" ondragover="allowDrop(event)">
                                <ul id="draggable-list" class="list-group">
                                </ul>
                            </div>

                            <button type="button" id="btn-view" class="btn btn-success btn-sm pull-right mt-3 ml-3 px-5">
                                View
                            </button>

                            <button type="button" id="btn-save" class="btn btn-success btn-sm pull-right mt-3 px-5 disabled" disabled>
                                Save
                            </button>
                        </form>
                    </div>
                </div> -->
            </div>
            <div id="preview-wrapper" class="col-6">
                <iframe name="preview_frame" id="preview" src="./view.php" frameborder="0"></iframe>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="./js/block.js"></script>
    <script type="text/javascript" src="./js/drag-drop.js"></script>

    <script>
        $('.collapse').collapse()
        $(document).on('click', '.collapsable', function(){
            const icon = $(this).find('.fa');

            if( icon.hasClass('fa-caret-up') ) {
                icon.toggleClass('fa-caret-up');
                icon.toggleClass('fa-caret-down');
            }
            else
            {
                icon.toggleClass('fa-caret-down');
                icon.toggleClass('fa-caret-up');
            }
        })
        .on('click', '#btn-save', function( e ) {
            e.preventDefault();
            
            const block = new Block;

            block.saveBlocks();
        })
        .on('click', '#btn-view', function( e ) {
            e.preventDefault();

            const block = new Block;

            block.previewBlocks();

            // let windowObjectReference = window.localStorage.getItem('windowObjectReference');

            // if(windowObjectReference == null || windowObjectReference.closed) {
            //     windowObjectReference = window.open('/view.php', 'viewWindow');

            //     window.localStorage.setItem('windowObjectReference', JSON.stringify(windowObjectReference))
            // } else {
            //     windowObjectReference.focus();
            // };
        })
        .on('click', '#btn-history', function ( e ) {
            e.preventDefault();

            const template = document.getElementById( 'template' );
            template.value = '';

            const input = document.getElementById( 'template-id' );
            input.value = $(e.target).attr('data-id');

            const form = document.getElementById( 'template-form' );
            form.submit();
        })
        .on('click', '.remove', function( e ) {
            e.preventDefault();

            const block = new Block;

            block.removeBlock( e );
        });
        
        $(function () {
            const block = new Block()
            block.setCount( )
            block.init(<?php echo json_encode($template); ?>)

            $('#draggable-list').DDSort({
                target: 'li',
                delay: 100,
                floatStyle: {
                    'border': '1px solid #ccc',
                    'background-color': '#fff'
                }
            });
        });
    </script>
</body>
</html>