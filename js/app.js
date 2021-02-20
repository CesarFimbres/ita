const url = 'db/dbTrans.php';

var app = new Vue({
	el: '#app',
	data: {
		errorMsg: false,
		successMsg: false,
		showModal: false,
		users: null,
		lastUser: null,
		newUser: {},
		currentUser: { id: '-' },
		members: [],
		search: { keyword: '' },
		noMember: false,
	},
	mounted() {
		this.fetchMembers();
	},
	methods: {
		searchMonitor() {
			var keyword = this.toData(this.search);
			axios
				.post('dbTrans.php?action=search', keyword)
				.then(function (response) {
					app.members = response.data.members;
					if (response.data.members == '') {
						app.noMember = true;
					} else {
						app.noMember = false;
					}
				});
		},

		fetchMembers() {
			axios.post('dbTrans.php?action=show').then(function (response) {
				app.members = response.data.members;
			});
		},

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

		toData(obj) {
			var fd = new FormData();
			for (var i in obj) {
				fd.append(i, obj[i]);
			}
			return fd;
		},

		selectUser(user) {
			this.currentUser = user;
			// Asignar el id de tablero seleccionado
			sessionStorage.setItem('idTablero', user.id);
		},

		newReg() {
			this.currentUser.id = '-';
			this.currentUser.cliente = '';
			this.currentUser.proyecto = '';
			this.currentUser.nombre = '';
			this.currentUser.fecha = '';
			this.currentUser.sistema = '';
			this.currentUser.voltaje = '';
			this.currentUser.unifilar = '';
			this.currentUser.layout = '';
			this.currentUser.material = '';
			this.currentUser.metrel = '';
			this.currentUser.comentario = '';
			this.currentUser.sttablero = 'NO ESPECIFICADO';
			this.currentUser.stinspeccion = 'NO ESPECIFICADO';
			this.currentUser.stcontinuidad = 'NO ESPECIFICADO';
			this.currentUser.stresistencia = 'NO ESPECIFICADO';
			this.currentUser.sthipot = 'NO ESPECIFICADO';
			this.successMsg = false;
			document.getElementById('v01').focus();
		},
	},
});
