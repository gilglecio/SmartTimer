<!doctype html>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">
		<title>Smart Timer</title>

		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

		<script type="text/javascript">

			$(document).ready(function() {

				$('input').on('click', function () {
					enviar();
				});

				function enviar() {

					$.post('SmartTimer.php', {
						date1: $('.date1').val()+' '+$('.time1').val()+':00',
						date2: $('.date2').val()+' '+$('.time2').val()+':00'
					}, function (data) {

						if (!data.string) return false;

						$('.view').html('<h1>'+data.string+'</h1>');

					}, 'json');
				}
			});
		</script>
	</head>
	<body>
		
		<h2>Intervalo</h2>

		<form action="">
			<p>De <input class="date1" type="date" name="date1" /><input class="time1" type="time" name="time1" value="00:00" />
				Até
				<input class="date2" type="date" name="date2" /><input class="time2" type="time" name="time2" value="00:00" /></p>
		</form>

		<div class="view">
			<h1>Aguardando dados...</h1>
			<p></p>
		</div>

	</body>
</html>
