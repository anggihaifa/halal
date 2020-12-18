<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style type="text/css">
	body{
		border:solid 1px #c9c9c9;
		border-radius: 5px;
		padding: 15px;
		font-family: Arial, Helvetica, sans-serif;
	}

	.body-bg{
		position: absolute;
		z-index: -1;
		margin: auto;
		top: 45%;
		left: 30%;
		opacity: 0.075;
	}

	.forHeader{
		background: #ededed;
		width: 100%;
		padding: 15px 5px;
		height: 65px;
		border-radius: 5px;
		margin-bottom: 20px;
	}
	.forHeader .inHeader{
		display: flex;
		color: #117391;
	}
	.logo-sucofindo{
		margin-top: 5px;
		margin-left: 15px;
		width: 100px;
	}
	.text-header{
		margin-left: 130px;
		font-size: 22px;
	}

	.text-header > div{
		margin-bottom: 7px;
	}

	.forNoReg{
		margin-bottom: 15px;
		padding: 10px 15px;
		background: #cbedf7;
		border-radius: 5px;
	}
	.forNoReg > div{
		margin-bottom: 5px;
	}

	.forTitle{
		padding: 10px;
		background: #a5e8b9;
		font-weight: bold;
		font-size: 15px;
		text-align: center;
		border-radius: 5px;
		margin-bottom: 10px;
		color: #454545;
	}
	td{
		padding: 5px;
	}
	.forData{
		font-size: 15px;
	}
	.forData b{
		color:#2b2b2b;
	}
	.isiData{
		padding: 15px 0px 0px 15% ;
	}
</style>

<body>
	<img class="body-bg" src="{{ public_path('/assets/img/logo/sci-color.png') }}" alt="" >
	<div class="forHeader">
		<div class="inHeader">
			<img class="logo-sucofindo" src="{{ public_path('/assets/img/logo/sci-color.png') }}" alt="" >
			<div class="text-header">
				<div>LEMBAGA PEMERIKSA HALAL</div>
				<div>SUCOFINDO</div>
			</div>
		</div>
	</div>
</body>
</html>
