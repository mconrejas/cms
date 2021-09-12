<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.7.0/css/all.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/splittest.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(e) {
            // Show phone field after email
            $('#e14').focusin(function()
            {
                $('#phone1').show();
            });
        });
    </script>

    <style>
        .preview-container {
            min-height: 250px;
        }
    </style>
</head>
<body id="explore">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="/images/site-logo.svg" alt="Logo" class="site-logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="preview-container">
        <?php
            $db = mysqli_connect( 'localhost', 'root', 'test', 'grapestest_db' ) or die( 'DB CONNECT ERROR: (' . mysqli_connect_errno() . ') ' . mysqli_connect_error() );

            include __DIR__ . '/template.php';
            $template = new Template();

            if( isset($_REQUEST['blocks']) && $_REQUEST['blocks'] != '' ) {
                $blocks = json_decode($_REQUEST['blocks']);

                foreach ($blocks as $b => $block) {
                    $template->load( __DIR__ . "/blocks/$block->type.tpl" );

                    foreach ($block->fields as $f => $field) {
                        $template->set( $field->field, $field->value );
                    }

                    echo $template->publish();
                }
            } else if ( isset($_REQUEST['template_id']) && $_REQUEST['template_id'] != '' ) {
                $query = $db->query("
                    SELECT * 
                    FROM template_parts 
                    WHERE t_id = '" . $_REQUEST['template_id'] . "';
                ");

                if( $query->num_rows > 0 ) {
                    while ( $row = $query->fetch_array() ) {
                        $template->load( __DIR__ . "/blocks/{$row['type']}.tpl" );
        
                        $fields = json_decode($row['fields']);

                        foreach ($fields as $f => $field) {
                            $template->set( $field->field, $field->value );
                        }
    
                        echo $template->publish();
                    }
                }
            }
        ?>
    </div>

    <div class="post-footer">
        <div class="post-footer-links">
            <ul>
                <li><a href="#">Unsubscribe</a></li>
                <li><a href="#">Privacy</a></li>
                <li><a href="#">Terms</a></li>
            </ul>
            <ul>
                <li>CA Residents: <a href="#">Do Not Sell My Info</a></li>
                <li><a href="#">Notice of Collection</a></li>
            </ul>
        </div>
        <div>
            &copy; <?php echo date( 'Y' ); ?> FindUnclaimedAssets 
        </div>
    </div>
</body>
</html>