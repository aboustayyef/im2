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
	  <input v-model="searchTerm" class="input" type="text" id="search" placeholder="Description or Code" autocomplete="off">
	</p>

	<ul id="search_results">
		<li v-for="good in goods" class="search_item" v-if="containsSearchTerm(good)"> 
			<button :disabled="good.AddedToInvoice >= good.Stock" @click="increment(good)" class="addSearchResultToInvoice button is-small">Add</button>
			<div class="description">Available: @{{good.Stock - good.AddedToInvoice}} &mdash; @{{good.Name + ' - ' + good.Description}}</div>
		</li>
	</ul>
</aside>