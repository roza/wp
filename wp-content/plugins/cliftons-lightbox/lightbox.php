<?php
$title = stripslashes($row['title']);
$list1 = stripslashes($row['list'][0]);
$list2 = stripslashes($row['list'][1]);
$list3 = stripslashes($row['list'][2]);
$list4 = stripslashes($row['list'][3]);
$list5 = stripslashes($row['list'][4]);
if(!empty($row['fields']))
{
	foreach($row['fields'] as $key => $value)
	{
		if(preg_match('/listname/i', $key)) //AWEBER HACK
		{
			$other_fields['listname'] = stripslashes($value);
		}
		elseif(preg_match('/email/i', $key))
		{
			$field['email'] = $key;
		}
		elseif(preg_match('/name/i', $key))
		{
			$field['name'] = $key;	
		}
		else
		{
			$other_fields[$key] = stripslashes($value);
		}
	}
}

$submit_text = $row['button']

?>

<div class="clp-wrapper" id="clp_wrapper">
	<div class="clp-close"></div>
	<div class="clp-title"><?php echo $title; ?></div>
	<div class="clp-left">
        <ul class="clp-list">
            <?php
                echo ($list1 != '') ? '<li>'.$list1.'</li>' : '';
                echo ($list2 != '') ? '<li>'.$list2.'</li>' : '';
                echo ($list3 != '') ? '<li>'.$list3.'</li>' : '';
                echo ($list4 != '') ? '<li>'.$list4.'</li>' : '';
                echo ($list5 != '') ? '<li>'.$list5.'</li>' : '';
            ?>
        </ul>
    </div>
    <div class="clp-right">
		<?php
        if($row['video'] != '')
        {
            echo $row['video_player'];	
        }
        elseif($row['image'] != '')
        {
            echo '<img src="'.strip_tags($row['image']).'" />';
        }
        else
        {
            echo '<img src="'.plugins_url('images/sample.png', __FILE__).'" />';	
        }
        ?>
    </div>
    <div class="clp-description">
        <?php echo nl2br($row['description']); ?>
    </div>
    <div class="clp-form-wrapper">
        <form action="<?php echo $row['form_url']; ?>" method="POST" class="clp-form">
            <input type="text" name="<?php echo $row['selected_name']; ?>" value="Your First Name..." class="clp-name" onFocus="this.value=''" />
            <input type="text" name="<?php echo $row['selected_email']; ?>" value="Your Email Address..." class="clp-email" onFocus="this.value=''" />
            <input type="submit" src="<?php echo plugins_url('images/transparent.png', __FILE__); ?>" value="<?php echo $submit_text; ?>" class="clp-form-submit" />
            <?php
            if(!empty($other_fields))
            {
                foreach($other_fields as $key => $value)
                {
					if($key == 'redirect')
					{
						$value = get_bloginfo('url').$_SERVER['REQUEST_URI'];	
					}
                    echo '<input type="hidden" name="'.$key.'" value="'.$value.'" />';	
                }
            }
            ?>
        </form>
    </div>
    <?php echo ($row['privacy'] != '') ? '<div class="clp-privacy">'.stripslashes($row['privacy']).'</div>' : ''; ?>
    <?php if($row['poweredby'] == '1' || $row['poweredby'] == '') : ?>
    <div class="clp-credits"><a href="http://lightbox.cliftonhatfield.com" title="Download Clifton&apos;s Lightbox" target="_blank">Clifton&apos;s Lightbox</a></div>
    <?php endif; ?>
</div>