<html>
<head>
	<title>Add Data</title>
	<style>
		/* Style for the entire body */
		body {
			font-family: Arial, sans-serif;
			background-color: #f9f9f9;
			color: #333;
			margin: 0;
			padding: 0;
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
		}

		/* Center container */
		.container {
			text-align: center;
		}

		/* Form styling */
		form {
			background-color: #fff;
			padding: 20px;
			border-radius: 8px;
			box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
			width: 300px;
			margin: 0 auto;
		}

		/* Headings */
		h2 {
			margin-bottom: 20px;
			color: #555;
		}

		/* Style links */
		a {
			display: inline-block;
			margin-bottom: 20px;
			text-decoration: none;
			color: #007bff;
			font-size: 14px;
		}

		a:hover {
			text-decoration: underline;
		}

		/* Table */
		table {
			width: 100%;
		}

		td {
			padding: 10px 0;
			vertical-align: middle;
		}

		/* Inputs */
		input[type="text"] {
			width: 100%;
			padding: 8px;
			border: 1px solid #ccc;
			border-radius: 4px;
			font-size: 14px;
			box-sizing: border-box;
		}

		/* Submit button */
		input[type="submit"] {
			background-color: #007bff;
			color: #fff;
			border: none;
			padding: 10px;
			font-size: 16px;
			border-radius: 4px;
			cursor: pointer;
			width: 100%;
		}

		input[type="submit"]:hover {
			background-color: #0056b3;
		}
	</style>
</head>
<body>
	<div class="container">
		<h2>Add Data</h2>
		<p>
			<a href="home.php">Home</a>
		</p>

		<form action="addAction.php" method="post" name="add">
			<table>
				<tr> 
					<td>Name</td>
					<td><input type="text" name="name"></td>
				</tr>
				<tr> 
					<td>Age</td>
					<td><input type="text" name="age"></td>
				</tr>
				<tr> 
					<td>Email</td>
					<td><input type="text" name="email"></td>
				</tr>
				<tr> 
					<td></td>
					<td><input type="submit" name="submit" value="Add"></td>
				</tr>
			</table>
		</form>
	</div>
</body>
</html>