// window.$ = window.jQuery = require('jquery');

// global.bg = {};

// import GoodsRepository from './modules/goods.js' ;
// let goodsRepository = new GoodsRepository;

// var searching = require('./modules/searching.js'); 
// searching.init(goodsRepository);

// var invoicing = require('./modules/invoicing.js'); 
// invoicing.init(goodsRepository);



// goods data (now using ajax)
// import goods from './data.js';

// Vue

window.Vue = require('vue');

window.axios = require('axios');

// App


Vue.component('im-modal',{
	template: `
		<div id="uploadCsv" class="modal">
		<div class="modal-background"></div>
		<div class="modal-content">
			<slot></slot>
		</div>
		<button @click="closeModal" class="modal-close"></button>
		</div>
	`,
	methods:{
		closeModal(e){
			// remove modal window
			e.target.parentNode.classList.remove('is-active');
		}
	} 
});

new Vue({

	el: "#app",
	mounted(){
		axios.get('/goods').then((response) => this.goods = response.data);
	},
	data: {
		goods: {},
		invoicePreparer: "",
		customerName: "",
		customerAddress: "",
		searchTerm: "",
		searchResults: [],
		invoiceItems: []
	},

	methods: {
		updateSearchResults: function(event) {
			this.searchResults = this.goods.filter((item) => {
				let reg = new RegExp(this.searchTerm, "gi");
				return (item.Name.match(reg) != null) || (item.Description.match(reg) != null) || (item.Code.match(reg) != null) || (item.Supplier.match(reg) != null);
			});
		},
		formatPrice : function(cedis) {
			var pesewas = cedis * 100;
			return 'GH¢ ' + ( (pesewas / 100).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") );
		},

		updateInvoiceItems: function(event) {

			// receive code of item to add from add button event
			let code = event.target.dataset.code; 

			// find where that code is in the list of goods
			let index = this.goods.findIndex((item) => item.Code == code);
			let itemToAdd = this.goods[index];

			// if the item exists among invoiceItems
			let exists = this.invoiceItems.findIndex((item) => item.item.Code == code);
			if (exists > -1) {
				let existingItem = this.invoiceItems[exists];
				//	if quatity < amount in stock increase quantity and update pricing. Otherwise do nothing
				if (existingItem.quantity < itemToAdd.Stock) {
					existingItem.quantity++;
					existingItem.totalEx = existingItem.quantity * existingItem.priceEx;
					existingItem.totalIn = existingItem.quantity * existingItem.priceIn;
				} else {
					console.log('no more in stock');
				}
			}else{ // Item does not exist. Create new item on invoice
				this.invoiceItems.push({quantity:1, item: itemToAdd, priceEx: itemToAdd.PriceEx * 1.00, priceIn: itemToAdd.PriceIn * 1.00, totalEx:itemToAdd.PriceEx * 1.00, totalIn:itemToAdd.PriceIn * 1.00});
			}
			// 			Increase quantity
		},

		openModal(){
			document.getElementById('uploadCsv').classList.add('is-active');
		},

		removeInvoiceItem: function(index){
			this.invoiceItems.splice(index, 1);
		},

		invoiceGrandTotalEx: function(){
			let total = this.invoiceItems.reduce(function(total, item){
				return total + item.totalEx;
			},0.00);
			return total;
		},
		invoiceGrandTotalIn: function(){
			let total = this.invoiceItems.reduce(function(total, item){
				return total + item.totalIn;
			},0.00);
			return total;
		},
		invoiceGrandTotalVat: function(){
			return this.invoiceGrandTotalIn() - this.invoiceGrandTotalEx();
		}
	}

});


