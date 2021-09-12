<?php
    $db = mysqli_connect( 'localhost', 'root', 'test', 'grapestest_db' ) or die( 'DB CONNECT ERROR: (' . mysqli_connect_errno() . ') ' . mysqli_connect_error() );

    if( isset($_REQUEST['blocks']) ) {
        // set template active to 0
        $db->query( "
            UPDATE template SET active = 0 
            WHERE site = '" . $_REQUEST['site'] . "'
        " );
        
        // save new template entry for history
        $db->query( "
        INSERT INTO template
        (
            site, active, created_by, created_at
        )
        VALUES
        (
            '" . $_REQUEST['site'] . "',
            '1',
            '1',
            '" . date('Y-m-d H:i:s') . "'
        )
        " );

        $id = $db->insert_id;

        $blocks = json_decode( $_REQUEST['blocks'] );

        foreach ( $blocks as $block ) {
            $db->query( "
            INSERT INTO template_parts
            (
                t_id, type, fields
            )
            VALUES
            (
                $id,
                '" . addslashes( trim( $block->type ) ) . "',
                '" . addslashes( trim( json_encode($block->fields) ) ) . "'
            )
            " );
        }

        echo json_encode([
            'success' => true,
            'message' => 'Template successfuly saved.'
        ]);

        return true;
    }

    $db->close();

    echo json_encode([
        'success' => false,
        'message' => 'Unable to save the template.'
    ]);

    return true;
    // header('Location: ./view.php');