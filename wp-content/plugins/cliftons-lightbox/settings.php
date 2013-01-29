<div class="wrap">
	<div id="icon-themes" class="icon32"></div>
	<h2>Clifton's Lightbox</h2>
    <?php clp_display_msg(); ?>
    <form action="#" method="post">
    <table class="form-table">
    	<tbody>
        	<tr>
                <th>Enabled/Disabled</th>
                <td>
                    <select name="enabled">
                        <option value="0" <?php if($row['enabled'] == '0') echo 'selected="selected"'; ?>>Disabled</option>
                        <option value="1"<?php if($row['enabled'] == '1') echo 'selected="selected"'; ?>>Enabled</option>
                    </select>
                </td>
            </tr>
            <tr>
            	<th>YouTube Video URL</th>
                <td>
                	<input type="radio" name="media" class="clp-media" value="video" <?php echo ($row['video'] != '') ? 'checked="checked"' : ''; ?> />
                    <input type="text" name="video" id="lightbox_video" value="<?php echo ($row['video'] != '') ? 'http://www.youtube.com/watch?v='.stripslashes(htmlentities($row['video'])) : ''; ?>" style="width:300px"  <?php echo ($row['video'] == '') ? 'disabled="disabled"' : ''; ?> />
                    <div style="font-size:11px;color:#666;">e.g. http://www.youtube.com/watch?v=GJK9RmNmpdE</div>
                </td>
	        </tr>
        	<tr>
            	<th>Image URL</th>
                <td>
	                <input type="radio" name="media" class="clp-media" value="image" <?php echo ($row['image'] != '') ? 'checked="checked"' : ''; ?> />
                    <input type="text" name="image" id="lightbox_image" value="<?php echo (empty($row['image']) && empty($row['video'])) ? plugins_url('images/sample.png', __FILE__) : $row['image']; ?>" style="width:300px" <?php echo ($row['image'] == '') ? 'disabled="disabled"' : ''; ?> />
			        <div style="font-size:11px;color:#666;">e.g. <?php echo content_url('uploads/image.jpg'); ?> (no img tag or html) Recommended max size 320x270</div>
        		</td>
            </tr>
            <tr>
            	<th>Title</th>
                <td>
                	<input type="text" name="title" id="title" value="<?php echo $title; ?>" style="width:300px" maxlength="65" />
			        <div style="font-size:11px;color:#666;">Max length 65 characters</div>
                </td>
            </tr>
            <tr>
            	<th>Bullet Point List</th>
                <td>
                    <img src="<?php echo plugins_url('images/checkmark.png', __FILE__); ?>" height="20px" align="absmiddle" /> <input type="text" name="list[]" id="list" value="<?php echo stripslashes(htmlentities($row['list'][0])); ?>" style="width:300px" maxlength="100" />
                    <br />
                    <img src="<?php echo plugins_url('images/checkmark.png', __FILE__); ?>" height="20px" align="absmiddle" /> <input type="text" name="list[]" id="list" value="<?php echo stripslashes(htmlentities($row['list'][1])); ?>" style="width:300px" maxlength="100" />
                    <br />
                    <img src="<?php echo plugins_url('images/checkmark.png', __FILE__); ?>" height="20px" align="absmiddle" /> <input type="text" name="list[]" id="list" value="<?php echo stripslashes(htmlentities($row['list'][2])); ?>" style="width:300px" maxlength="100" />
                    <br />
                    <img src="<?php echo plugins_url('images/checkmark.png', __FILE__); ?>" height="20px" align="absmiddle" /> <input type="text" name="list[]" id="list" value="<?php echo stripslashes(htmlentities($row['list'][3])); ?>" style="width:300px" maxlength="100" />
                    <br />
                    <img src="<?php echo plugins_url('images/checkmark.png', __FILE__); ?>" height="20px" align="absmiddle" /> <input type="text" name="list[]" id="list" value="<?php echo stripslashes(htmlentities($row['list'][4])); ?>" style="width:300px" maxlength="100" />
			        <div style="font-size:11px;color:#666;">Max length 100 characters</div>
                </td>
            </tr>
            <tr>
            	<th>Description</th>
                <td>
			        <textarea name="description" id="description" style="width:600px;height:150px;"><?php echo stripslashes($row['description']); ?></textarea>
                    <div style="font-size:11px;color:#666;">Write a call-to-action or description.</div>
              	</td>
            </tr>
            <tr>
            	<th>Autoresponder</th>
                <td>
			        <textarea name="autoresponder" id="autoresponder" style="width:600px;height:150px;"><?php echo stripslashes($row['html']); ?></textarea>
                    <div style="font-size:11px;color:#666;">Paste web form HTML or Javascript from your autoresponder service. e.g. <a href="http://aweber.cliftonhatfield.com" title="Aweber.com" target="_blank">Aweber</a>, <a href="http://getresponse.cliftonhatfield.com" title="GetResponse.com" target="_blank">GetResponse</a></div>
              	</td>
            </tr>
            <tr>
            	<th>Name Field</th>
                <td>
                	<select name="name_field" class="clp-select">
                    	<?php if($row['fields']) : foreach($row['fields'] as $name => $field) : if(!empty($name)) : ?>
                        <option value="<?php echo $name; ?>" <?php echo (preg_match('/name/', $name) || $row['selected_name'] == $name) ? 'selected="selected"' : ''; ?>><?php echo $name; ?></option>
                        <?php endif; endforeach; endif; ?>
                    </select>
                </td>
            </tr>
            <tr>
            	<th>Email Field</th>
                <td>
                	<select name="email_field" class="clp-select">
                    	<?php if($row['fields']) : foreach($row['fields'] as $name => $field) : if(!empty($name)) : ?>
                        <option value="<?php echo $name; ?>" <?php echo (preg_match('/email/', $name) || $row['selected_email'] == $name) ? 'selected="selected"' : ''; ?>><?php echo $name; ?></option>
                        <?php endif; endforeach; endif; ?>
                    </select>
                </td>
            </tr>
        	<tr>
            	<th>Submit Button</th>
				<td>
                    <input type="text" name="button" id="button" value="<?php echo $button; ?>" style="width:300px" maxlength="25" />
                    <div style="font-size:11px;color:#666;">Max length 25 characters inside of the submit button.</div>
                </td>
            </tr>
            <tr>
            	<th>Privacy Statement</th>
                <td>
			        <input type="text" name="privacy" id="privacy" value="<?php echo $row['privacy']; ?>" style="width:300px" maxlength="100" />
			        <div style="font-size:11px;color:#666;">e.g. Your name and email address will never be sold.</div>
                </td>
            </tr>
            <tr>
            	<th>Time Delay</th>
                <td>
          	        <select name="delay">
						<?php for($i = 1;$i <= 10;$i++)
                        {
                            echo ($row['delay'] == $i) ? '<option value="'.$i.'" selected="selected">'.$i.' sec</option>' : '<option value="'.$i.'">'.$i.' sec</option>';
                        }
                        ?>
                    </select>
			        <div style="font-size:11px;color:#666;">Delay lightbox loading in seconds.</div>
				</td>
            </tr>
            <tr>
            	<th>Cookie Life</th>
                <td>
                    <select name="cookie_life">
                        <option value="minute"<?php echo ($row['cookie_life'] == 'minute') ? 'selected="selected"' : ''; ?>>Every Minute</option>
                        <option value="hour"<?php echo ($row['cookie_life'] == 'hour') ? 'selected="selected"' : ''; ?>>Every Hour</option>
                        <option value="five_hours"<?php echo ($row['cookie_life'] == 'five_hours') ? 'selected="selected"' : ''; ?>>Every 5 Hours</option>
                        <option value="twentyfour_hours"<?php echo ($row['cookie_life'] == '') ? 'selected="selected"' : ''; ?>>Every 24 Hours</option>
                        <option value="thirty_days"<?php echo ($row['cookie_life'] == 'thirty_days') ? 'selected="selected"' : ''; ?>>Every 30 Days</option>
                        <option value="six_months"<?php echo ($row['cookie_life'] == 'six_months') ? 'selected="selected"' : ''; ?>>Every 6 Months</option>
                        <option value="until_deleted" <?php echo ($row['cookie_life'] == 'until_deleted' || $row['cookie_life'] == '') ? 'selected="selected"' : ''; ?>>Until Deleted</option>            
                    </select>
					<div style="font-size:11px;color:#666;">Cookies prevent the lightbox from appearing every time a web page loads. You can adjust how often the visitor will see the lightbox. Recommended: Until Deleted</div>
                </td>
            </tr>
            <tr>
            	<th>Powered By</th>
                <td>
                	<select name="poweredby">
                    	<option value="1"<?php echo ($row['poweredby'] == '1' || $row['poweredby'] == '') ? 'selected="selected"' : ''; ?>>Yes</option>
                        <option value="0"<?php echo ($row['poweredby'] == '0') ? 'selected="selected"' : ''; ?>>No way</option>                        
                    </select>
                    <div style="font-size:11px;color:#666;">Share the love & display <em>Clifton's Lightbox Plugin</em> discreetly in the footer of the lightbox.</div>
                </td>
            </tr>
            <tr>
            	<td></td>
                <td>
                    <input type="submit" name="lightbox_submit" value="Save" class="button-primary" />
                    <a href="<?php echo admin_url(); ?>admin-ajax.php?action=clp_lightbox" class="button" target="_blank">View Lightbox</a> <small>Save first to view any changes.</small>
                </td>
            </tr>
            <tr>
            	<th>Delete Cookie</th>
                <td>
                    <input type="button" name="clpdeletecoookie" value="Delete Cookie" id="clp-delete-cookie" class="button-secondary" />
                    <div style="font-size:11px;color:#666;"><strong>Having trouble seeing the lightbox?</strong> It may have already set the cookie. Try deleting it.</div>
                </td>
            </tr>
        </tbody>
    </table>
    </form>
	
    <h3>Tips for an Awesome Lightbox</h3>
    <ul style="padding-left:25px;">
        <li style="color:#666;padding:4px 0;list-style-type:circle;">Always <a href="<?php echo admin_url(); ?>admin-ajax.php?action=clp_lightbox" target="_blank">preview</a> your lightbox after saving. Make sure there are no overlapping elements. If so, reduce characters or resize your media.</li>
        <li style="color:#666;padding:4px 0;list-style-type:circle;">Using a video is a great way to get your message across to your visitors.</li>
        <li style="color:#666;padding:4px 0;list-style-type:circle;">Use the Description area as a call-to-action and encourage your visitors to enter their credentials. Sometimes, you have to tell people what you want them to do.</li> 
        <li style="color:#666;padding:4px 0;list-style-type:circle;">Less is best. If you find yourself typing a lot of text in the title, bullet list, and description than you probably have too much text. Keep the text to a minimum & deliver your full message in a video.</li>
        <li style="color:#666;padding:4px 0;list-style-type:circle;">Be cautious with the Cookie Life setting. If you set the Cookie Like to expire every minute, that means each time a visitor clicks a link & it's been at least a minute since they last saw the lightbox, they will see it again...and again...and again. Don't annoy your visitors!</li>
        <li style="color:#666;padding:4px 0;list-style-type:circle;">Keep the bullet points short & sweet. Highlight reasons why the visitor should subscribe.</li>
        <li style="color:#666;padding:4px 0;list-style-type:circle;">Do you have videos on your blog? Sometimes video players will cover the lightbox. This is because the video player's transparency isn't set. If it's a YouTube video, try appending this to the URL <strong>&amp;wmode=Opaque</strong></li>
        
    </ul>
    <br />
    <h3>Developers work hard on free plugins. Like me on Facebook.</h3>
    <iframe src="http://www.facebook.com/plugins/like.php?app_id=133915730030734&amp;href=http%3A%2F%2Ffacebook.com%2Fcliftonhatfield.page&amp;send=false&amp;layout=standard&amp;width=450&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:80px;" allowTransparency="true"></iframe>
    
    <h3>About</h3>
	<p style="width:600px;">
        Clifton's Lightbox Plugin is developed and maintained by <a href="http://cliftonhatfield.com" target="_blank">Clifton Hatfield</a>.
        If you have any questions or need support for this plugin, please be sure to watch the <a href="http://lightbox.cliftonhatfield.com" target="_blank">video tutorial</a>.
        If you have additional questions you can <a href="http://cliftonscott.com" target="_blank">contact support</a>. ColorBox is developed and maintained by
        <a href="http://www.jacklmoore.com/colorbox" target="_blank">Jack Moore</a> Additional WordPress support can be found 
        <a href="http://cliftonhatfield.com/wordpress-video-tutorials/" target="_blank">here</a>.
    </p>
    <h3>Find Clifton</h3>
    <ul>
        <li><a href="http://facebook.com/cliftonhatfield.page" target="_blank">On Facebook</a></li>
        <li><a href="http://twitter.com/cliftonhatfield" target="_blank">On Twitter</li>
        <li><a href="http://www.youtube.com/user/CliftonH" target="_blank">On Youtube</li>
        <li><a href="http://cliftonhatfield" target="_blank">On Blog</a></li>
    </ul>
    <h3>My WordPress Blog Design Service</h3>
    <ul>
    	<li><a href="http://www.empoweredblogs.com" target="_blank">EmpoweredBlogs.com</a>
    </ul>
    <h3>Facebook Support Group</h3>
    <p>
        WordPress, SEO, and Internet Questions is my support group on Facebook. Visit <br />
        <a href="http://facebook.com/groups/internet.questions/" target="_blank">http://facebook.com/groups/internet.questions/</a><br />
    </p>
</div>