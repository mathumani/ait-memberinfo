<?php
$info = array();
$info['membership_no'] = null;
$info['fullname'] = null;
$info['dob'] = null;
$info['gender'] = null;
$info['email'] = null;
$info['phone'] = null;
$info['company'] = null;
$info['photo'] =null;

if(is_array($_GET) > 0)
{
    if(array_key_exists('membership_no', $_GET))
        $info['membership_no'] = $_GET['membership_no'];

    if(array_key_exists('fullname', $_GET))
        $info['fullname'] = $_GET['fullname'];

    if(array_key_exists('dob', $_GET))
    {
        list($year, $month, $day) = explode("-", $_GET['dob']);
        $info['dob'] = "$day/$month/$year";
    }

    if(array_key_exists('gender', $_GET))
        $info['gender'] = $_GET['gender'];

    if(array_key_exists('email', $_GET))
        $info['email'] = $_GET['email'];

    if(array_key_exists('phone', $_GET))
        $info['phone'] = $_GET['phone'];

    if(array_key_exists('company', $_GET))
        $info['company'] = $_GET['company'];

    if(array_key_exists('photo', $_GET))
    {
        $confirm = null;
        if(array_key_exists('confirm', $_GET))
            $confirm = $_GET['confirm'];
        else
            $confirm = "no";
        if(file_exists("photo/".$_GET['photo']))
            unlink("photo/".$_GET['photo']);

        if(file_exists("../photo/".$_GET['photo']) && $confirm == "no")
            unlink("../photo/".$_GET['photo']);

        $info['photo'] = $_GET['photo'];
    }
}
?>

<form method="post" autocomplete="off"  action="action/member_info_update.php"
 enctype="multipart/form-data"
>
<div class="input-group">
    <input type="hidden" name="sparmcheck", value="rnQ=?mREu89aRA?#sy+43zfv" />
    <input class="input--style-3" type="text" placeholder="Membership No" 
        name="membership_no" required=required 
        <?php
            if(isset($info['membership_no']))
            {
                echo 'value="'.$info['membership_no'].'"';
            }

        ?>
    >
</div>
<div class="input-group">
    <input class="input--style-3" type="text" placeholder="Full Name" 
        name="fullname" required=required

        <?php
            if(isset($info['fullname']))
            {
                echo 'value="'.$info['fullname'].'"';
            }

        ?>
    >
</div>
<div class="input-group">
    <input class="input--style-3 js-datepicker" type="text" 
        placeholder="Birthdate" name="dob"

        <?php
            if(isset($info['dob']))
            {
                echo 'value="'.$info['dob'].'"';
            }

        ?>
    >
    <i class="zmdi zmdi-calendar-note input-icon js-btn-calendar"></i>
</div>
<div class="input-group">
    <div class="rs-select2 js-select-simple select--no-search">
        <select name="gender">
            <option disabled="disabled" selected="selected">Gender</option>
            <option value='M'>Male</option>
            <option value='F'>Female</option>

        <?php
            if(isset($info['gender']))
            {
                if($info['gender'] == 'M')
                {
                    echo '<option value="'.$info['gender'].'" 
                        selected>Male</option>';
                    echo '<option value="F">Female</option>';
                }
                else
                {
                    echo '<option value="M">Male</option>';
                    echo '<option value="'.$info['gender'].'" 
                        selected>Female</option>';
                }
            }

        ?>
        </select>
        <div class="select-dropdown"></div>
    </div>
</div>
<div class="input-group">
    <input class="input--style-3" type="email" placeholder="Email" name="email" 
        required=required

        <?php
            if(isset($info['email']))
            {
                echo 'value="'.$info['email'].'"';
            }

        ?>
    >
</div>
<div class="input-group">
    <input class="input--style-3" type="text" placeholder="Phone" name="phone" 
        required=required

        <?php
            if(isset($info['phone']))
            {
                echo 'value="'.$info['phone'].'"';
            }

        ?>
    >
</div>
<div class="input-group">
    <input class="input--style-3" type="text" placeholder="Company" 
        name="company" required=required

        <?php
            if(isset($info['company']))
            {
                echo 'value="'.$info['company'].'"';
            }

        ?>
    >
</div>
<div class="input-group">
    <label>Photo</label>
    <input class="input--style-3" type="file" placeholder="Photo" name="photo" 
        data-buttonText="Photo"

        <?php
            if(isset($info['photo']))
            {
                echo 'value="'.$info['photo'].'"';
            }

        ?>
    >
</div>
<?php
    $error = null;
    if(array_key_exists('error', $_GET))
        $error = $_GET['error'];
?>
<div style="color: red; padding: 10px; style: italic"><p><?php echo $error; ?></p></div>

<div class="p-t-10">
    <button class="btn btn--pill btn--green" type="submit">Submit</button>
</div>
</form>
