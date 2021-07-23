<template>
	<div
		class="myMultiselect"
		:style="`z-index:{index}`"
		@click="handleClick"
		@blur="focused = false"
		tabindex="-1"
		ref="parent"
	>
		<div
			class="myMultiselect__selected"
			v-for="(option, i) in formattedOptions"
			:key="i"
			v-show="option.checked"
		>
			{{ option[displayProperty] }}
			<span class="myMultiselect__remove" @click="handleOptionClick(i)"
				>&times;</span
			>
		</div>
		<div
			class="myMultiselect__options"
			v-show="focused"
			:style="{ top: optionsTop }"
			@click="preventClose"
		>
			<div
				class="myMultiselect__option"
				:class="{ 'myMultiselect__option--checked': option.checked }"
				v-for="(option, i) in formattedOptions"
				:key="i"
				@click="handleOptionClick(i)"
			>
				<div class="myMultiselect__checkbox"></div>
				<div class="myMultiselect__text">
					{{ option[displayProperty] }}
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	data() {
		return {
			focused: false,
			optionsTop: "34px;",
		};
	},
	props: {
		options: {
			type: Array,
			default: () => [],
		},
		value: {
			default: () => [],
		},
		placeholder: {
			type: String,
			default: "Select",
		},
		index: {
			type: Number,
			default: 1,
		},
		displayProperty: {
			type: String,
			default: "name",
		},
		valueProperty: {
			type: String,
			default: "value",
		},
		required: {
			default: false,
		},
	},
	computed: {
		formattedOptions() {
			let fo = this.options.map((option) => {
				let checked = this.value.some(
					(v) => v === option[this.valueProperty]
				);

				return { ...option, checked };
			});
			return fo;
		},
	},
	mounted() {
		this.fixTop();
	},
	methods: {
		fixTop() {
			this.optionsTop = this.$refs.parent.clientHeight + 2 + "px";
		},
		handleClick() {
			this.focused = !this.focused;
		},
		handleOptionClick(i) {
			let clickedValue = this.options[i][this.valueProperty];

			let newValue = [...this.value];

			let existIndex = this.value.indexOf(clickedValue);

			if (existIndex === -1) {
				newValue.push(clickedValue);
			} else {
				newValue.splice(existIndex, 1);
			}

			this.$emit("input", newValue);
			setTimeout(this.fixTop, 100);
		},
		preventClose(e) {
			e.stopPropagation();
		},
	},
};
</script>

<style>
.myMultiselect {
	background: #fff;
	padding: 6px 12px;
	margin: 8px 0;
	display: inline-block;
	border: 1px solid #ccc;
	border-radius: 4px;
	box-sizing: border-box;
	min-height: 33px;
	min-width: 222px;
	position: relative;
	display: flex;
	flex-wrap: wrap;
}
.myMultiselect:focus {
	outline: none;
}
.myMultiselect__placeholder {
	border: 1px solid #e0e0e0;
	padding: 4px 8px;
	padding-right: 0;
	margin: 3px 3px;
}
.myMultiselect__selected {
	position: relative;
	display: inline-block;
	padding: 4px 26px 4px 10px;
	border-radius: 5px;
	margin-right: 10px;
	color: #fff;
	line-height: 1;
	background: #41b883;
	margin-bottom: 5px;
	white-space: nowrap;
	overflow: hidden;
	max-width: 100%;
	text-overflow: ellipsis;
	text-transform: uppercase;
}
.myMultiselect__remove {
	cursor: pointer;
	margin-left: 7px;
	position: absolute;
	right: 0;
	top: 0;
	bottom: 0;
	font-weight: 700;
	font-style: normal;
	width: 22px;
	text-align: center;
	line-height: 22px;
	transition: all 0.2s ease;
	border-radius: 5px;
}
.myMultiselect__remove:hover {
	content: "\D7";
	color: #266d4d;
	font-size: 14px;
}
.myMultiselect__options {
	position: absolute;
	top: 34px;
	right: 0;
	left: 0;
	display: flex;
	background: #fff;
	flex-direction: column;
	box-shadow: 0 3px 3px 2px #e3e3e3;
	padding: 5px 0;
	min-height: 55px;
	max-height: 180px;
	overflow-y: auto;
	z-index: 1000;
}
.myMultiselect__option {
	padding: 6px 11px;
	cursor: pointer;
	display: flex;
	align-items: center;
	z-index: 1000;
}
.myMultiselect__option--checked {
	color: #1f7bb8;
	font-weight: bold;
	z-index: 1000;
}
.myMultiselect__checkbox {
	width: 22px;
	height: 22px;
	border: 1px solid #969696;
	position: relative;
	margin-right: 2px;
	border-radius: 15px;
	z-index: 1000;
}
.myMultiselect__option--checked .myMultiselect__checkbox {
	border: 1px solid #1f7bb8;
	background: #1f7bb8;
	z-index: 1000;
}
.myMultiselect__option--checked .myMultiselect__checkbox:after {
	width: 11px;
	height: 6px;
	border-left: 2px solid rgb(255, 255, 255);
	border-bottom: 2px solid rgb(255, 255, 255);
	content: "";
	z-index: 999;
	position: absolute;
	transform: rotate(-45deg);
	left: 4px;
	top: 6px;
}
.myMultiselect__text {
	text-transform: uppercase;
}
</style>