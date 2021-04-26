<template>
	<div>
		<auto-logout v-if="isLogged" />

		<div id="wrapper">
			<!-- Sidebar -->
			<sidebar-auth></sidebar-auth>
			<!-- End of Sidebar -->

			<!-- Content Wrapper -->
			<div id="content-wrapper" class="d-flex flex-column">
				<!-- Main Content -->
				<div id="content">
					<!-- Topbar -->
					<topbar-auth></topbar-auth>
					<!-- End of Topbar -->

					<!-- Begin Page Content -->
					<div class="container-fluid">
						<!-- Page Heading -->
						<child></child>
					</div>
					<!-- /.container-fluid -->
				</div>
				<!-- End of Main Content -->

				<!-- Footer -->
				<footer class="sticky-footer bg-white">
					<div class="container my-auto">
						<div class="copyright text-center my-auto">
							<span>Copyright © Your Website 2020</span>
						</div>
					</div>
				</footer>
				<!-- End of Footer -->
			</div>
			<!-- End of Content Wrapper -->
		</div>
	</div>
</template>

<script>
import Child from "../components/Child.vue";
export default {
	middleware: "auth",
	name: "MainLayout",
};
Child;
</script>
