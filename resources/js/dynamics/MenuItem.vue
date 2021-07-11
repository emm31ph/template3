<template>

	<li
		class="1"
		v-if="item.access"
		:class="item.level >= 2 && index == 0 ? 'p1' : false"
	>
		<router-link
			:to="{ name: item.link }"
			:class="item.childs != null ? 'fly' : ''"
			>{{ item.title }}</router-link
		>
		<template v-if="item.childs  != null">
			<ul>
				<menu-item
					v-for="(r, i) in item.childs"
					:key="i"
					:item="r"
					:index="i"
				>
				</menu-item> 
			</ul>
		</template>
	</li>
</template>

<script>
export default {
	name: "menu-item",
	props: {
		item: {
			type: Object,
		},
		sub: {
			type: Number,
			default: 0,
		},
		index: {
			type: Number,
			default: 0,
		},
	},
};
</script>

<style></style>
