<template>
	<div v-if="warningZone" class="bg-warning px-2">Are you still with us?</div>
</template>

<script>
export default {
	name: "auto-logout",
	data() {
		return {
			events: [
				"click",
				"mousemove",
				"mousedown",
				"scroll",
				"keypress",
				"load",
			],
			warningTimer: null,
			logoutTimer: null,
			warningZone: false,
		};
	},
	mounted() {
		this.events.forEach(function (event) {
			window.addEventListener(event, this.restTimer);
		}, this);
		this.setTimers();
	},
	destroyed() {
		this.events.forEach(function (event) {
			$(".modal-backdrop").remove();
			window.removeEventListener(event, this.restTimer);
		}, this);
		this.restTimer();
	},
	methods: {
		setTimers() {
			this.warningTimer = setTimeout(this.warningMessage, 5 * 100000);
			this.logoutTimer = setTimeout(this.autologout, 10 * 100000);
			this.warningZone = false;
		},
		warningMessage() {
			this.warningZone = true;
		},
		restTimer() {
			clearTimeout(this.warningTimer);
			clearTimeout(this.logoutTimer);
			this.setTimers();
		},
	},
};
</script>

<style>
</style>