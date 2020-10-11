<template>
    <div class="" :class="[{ 'has-error': errors }, formClasses]">
        <slot name="label">
            <label v-if="label" :class="labelClasses">
                {{ label }}
            </label>
        </slot>
        <div class="custom-file">
            <input
                type="file"
                class="custom-file-input"
                id="customFileLang"
                lang="en"
                v-bind="$attrs"
                v-on="listeners"
            />
            <label
                class="custom-file-label"
                :class="[
                    { [`rounded-${rounded}`]: rounded },
                    { [`input-${size}`]: size },
                    { 'is-valid': valid === true },
                    { 'is-invalid': errors },
                    inputClasses
                ]"
                for="customFileLang"
            >
                {{ browsLabel }}
            </label>
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
</template>
<script>
export default {
    name: "file-input",
    inheritAttrs: false,
    props: {
        initialLabel: {
            type: String,
            default: "Select file"
        },
        valid: {
            type: Boolean,
            description: "Whether is valid",
            default: undefined
        },
        label: {
            type: String,
            description: "Input label (text before input)"
        },
        errors: {
            type: [String, Object, Array],
            description: "Input error (below input)"
        },
        inputClasses: {
            type: [String, Object, Array],
            description: "Select css classes"
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
            files: []
        };
    },
    computed: {
        listeners() {
            return {
                ...this.$listeners,
                change: this.fileChange
            };
        },
        browsLabel() {
            let fileNames = [];
            for (let file of this.files) {
                fileNames.push(file.name);
            }
            return fileNames.length ? fileNames.join(", ") : this.initialLabel;
        }
    },
    methods: {
        fileChange(evt) {
            this.files = evt.target.files;
            this.$emit("change", evt);
        }
    }
};
</script>
<style></style>
