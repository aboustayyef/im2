// Vue
window.Vue = require('vue');

// Axios for REST requests
window.axios = require('axios');

// Modal to upload content
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
		axios.get('/goods').then((response) => {
			this.goods = response.data;
			this.appReady = 1;
			document.getElementById('loading').classList.add('hidden');
			document.getElementById('app').classList.remove('hidden');
		});
	},
	data: {
		appReady:0,
		goods: {},
		invoicePreparer: "",
		customerName: "",
		customerAddress: "",
		searchTerm: "",
	},

	computed: {
	    // a computed getter
	    totalEx: function () {
	      if (this.appReady == 1) {
	      	let total = this.goods.reduce(function(total, item){
				return total + (item.PriceEx * item.AddedToInvoice);
			},0.00);
			return total;
	      }
	      return 0;
	      
	    },
	    totalIn: function () {
	      if (this.appReady == 1) {
	      	let total = this.goods.reduce(function(total, item){
				return total + (item.PriceIn * item.AddedToInvoice);
			},0.00);
			return total;
	      }
	      return 0;
	    },
	    vat: function(){
	    	return this.totalIn - this.totalEx;
	    }

	  },

	methods: {
		containsSearchTerm: function(good){
				let reg = new RegExp(this.searchTerm, "gi");
				return (good.Name.match(reg) != null) || (good.Description.match(reg) != null) || (good.Code.match(reg) != null) || (good.Supplier.match(reg) != null);
		},
		increment: function(good){
			if (good.AddedToInvoice < good.Stock) {
				good.AddedToInvoice++;
			}
		},
		AddedToInvoice: function(good){
			return good.AddedToInvoice > 0;
		},
		formatPrice : function(cedis) {
			var pesewas = cedis * 100;
			return 'GH¢ ' + ( (pesewas / 100).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") );
		},

		openModal(){
			document.getElementById('uploadCsv').classList.add('is-active');
		},
	}

});