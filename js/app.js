const url = 'db/crud.php';

var app = new Vue({
	el: '#app',
	data: {
		errorMsg: false,
		successMsg: false,
		showModal: false,
		users: null,
		lastUser: null,
		newUser: {},
		members: [],
		search: { product: '' },
		noMember: false,
	},
	mounted() {
		this.fetchMembers();
	},
	methods: {
		searchProduct() {
			let axiosParams = { option: 'buscar', busca: this.search.product };
			axios.post('db/crud.php', axiosParams).then((response) => {
				this.members = response.data;
				if (response.data == '') {
					this.noMember = true;
				} else {
					this.noMember = false;
				}
			});
			document.getElementById('busca-producto').focus();
		},

		fetchMembers() {
			let axiosParams = { option: 'listar' };
			axios
				.post('db/crud.php', axiosParams)
				.then((response) => {
					this.members = response.data;
				})
				.catch((e) => {
					this.noMember = true;
					console.log(e);
				});
		},

		/*  addUser updateUser deleteUser
		addUser() {
			var vData = this.toData(this.currentUser);
			axios
				.post('dbTrans.php?action=create', vData)
				.then((response) => {
					// Respuesta del servidor
					if (response.data.error) {
						this.errorMsg = response.data.message;
					} else {
						this.fetchMembers();
						this.successMsg = response.data.message;
					}
				})
				.catch((e) => {
					console.log(e);
				});
		},

		updateUser() {
			var vData = this.toData(this.currentUser);
			axios
				.post('dbTrans.php?action=update', vData)
				.then((response) => {
					// Respuesta del servidor
					if (response.data.error) {
						this.errorMsg = response.data.message;
					} else {
						this.fetchMembers();
						this.successMsg = response.data.message;
					}
				})
				.catch((e) => {
					console.log(e);
				});
		},

		deleteUser() {
			var vData = this.toData(this.currentUser);
			axios
				.post('dbTrans.php?action=delete', vData)
				.then((response) => {
					if (response.data.error) {
						this.errorMsg = response.data.message;
					} else {
						this.fetchMembers();
						this.newReg();
						this.successMsg = response.data.message;
					}
				})
				.catch((e) => {
					console.log(e);
				});
		},
		*/

		selectProduct(producto) {
			// Asignar el id de producto seleccionado
			this.currentProducto = producto;
			sessionStorage.setItem('nombreProducto', producto.nombre);
			console.log('Variable de session nombreProducto');
			console.log(sessionStorage.getItem('nombreProducto'));
		},

		newReg() {
			this.currentProducto.id = '-';
			this.currentProducto.producto = '';
			this.currentProducto.nombre = '';
			this.currentProducto.ean = '';
			this.currentProducto.desCorta = '';
			this.currentProducto.imgCorta = '';
			this.successMsg = false;
			document.getElementById('busca-producto').focus();
		},
	},
});
