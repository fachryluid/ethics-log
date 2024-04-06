<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>@yield('title')</title>
		<style>
			table {
				border-collapse: collapse;
				width: 100%;
			}

			.header th,
			.header td {
				text-align: center;
				/* border: 1px solid black; */
			}

			.header tr td:first-child {
				width: 100px;
			}

			.header {
				text-align: left;
				border-bottom: 2px solid #dddddd;
				padding-bottom: 10px;
			}

			.header img {
				width: 100px;
				height: auto;
				/* border: 1px solid black; */
			}

			.content th,
			.content td {
				border: 1px solid #dddddd;
				text-align: left;
				padding: 8px;
			}

			.content th {
				background-color: #f2f2f2;
			}
		</style>
	</head>

	<body>
		<div class="header">
			<table>
				<tr>
					<td>
						<img src="{{ public_path('images/assets/logo-ung.png') }}" alt="Logo">
					</td>
					<td>
						<div><b>KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</b></div>
						<div><b>UNIVERSITAS NEGERI GORONTALO</b></div>
						<div>Jalan: Jenderal Sudirman No. 6 Kota Gorontalo</div>
						<div>Telepon: (0435) 821125 fax (0435) 821752</div>
						<div>Laman: www.ung.ac.id</div>
					</td>
				</tr>
			</table>
		</div>
		<section class="">
			@yield('content')
		</section>
	</body>

</html>
