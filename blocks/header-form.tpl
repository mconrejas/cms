<div class="st7-banner">
    <div class="row">
        <div class="col-lg-5 d-none d-lg-block">
            <div class="st7-banner-img">
                <!-- <img src="./images/st6-img1.jpeg" alt=""> -->
            </div>
        </div>
        <div class="col-lg-7">
            <div class="st7-headline pt-5">
            {header-text}
            
            <form action="" method="post" id="reg-now" class="common-form"<?php if( isset($_REQUEST['string']) ) echo $popup_code; ?>>
                {form-text}
                
                <input type="hidden" name="stage" value="1">
                <input type="hidden" name="string" value="<?php if( isset($_REQUEST['string']) ) echo $_REQUEST['string']; ?>">
                <input type="hidden" name="redirect" value="<?php if( isset($lander_data['redirect_url']) ) echo $lander_data['redirect_url']; ?>">
                <input type="hidden" name="email" value="" autocomplete="off">
                <input type="hidden" name="source_id" value="<?php if( isset($_REQUEST['source_id']) ) echo $_REQUEST['source_id']; ?>">
                <input type="hidden" name="sub1" value="<?php if( isset($_REQUEST['sub1']) ) echo $_REQUEST['sub1']; ?>">
                <input type="hidden" name="sub2" value="<?php if( isset($_REQUEST['sub2']) ) echo $_REQUEST['sub2']; ?>">
                <input type="hidden" name="sub3" value="<?php if( isset($_REQUEST['sub3']) ) echo $_REQUEST['sub3']; ?>">
                <input type="hidden" name="sub4" value="<?php if( isset($_REQUEST['sub4']) ) echo $_REQUEST['sub4']; ?>">
                <input type="hidden" name="sub5" value="<?php if( isset($_REQUEST['sub5']) ) echo $_REQUEST['sub5']; ?>">
                <input type="hidden" name="affiliate_id" value="<?php if( isset($_REQUEST['affiliate_id']) ) echo $_REQUEST['affiliate_id']; ?>">
                <input type="hidden" name="transaction_id" value="<?php if( isset($_REQUEST['transaction_id']) ) echo $_REQUEST['transaction_id']; ?>">
                <input type="hidden" name="funnel_id" value="<?php if( isset($lander_data['funnel_id']) ) echo $lander_data['funnel_id']; ?>">
                <input type="hidden" name="element_id" value="<?php if( isset($lander_data['element_id']) ) echo $split_test['element_id']; ?>">
                <input type="hidden" name="split_test_id" value="<?php if( isset($lander_data['split_test_id']) ) echo $split_test['split_test_id']; ?>">
                <input type="hidden" name="channel" value="<?php if( isset($_REQUEST['channel']) ) echo $_REQUEST['channel']; ?>">

                <input type="text" placeholder="First Name" name="firstname" id="firstname" value="<?php if( isset($_REQUEST['firstname']) ) echo $_REQUEST['firstname']; ?>" required>
                <input type="text" placeholder="Last Name" name="lastname" id="lastname" value="<?php if( isset($_REQUEST['lastname']) ) echo $_REQUEST['lastname']; ?>" required>
                <input type="email" placeholder="Email Address" name="e14" id="e14" value="<?php if( isset($_REQUEST['email']) ) echo $_REQUEST['email']; ?>" required>
                <input type="text" placeholder="Phone Number (Optional)" name="phone1" id="phone1" value="<?php if( isset($_REQUEST['phone1']) ) echo $_REQUEST['phone1']; ?>"<?php if( isset($phone_display) ) echo $phone_display; ?>>
                <p class="post-form">{terms}</p>
                <input type="submit" id="submit" value="VIEW AVAILABLE FUNDS" class="cta-btn"  >
            </form>
            </div>
        </div>
    </div>
</div>