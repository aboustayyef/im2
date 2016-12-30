<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Blue Gallery Invoicing</title>
	<link rel="stylesheet" type="text/css" href="app.css">
	<link rel="stylesheet" type="text/css" href="/css/app.css">
</head>
<body>
<div id="app" class="wrapper">
	<im-modal>
		<div class="section">
			<form action="/uploadCsv" method="post" enctype="multipart/form-data">
				<?php echo csrf_field(); ?>
				<p class="control">
					<input type="file" name="csv" id="csv">
				</p>
				<button type="submit" class="button is-primary">Upload</button>
			</form>
		</div>
	</im-modal>
	<aside id="interface" class="hideFromPrint">

		@if(Session::has('message'))
			<div class="notification">
			  {{Session::get('message')}}
			</div>
		@endif
		<button class="button is-primary" @click="openModal">Upload New Spreadsheet</button>
		<hr>

		<label class="label">Invoice Prepared By</label>
		<p class="control">
		  <input v-model="invoicePreparer" id="preparedBy" name="preparedBy" class="input" type="text" >
		</p>

		<label class="label">Customer Name</label>
		<p class="control">
		  <input v-model="customerName" id="customerName" name="preparedBy" class="input" type="text" >
		</p>
		
		<label class="label">Customer Address</label>
		<p class="control">
		  <textarea v-model="customerAddress" name="customerAddress" id="customerAddress" class="textarea"></textarea>
		</p>

		<label class="label">Search For Items</label>
		<p class="control">
		  <input @keyup="updateSearchResults" v-model="searchTerm" class="input" type="text" id="search" placeholder="Description or Code" autocomplete="off">
		</p>

		<ul id="search_results">
			<li v-for="result in searchResults" class="search_item"> 
				<button @click="updateInvoiceItems" class="addSearchResultToInvoice button" :data-code="result.Code">Add</button> 
				<div v-text="result.Name + ' - ' + result.Description" class="description"></div>
			</li>
		</ul>
	</aside>
	
	<section id="output">
		<div class = "topPart">
			<header id="invoiceHeader">
				<div id="leftHeader">
					<h1 class="title is-3">QUOTE</h1>
					<p class="subtitle is-5">{{(new Carbon\Carbon)->toFormattedDateString() }}</p>
					<h3 v-text="customerName"></h3>
					<p v-text="customerAddress">'<p>
				</div>
				<div id="rightHeader">
					<img src="/img/logo.svg">
				</div>
			</header>
			<main><table id="invoiceTable" class="table">
						<thead>
							<tr>
								<th>Code</th><th>Brand</th><th>Name</th><th>Price</th><th>Qty</th><th>Total</th><th class="hideFromPrint">&nbsp;</th>
							</tr>
						</thead>
			
			<tbody>
				<tr v-for="(item, index) in invoiceItems">
					<td v-text="item.item.Code"></td>
					<td v-text="item.item.Brand"></td>
					<td v-text="item.item.Name"></td>
					<td v-text="formatPrice(item.priceEx)"></td>
					<td v-text="item.quantity"></td>
					<td v-text="formatPrice(item.totalEx)"></td>
					<td class="hideFromPrint"><button @click="removeInvoiceItem(index)" class="button is-danger">Remove</button></td>
				</tr>
			</tbody>
			</table>
			</main>
		</div>
		<footer>
			<div id="invoiceFooter">
				<div class="leftSide">
					<h5 v-text="'Prepared by ' + invoicePreparer"></h5>
					<h4>Blue Gallery Home and Office</h4>
					<h5>+233 303 300 121<br>bluegallery.com.gh</h5>
				</div>
				<div class="rightSide">
					<table>
						<tr>
							<td class="totals_heading">Subtotal: </td>
							<td v-text="formatPrice(invoiceGrandTotalEx())"></td>
						</tr>
						<tr>
							<td class="totals_heading">VAT (17.5%): </td>
							<td v-text="formatPrice(invoiceGrandTotalVat())"></td>
						</tr>
						<tr>
							<td class="totals_heading">Total: </td>
							<td v-text="formatPrice(invoiceGrandTotalIn())"></td>
						</tr>
					</table>
				</div>
			</div>
			<div id="footerMeta">
					<p>PAYMENT CONDITIONS<br>
					Cheques are payable to : TARZAN ENTERPRISE LTD.<br>
					Bank transfer : Bank : CAL BANK LTD. | Account name: Tarzan Enterprise Ltd. | Account number: 061018379022 | Branch sort
					code: 140102 | Swift code: ACCCGHAC | Account currency: Ghana Cedi</p>
					<p>EXEMPTED FROM 3% WITHHOLDING TAX<br>
					TIN: C0003222233</p>
					<p>Main showroom: TEMA, Aflao road, facing shell | Accra store: Maxmart 37 Mall, 1st floor</p>
			</div>
		</footer>
	</section>
</div>

</body>

<script src="{{asset('js/app.js')}}"></script>
</html>