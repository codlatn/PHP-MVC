<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>
<body>
    


 

<input type="email" name="email" id="email"> 

<input type="password" name="password"  id="password">
<input type="checkbox" id="remmber" name="remmber" id="remmber" >
 

<button   id="loginBtn" >Login</button>

 
 <br>
<!--
 <div style="color:brown">
 <?php if(!empty($errors)) { ?> 
<?= implode(' ', $errors); ?>

<?php } ?>
</div>
 -->

 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

 <script>
    $('#loginBtn').on('click', function(){
        //e.preventDefault();
        alert('hello');
        console.log('login Clicked');
        var email = $('#email').val();
        var pass = $('#password').val();
        var remmber = $('#remmber').val();

        $.ajax({
            url : '<?= url('/admin/login/access');?>',
            type  : 'post',
            dataType : 'json',
            data : {email:email, password:pass, remmber:remmber},
            success : function(data){
                console.log(data);
                console.log('data as json');
            },
        });

        
        
    })
 </script>
</body>
</html>