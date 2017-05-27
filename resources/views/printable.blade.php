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
			<tr v-for="good in goods" v-if="good.AddedToInvoice > 0">
				<td v-text="good.Code"></td>
				<td v-text="good.Brand"></td>
				<td v-text="good.Name"></td>
				<td v-text="formatPrice(good.PriceEx * 1.00)"></td>
				<td v-text="good.AddedToInvoice"></td>
				<td v-text="formatPrice(good.PriceEx * 1.00 * good.AddedToInvoice)"></td>
				<td><button class="button is-danger" @click="good.AddedToInvoice = 0">Remove</button></td>
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
						<td v-text="formatPrice(totalEx)"></td>
					</tr>
					<tr>
						<td class="totals_heading">VAT (3.00%): </td>
						<td v-text="formatPrice(vat)"></td>
					</tr>
					<tr>
						<td class="totals_heading">Total: </td>
						<td v-text="formatPrice(totalIn)"></td>
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
