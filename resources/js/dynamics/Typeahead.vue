<template>
	<div
		style="position: relative"
		:class="[classes, disable ? 'disabled' : '']"
	>
		<div style="display: flex; flex-direction: row; z-index: 1">
			<div
				class=""
				style="
					z-index: 1;
					width: 100%;
					display: flex;
					flex-direction: row;
					justify-content: space-between;
				"
			>
				<div
					:class="[classes, disable ? 'disabled' : '']"
					class=""
					style="z-index: 1; width: 100%; height: 20px"
					@click="toggleVisible"
					v-text="selectedItem[filterby]"
				></div>
				<div
					v-if="selectedItem == ''"
					v-text="datavalue === '' ? title : datavalue"
					style="position: absolute; z-index: 1"
				></div>

				<button
					style="
						background-color: Transparent;
						background-repeat: no-repeat;
						border: none;
						cursor: pointer;
						overflow: hidden;
						outline: none;
					"
					@click="selectedItem = ''"
					v-if="selectedItem"
				>
					<i class="fas fa-times-circle"></i>
				</button>
			</div>
		</div>
		<div
			style="z-index: 900; left: -2; top: 5px"
			class="position-relative w-100"
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
							:class="
								match[addOnDisplay1] == null
									? 'col-10'
									: 'col-8'
							"
						>
							{{ match[filterby] }}
						</div>
						<div class="col-2 px-0 text-right">
							{{ match[addOnDisplay] }}
						</div>
						<div
							class="col-2 px-0 text-right"
							:class="
								match[addOnDisplay1] == null ? 'd-none' : ''
							"
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
		filterby2: {
			type: String,
			default: "",
		},
		filterby3: {
			type: String,
			default: "",
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
			selectedItem: "",
			selected: 0,
			query: "",
			visible: false,
		};
	},

	methods: {
		toggleVisible() {
			if (!this.disable) {
				this.visible = !this.visible;
				setTimeout(() => {
					this.$refs.input.focus();
				}, 50);
			}
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

			return this.items.filter((item) =>
				// item[this.filterby]
				// 	.toLowerCase()
				// 	//.startsWith(this.query) //search start left side
				// 	.includes(this.query.toLowerCase()) //search match letter
				{
					{
						if (
							item[this.filterby]
								.toLowerCase()
								// .startsWith(this.query) //search start left side
								.includes(this.query.toLowerCase())
						) {
							return (
								item[this.filterby]
									.toLowerCase()
									// .startsWith(this.query) //search start left side
									.includes(this.query.toLowerCase())
							);
						}
						if (this.filterby2 != "") {
							if (
								item[this.filterby2]
									.toLowerCase()
									// .startsWith(this.query) //search start left side
									.includes(this.query.toLowerCase())
							) {
								return (
									item[this.filterby2]
										.toLowerCase()
										// .startsWith(this.query) //search start left side
										.includes(this.query.toLowerCase())
								);
							}
						}
						if (this.filterby3 != "") {
							if (
								item[this.filterby3]
									.toLowerCase()
									// .startsWith(this.query) //search start left side
									.includes(this.query.toLowerCase())
							) {
								return (
									item[this.filterby3]
										.toLowerCase()
										// .startsWith(this.query) //search start left side
										.includes(this.query.toLowerCase())
								);
							}
						}
					}
				}
			);
		},
	},
};
</script>

<style scoped>
.disabled {
	background-color: #f2f2f2;
}
</style>
