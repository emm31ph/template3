<template>
	<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
		<div class="container-fluid">
			<router-link class="navbar-brand" :to="{ name: 'home' }"
				>TOSEN</router-link
			>
			<button
				class="navbar-toggler"
				type="button"
				data-bs-toggle="collapse"
				data-bs-target="#main_nav"
				aria-expanded="false"
				aria-label="Toggle navigation"
			>
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="main_nav">
				<ul class="navbar-nav">
					<li class="nav-item active">
						<router-link :to="{ name: 'home' }" class="nav-link">
							Home
						</router-link>
					</li>
					<li class="nav-item" v-if="!isLogged">
						<router-link :to="{ name: 'login' }" class="nav-link">
							Login
						</router-link>
					</li>
				</ul>
			</div>
			<!-- navbar-collapse.// -->
		</div>
		<!-- container-fluid.// -->
	</nav>
</template>

<script>
export default {};
</script>

<style>
</style>