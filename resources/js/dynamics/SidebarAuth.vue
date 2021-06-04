<template>
	<ul
		class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion"
		:class="isActive ? 'toggled' : false"
		id="accordionSidebar"
	>
		<!-- Sidebar - Brand -->
		<a
			class="sidebar-brand d-flex align-items-center justify-content-center"
			href="index.html"
		>
			<div class="sidebar-brand-icon rotate-n-15">
				<i class="fas fa-laugh-wink"></i>
			</div>
			<div class="sidebar-brand-text mx-3">TOSEN</div>
		</a>

		<!-- Divider -->
		<hr class="sidebar-divider my-0" />

		<!-- Nav Item - Dashboard -->
		<li class="nav-item">
			<router-link :to="{ name: 'dashboard' }" class="nav-link">
				<i class="fas fa-fw fa-tachometer-alt"></i>
				Dashboard
			</router-link>
		</li>

		<!-- Divider -->
		<hr class="sidebar-divider" />

		<!-- Heading -->
		<div class="sidebar-heading">Interface</div>

		<!-- Nav Item - Pages Collapse Menu -->
		<li class="nav-item" v-if="isAbleTo(['items-*'])">
			<a
				class="nav-link collapsed"
				href="#"
				data-toggle="collapse"
				data-target="#collapseTwo"
				aria-expanded="true"
				aria-controls="collapseTwo"
			>
				<i class="fas fa-fw fa-cog"></i>
				<span>Inventory</span>
			</a>
			<div
				id="collapseTwo"
				class="collapse"
				aria-labelledby="headingTwo"
				data-parent="#accordionSidebar"
			>
				<div class="bg-white py-2 collapse-inner rounded">
					<h6 class="collapse-header">Custom Inventory:</h6>
					<router-link
						:to="{ name: 'item' }"
						class="collapse-item"
						v-if="can('items-read')"
					>
						Dashboard
					</router-link>
					<router-link
						:to="{ name: 'delivery' }"
						class="collapse-item"
						v-if="can('items-delivery')"
					>
						Delivery
					</router-link>
					<router-link
						:to="{ name: 'items-fptd' }"
						class="collapse-item"
						v-if="can('items-fptd')"
					>
						FPTD
					</router-link>
					<router-link
						:to="{ name: 'items-rr' }"
						class="collapse-item"
						v-if="can('items-rr')"
					>
						Recieving Report
					</router-link>
					<router-link
						:to="{ name: 'items-rrm' }"
						class="collapse-item"
						v-if="can('items-rrm')"
					>
						RRM
					</router-link>
					<router-link
						:to="{ name: 'items-reject' }"
						class="collapse-item"
						v-if="can('items-reject')"
					>
						Reject
					</router-link>
					<router-link
						:to="{ name: 'import' }"
						class="collapse-item"
						v-if="can('items-import')"
					>
						Import
					</router-link>
				</div>
			</div>
		</li>

		<!-- Nav Item - Utilities Collapse Menu -->
		<li class="nav-item" v-if="isAbleTo(['role-*'])">
			<a
				class="nav-link collapsed"
				href="#"
				data-toggle="collapse"
				data-target="#collapseUtilities"
				aria-expanded="true"
				aria-controls="collapseUtilities"
			>
				<i class="fas fa-fw fa-wrench"></i>
				<span>Utilities</span>
			</a>
			<div
				id="collapseUtilities"
				class="collapse"
				aria-labelledby="headingUtilities"
				data-parent="#accordionSidebar"
			>
				<div class="bg-white py-2 collapse-inner rounded">
					<router-link
						:to="{ name: 'roles' }"
						class="collapse-item"
						v-if="can('role-read')"
					>
						Roles
					</router-link>
					<router-link
						:to="{ name: 'product' }"
						class="collapse-item"
						v-if="!can('product-read')"
					>
						Product
					</router-link>
				</div>
			</div>
		</li>

		<!-- Nav Item - Tables -->
		<li class="nav-item" v-if="isAbleTo(['users-*'])">
			<router-link :to="{ name: 'users' }" class="nav-link">
				<i class="fas fa-fw fa-users"></i>
				<span>Users</span></router-link
			>
		</li>

		<!-- Divider -->
		<hr class="sidebar-divider d-none d-md-block" />

		<!-- Sidebar Toggler (Sidebar) -->
		<div class="text-center d-none d-md-inline">
			<button
				class="rounded-circle border-0"
				id="sidebarToggle"
				@click="isActive = !isActive"
			></button>
		</div>
	</ul>
</template>

<script>
export default {
	data() {
		return {
			isActive: false,
		};
	},
};
</script>

<style>
</style>