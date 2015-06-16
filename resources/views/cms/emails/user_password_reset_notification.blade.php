<?php extract($data); ?>
<body>
	Hi <?php echo $first_name." ".$last_name ?>, <br/>
	<br/>
    This is to inform you that your password has been reset. <br/>
    kindly use the follwing user details: <br/><br/>
    	
    	Username: <?php echo $username; ?> <br/>
    	Temporary Password: <?php echo $temporary_password ?> <br/><br/>
 
    Please try to access your login ID and change your password immediately.<br/> 
    Click this {!! HTML::link(URL().'/auth/login', 'link', '') !!} to log-in.<br/> 
    <br/>
    Thank you!
</body>