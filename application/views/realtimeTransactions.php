<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
  <title>All Transactions</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
</head>
<style>
	.customContainer{
		margin-top: 5%;
	}
</style>
	<body>
		<div class="container customContainer">
		<h2>All Transactions</h2>
		<p>Real time visualization of consumed transactions</p>            
		<table class="table table-hover">
			<thead>
			<tr>
				<th>Transaction Id</th>
				<th>UserId</th>
				<th>Conversion(From -> To)</th>
				<th>Amount to Convert</th>
				<th>Rate</th>
				<th>Amount Recieved</th>
				<th>Time Placed</th>
				<th>Originating Country</th>
				<th>Status</th>
			</tr>
			</thead>
			<tbody id="appendTransactions">
			
			</tbody>
		</table>
		</div>
	</body>
</html>

<script>

function executeQuery() {
	$.ajax({
		url: 'Frontend/fetchAllMessages',
		success: function(response) {
			var result = JSON.parse(response.data);
			console.log(result);
			for(var j in result){
				if(!$('#transaction_'+result[j].id).is(':visible')){
					$('#appendTransactions').prepend(
						'<tr id="transaction_'+result[j].id+'">'+
							'<td>'+result[j].id+'</td>'+
							'<td>'+result[j].userId+'</td>'+
							'<td>'+result[j].currencyFrom+' -> '+result[j].currencyTo+'</td>'+
							'<td>'+result[j].amountSell+'</td>'+
							'<td>'+result[j].rate+'</td>'+
							'<td>'+result[j].amountBuy+'</td>'+
							'<td>'+result[j].timePlaced+'</td>'+
							'<td>'+result[j].originatingCountry+'</td>'+
							'<td>'+result[j].status+'</td>'+
						'</tr>'
					);
					$('#transaction_'+result[j].id).animate({
						backgroundColor: "#db5151",
						color: "#fff"
					}, 500 )
					.animate({
						backgroundColor: "#fff",
						color: "#000"        
					}, 500);
				}
			}
		}
	});
	setTimeout(executeQuery, 5000);
}
$(document).ready(function() {
	executeQuery();
});



</script>