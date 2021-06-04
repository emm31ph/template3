<template>
	<div>
		<a
			class="nav-link dropdown-toggle"
			href="#"
			id="alertsDropdown"
			role="button"
			data-toggle="dropdown"
			aria-haspopup="true"
			aria-expanded="false"
		>
			<i class="fas fa-bell fa-fw"></i>
			<!-- Counter - Alerts -->
			<span
				class="badge badge-danger badge-counter"
				v-if="getUnReadNoti != 0"
			>
				{{ getUnReadNoti.length }}</span
			>
		</a>
		<!-- Dropdown - Alerts -->
		<div
			class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
			aria-labelledby="alertsDropdown"
		>
			<h6 class="dropdown-header">Alerts Center</h6>
			<a
				class="dropdown-item d-flex align-items-center"
				href="#"
				v-for="(notify, i) in getUnReadNoti"
				:key="i"
			>
				<div class="mr-3">
					<div class="icon-circle bg-primary">
						<i class="fas fa-file-alt text-white"></i>
					</div>
				</div>
				<div>
					<div class="small text-gray-500">
						{{ longDate(notify.created_at) }}
					</div>
					<span class="font-weight-bold"
						>A new monthly report is ready to download!</span
					>
				</div>
			</a>

			<a class="dropdown-item text-center small text-gray-500" href="#"
				>Show All Alerts</a
			>
		</div>
	</div>
</template>

<script>
export default {
	data() {
		return {
			unReads: [],
		};
	},
	created() {},
	mounted() {
		this.interval = setInterval(() => {
			this.fetchMixinsUnReadNotify();
		}, 10000);
	},

	methods: {
		// async getNotification() {
		// 	await axios
		// 		.get("api/unreadNotification")
		// 		.then((res) => {
		// 			this.unRead = [];
		// 			this.unRead = res.data;
		// 		})
		// 		.catch((errror) => {
		// 			console.log(error);
		// 		});
		// },
	},
};
</script>

<style>
</style>