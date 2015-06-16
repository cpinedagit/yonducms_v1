<?php extract($data); ?>
<body>
	Hi System Admin, <br/>
	<br/>
    This is to inform the system admin that username: <?php echo $data['username'] ?> <br/>
    	With the follwing user details: <br/>
    	Name: <?php echo $data['first_name']." ".$data['last_name']; ?> <br/>
    	Email Address: <?php echo $data['email_address']; ?> <br/>
    	Has been blocked for accessing the system due to <?php echo $data['failed_login_attemp'] ?> failed log-in attemps. <br/>

    	Click this {!! HTML::link(URL().'/auth/login', 'link', '') !!} to log-in.<br/> 
    <br/>
    Thank you!
</body>