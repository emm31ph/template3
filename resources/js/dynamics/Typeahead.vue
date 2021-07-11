<template>
	<div class="position-relative">
		<div style="display: flex; flex-direction: row; z-index: 1">
			<div class="input-group" style="z-index: 1">
				<div
					:class="[classes,(disable)?'disabled':'']"
					class="no-clear search-typeahead"
					style="z-index: 1"
					@click="toggleVisible"
					v-text="selectedItem ? selectedItem[filterby] : datavalue"
				></div>
				<div
					class="form-control-sm"
					v-if="selectedItem == null"
					v-text="title"
					style="position: absolute; z-index: 1"
				></div>
				<div class="input-group-append">
					<button
						class="btn btn-sm btn-info"
						@click="selectedItem = null"
						v-if="selectedItem"
					>
						<i class="fas fa-times-circle"></i>
					</button>
				</div>
			</div>
		</div>
		<div 
			style="z-index: 2050"
			class="position-absolute w-100"
			v-if="!disable"
			v-show="visible"
		>
			<input
				type="text"
				ref="input"
				:index="`${this._index}`"
				v-model="query"
				@keydown.up="up"
				@keydown.down="down"
				@keydown.enter="selectItem"
				placeholder="Start Typing..."
				class="form-control form-control-sm"
				style="z-index: 2000"
			/>
			<div
				ref="optionsList"
				style="max-height: 200px; overflow-y: scroll; z-index: 2050"
				class="my-1 border-bottom"
			>
				<ul class="list-group">
					<li
						class="list-group-item d-flex flex-row p-1"
						v-for="(match, index) in matches"
						:key="index"
						:class="{ selected: selected == index }"
						@click="itemClicked(index)"
					>
						<div
							:class="match[addOnDisplay1] == null? 'col-10': 'col-8'"
						>
							{{ match[filterby] }}
						</div>
						<div class="col-2 px-0 text-right">
							{{ match[addOnDisplay] }}
						</div>
						<div
							class="col-2 px-0 text-right"
							:class="match[addOnDisplay1] == null ? 'd-none' : ''"
						>
							{{ match[addOnDisplay1] }}
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: "typeahead",
	props: {
		_index: {
			type: String,
			default: "",
		},
		get index() {
			return this._index;
		},
		set index(value) {
			this._index = value;
		},
		classes: {
			type: String,
			default: "",
		},
		disable: {
			type: Boolean,
			default: false,
		},
		
		datavalue: {
			type: String,
			default: "",
		},
		items: {
			default: () => [],
			type: Array,
		},
		filterby: {
			type: String,
		},
		addOnDisplay: {
			type: String,
		},

		addOnDisplay1: {
			type: String,
		},
		title: {
			default: "Select One...",
			type: String,
		},
		shouldReset: {
			type: Boolean,
			default: true,
		},
	},
	data() {
		return {
			itemHeight: 39,
			selectedItem: '',
			selected: 0,
			query: "",
			visible: false,
		};
	},
	methods: {
		toggleVisible() {
			this.visible = !this.visible;
			setTimeout(() => {
				this.$refs.input.focus();
			}, 50);
		},
		itemClicked(index) {
			this.selected = index;
			this.selectItem();
		},
		selectItem() {
			if (!this.matches.length) {
				return;
			}
			this.selectedItem = this.matches[this.selected];
			this.visible = false;
			if (this.shouldReset) {
				this.query = "";
				this.selected = 0;
			}

			const d1 = this.selectedItem;
			d1.id = this.index;
			d1["index"] = d1["id"];
			const d2 = JSON.stringify(d1);
			const d3 = JSON.parse(d2);
			this.$emit("selected", d3);
		},
		up() {
			if (this.selected == 0) {
				return;
			}
			this.selected -= 1;
			this.scrollToItem();
		},
		down() {
			if (this.selected >= this.matches.length - 1) {
				return;
			}
			this.selected += 1;
			this.scrollToItem();
		},
		scrollToItem() {
			this.$refs.optionsList.scrollTop = this.selected * this.itemHeight;
		},
	},
	computed: {
		matches() {
			this.$emit("change", this.query);
			if (this.query == "") {
				return [];
			}

			// let matches = this.items.filter((item) => {
			// 	const regex = new RegExp(`^${this.query}`, "gi");

			// 	return this.items.match(regex) || this.items.abbr.match(regex);
			// });

			return this.items.filter(
				(item) =>
					item[this.filterby]
						.toLowerCase()
						//.startsWith(this.query) //search start left side
						.includes(this.query.toLowerCase()) //search match letter
			);
		},
	},
};
</script>

<style scoped>
.disabled{
	background-color:#f2f2f2;
}
</style>
