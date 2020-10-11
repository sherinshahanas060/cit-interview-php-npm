
<template>
    <div class="" :class="[{ 'has-error': errors }, formClasses]">
        <slot name="label">
            <label v-if="label" :class="labelClasses">
                {{ label }}
            </label>
        </slot>
        <div class="input-group">
            <Select2
                v-model="value"
                @change="changeEvent($event)"
                @select="selectEvent($event)"
                name="select"
                :options="options"
                :id="id"
                :title="label ? label : 'Select'"
                class="dropdaown-select2 w-100"
                :class="[
                    { [`rounded-${rounded}`]: rounded },
                    { [`input-${size}`]: size },
                    { 'is-valid': valid === true },
                    { 'is-invalid': errors },
                    inputClasses
                ]"
            ></Select2>
            <slot name="infoBlock"></slot>
            <slot name="error" v-if="errors">
                <div v-for="(error, index) in errors" :key="index">
                    <div class="invalid-feedback d-block" v-html="error"></div>
                </div>
            </slot>
            <slot name="success">
                <div class="valid-feedback" v-if="!errors && valid">
                    {{ successMessage }}
                </div>
            </slot>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        id:{
            type: [String, Number],
            default:'select-2',
            description:"Id for select"
        },
        label: {
            type: String,
            description: "Select label (text before input)"
        },
        options: {
            type: Array,
            description: "Select options"
        },
        valid: {
            type: Boolean,
            description: "Whether is valid",
            default: undefined
        },
        labelClasses: {
            type: [String, Object, Array],
            description: "Select label css classes",
            default: "form-control-label"
        },
        inputClasses: {
            type: [String, Object, Array],
            description: "Select css classes"
        },
        errors: {
            type: [String, Object, Array],
            description: "Input error (below input)"
        },
        successMessage: {
            type: String,
            description: "Input success message",
            default: "Looks good!"
        },
        formClasses: {
            type: [String, Object, Array],
            description: "Input form css classes"
        },
        rounded: {
            type: String,
            description: "Input rounded shapes"
        },
        size: {
            type: String,
            description: "Input size"
        }
    },
    data() {
        return {
            value: ""
        };
    },
    methods: {
        changeEvent(val) {
            this.$emit("select", val);
        },
        selectEvent({ id, text }) {
            this.$emit("input", id);
        }
    }
};
</script>
<style lang="scss">
.rounded-0 {
    .select2-container--default .select2-selection--single {
        border-radius: 0 !important;
    }
}
</style>
