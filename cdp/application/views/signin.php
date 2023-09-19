<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!DOCTYPE html>
<html>
	<head>
		<title>Login Page</title>
	<!--Made with love by Mutiullah Samim -->
	
		<!--Bootsrap 4 CDN-->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		
		<!--Fontawesome CDN-->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

		<!--Custom styles-->
		<link rel="stylesheet" type="text/css" href="styles.css">
	</head>
	<body>
		<div class="main">
			<div class="d-flex justify-content-center h-100">
				<div class="card">
					<div class="card-header">
						<h3>Entrar</h3>
					</div>
					<div class="card-body">
						<form action="" method="POST">
							<div class="input-group form-group">
								<div class="input-group-prepend">
									<span style="color:white" class="input-group-text"><i class="fas fa-user"></i></span>
								</div>
								<input type="email" name="e_mail" class="form-control" placeholder="email">
							</div>
							<div class="input-group form-group">
								<div class="input-group-prepend">
									<span style="color:white" class="input-group-text"><i class="fas fa-key"></i></span>
								</div>
								<input type="password" name="passwd" class="form-control" placeholder="senha">
								<input type="hidden" name="secret" value="<?php echo (isset($_SESSION['secret']) ? $_SESSION['secret'] : NULL); ?>">
							</div>
							<div class="form-group">
								<input type="submit" style="color:white" value="Entrar" class="btn float-right login_btn">
							</div>
						</form>
					</div>
					<div class="card-footer">
						<div class="d-flex justify-content-center links">
							Não tem um acesso?<a href="#">Criar</a>
						</div>
						<div class="d-flex justify-content-center links">
							<a href="#">Esqueceu a senha?</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>

<style>

@import url('https://fonts.googleapis.com/css?family=Numans');

html,body{
background-image: url('<?php echo base_url('assets/images/background_logo.png'); ?>');
background-size: cover;
background-repeat: no-repeat;
height: 100%;
width: 100%;
font-family: 'Numans', sans-serif;
}

.main{
padding-top: 15%;
height: 100%;
align-content: center;
}

.card{
    margin-top: 20%;
height: 370px;
margin-top: auto;
margin-bottom: auto;
width: 400px;
background-color: rgba(0,0,0,0.5) !important;
}

.social_icon span{
font-size: 60px;
margin-left: 10px;
color: rgb(6, 148, 44);
}

.social_icon span:hover{
color: white;
cursor: pointer;
}

.card-header h3{
color: white;
}

.social_icon{
position: absolute;
right: 20px;
top: -45px;
}
.input-group-prepend span{
width: 50px;
background-color: rgb(6, 148, 44);
color: black;
border:0 !important;
}

input:focus{
outline: 0 0 0 0  !important;
box-shadow: 0 0 0 0 !important;

}

.remember{
color: white;
}

.remember input
{
width: 20px;
height: 20px;
margin-left: 15px;
margin-right: 5px;
}

.login_btn{
color: black;
background-color: rgb(6, 148, 44);
width: 100px;
}

.login_btn:hover{
color: black;
background-color: lightblue;
}

.links{
color: white;
}

.links a{
margin-left: 4px;
color: rgb(0, 201, 20)  !important;
}
</style>