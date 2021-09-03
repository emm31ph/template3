<template>
	<div>
		<div class="container-fluidpy-0pl-0">
			<div class="row mb-2">
				<div class="col-3">
					<img
						src="/img/logo.png"
						class="rounded float-left img-thumbnail mr-2"
						style="width: 70px"
					/>
				</div>
				<div class="col-6 text-center position-relative">
					<p class="h4 font-weight-bold mb-0">TOSEN FOODS, INC.</p>
					<div class="position-relative m-0" style="font-size: 9px">
						<b>{{ setBranch(this.isUser.branch, "address") }}</b>
					</div>
					<div class="position-relative m-0" style="font-size: 9px">
						<b>Tel: </b
						>{{ setBranch(this.isUser.branch, "tel") }} &nbsp;
						<b>Email: </b
						>{{ setBranch(this.isUser.branch, "email") }}
					</div>
					<p class="h5 font-weight-bold mb-0">{{ title }}</p>
				</div>
				<div class="col-3 text-right">
					<p class="font-weight-bold m-0">
						{{ docno }}
					</p>
					<div
						class="text-muted m-0 overlay-text"
						style="font-size: 9px"
					>
						Printed Date :
						{{ this.dateTime }}
					</div>
				</div>
			</div>
		</div>
		<hr class="my-2" />
	</div>
</template>

<script>
export default {
	name: "PrintHeader",
	props: {
		title: String,
		docno: String,
	},
	data() {
		return {};
	},
};
</script>

<style>
.border-10 {
	border-top: 1px solid black;
}
</style>