<template>
    <div class="eap-input" :class="[{ 'has-error': errors }, formClasses]">
        <slot name="label">
            <label v-if="label" :class="labelClasses">
                {{ label }}
            </label>
        </slot>
        <div
            :class="[
                { 'input-group input-group-merge': hasIcon },
                { focused: focused },
                { 'input-group-alternative': alternative },
                { 'has-label': label || $slots.label },
                inputGroupClasses
            ]"
        >
            <div
                v-if="prependIcon || $slots.prepend"
                class="input-group-prepend"
            >
                <span class="input-group-text">
                    <slot name="prepend">
                        <i :class="prependIcon"></i>
                    </slot>
                </span>
            </div>
            <slot v-bind="slotData">
                <input
                    :value="value"
                    :type="type"
                    v-on="listeners"
                    v-bind="$attrs"
                    :valid="!errors"
                    :placeholder="placeholder"
                    :required="required"
                    class="form-control"
                    :class="[
                        { [`rounded-${rounded}`]: rounded },
                        { [`input-${size}`]: size },
                        { 'is-valid': valid === true },
                        { 'is-invalid': errors },
                        inputClasses
                    ]"
                />
            </slot>
            <div v-if="appendIcon || $slots.append" class="input-group-append">
                <span class="input-group-text">
                    <slot name="append">
                        <i :class="appendIcon"></i>
                    </slot>
                </span>
            </div>
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
    inheritAttrs: false,
    name: "base-input",
    props: {
        required: {
            type: Boolean,
            description: "Whether input is required (adds an asterix *)"
        },
        group: {
            type: Boolean,
            description:
                "Whether input is an input group (manual override in special cases)"
        },
        valid: {
            type: Boolean,
            description: "Whether is valid",
            default: undefined
        },
        placeholder: {
            type: String,
            description: "Whether is placeholder",
            default: ""
        },
        alternative: {
            type: Boolean,
            description: "Whether input is of alternative layout"
        },
        label: {
            type: String,
            description: "Input label (text before input)"
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
        labelClasses: {
            type: [String, Object, Array],
            description: "Input label css classes",
            default: "form-control-label"
        },
        inputClasses: {
            type: [String, Object, Array],
            description: "Input css classes"
        },
        inputGroupClasses: {
            type: [String, Object, Array],
            description: "Input group css classes"
        },
        value: {
            type: [String, Number],
            description: "Input value"
        },
        type: {
            type: String,
            description: "Input type",
            default: "text"
        },
        appendIcon: {
            type: String,
            description: "Append icon (right)"
        },
        prependIcon: {
            type: String,
            description: "Prepend icon (left)"
        },
        rounded: {
            type: String,
            description: "Input rounded shapes"
        },
        size: {
            type: String,
            default: "sm",
            description: "Input size"
        }
    },
    data() {
        return {
            focused: false
        };
    },
    computed: {
        listeners() {
            return {
                ...this.$listeners,
                input: this.updateValue,
                focus: this.onFocus,
                blur: this.onBlur
            };
        },
        slotData() {
            return {
                focused: this.focused,
                errors: this.errors,
                ...this.listeners
            };
        },
        hasIcon() {
            const { append, prepend } = this.$slots;
            return (
                append !== undefined ||
                prepend !== undefined ||
                this.appendIcon !== undefined ||
                this.prependIcon !== undefined ||
                this.group
            );
        }
    },
    methods: {
        updateValue(evt) {
            let value = evt.target.value;
            this.$emit("input", value);
        },
        onFocus(evt) {
            this.focused = true;
            this.$emit("focus", evt);
        },
        onBlur(evt) {
            this.focused = false;
            this.$emit("blur", evt);
        }
    }
};
</script>
<style scoped lang="scss">
.eap-input {
    .input-sm {
        padding: 1.375rem 0.75rem;
        border: 1px solid #efefef;
    }
    .input-lg {
        padding: 1.6rem 0.75rem;
        font-size: 16px !important;
    }
}
</style>
