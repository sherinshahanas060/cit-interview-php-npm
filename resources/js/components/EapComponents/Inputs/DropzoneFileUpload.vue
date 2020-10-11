<template>
    <div class="" :class="[{ 'has-error': errors }, formClasses]">
        <slot name="label">
            <label v-if="label" :class="labelClasses">
                {{ label }}
            </label>
        </slot>
        <div class="input-group">
            <vue-dropzone
                ref="dropzone"
                id="drop1"
                title="File"
                :options="dropOptions"
                class="col"
                :class="[{ [`input-${size}`]: size }, inputGroupClasses]"
                v-on:vdropzone-removed-file="removeThisDoc"
                @vdropzone-complete="afterCompleteDoc"
            ></vue-dropzone>
        </div>
        <slot name="error" v-if="errors">
            <div v-for="(error, index) in errors" :key="index">
                <div class="invalid-feedback d-block" v-html="error"></div>
            </div>
        </slot>
    </div>
</template>
<script>
import vue2Dropzone from "vue2-dropzone";
export default {
    components: {
        vueDropzone: vue2Dropzone
    },
    props: {
        label: {
            type: String,
            description: "Input label (text before input)"
        },
        multiple: Boolean,
        labelClasses: {
            type: String,
            description: "Input label css classes",
            default: "form-control-label"
        },
        fileType: {
            type: String,
            description:
                "image, .pdf,.doc,.xls,.docx,.xlsx,.jpg,.png,.gif,.jpeg",
            default: ".pdf,.doc,.xls,.docx,.xlsx,.jpg,.png,.gif,.jpeg"
        },
        preview: {
            type: Boolean,
            description: "Show Preview",
            default: true
        },
        inputGroupClasses: {
            type: [String, Object, Array],
            description: "Input group css classes"
        },
        errors: {
            type: [String, Object, Array],
            description: "Input error (below input)"
        },
        formClasses: {
            type: [String, Object, Array],
            description: "Input form css classes"
        },
        size: {
            type: String,
            description: "Input size"
        }
    },
    data() {
        return {
            attachments: [],
            attachment: "",
            dropOptions: {
                url: window.routes.fileUpload,
                // acceptedFiles:
                //     ".pdf,.doc,.xls,.docx,.xlsx,.jpg,.png,.gif,.jpeg",
                headers: {
                    "X-CSRF-TOKEN": document.head.querySelector(
                        "[name=csrf-token]"
                    ).content
                },
                previewsContainer: !this.preview ? false : null,
                maxFiles: !this.multiple ? 1 : null,
                acceptedFiles:
                    this.fileType == "image" ? "image/*" : this.fileType,
                addRemoveLinks: true
            }
        };
    },
    methods: {
        removeThisDoc(file) {
            if (!this.multiple) {
                // this.attachment.splice(file.name.replace(/ /g, "_"), 1);
                this.attachment = "";
                this.$emit("input", this.attachment);
            }
        },
        afterCompleteDoc(file) {
            if (!this.multiple) {
                // this.attachment.push(file.name.replace(/ /g, "_"));
                this.attachment = file.name.replace(/ /g, "_");
                this.$emit("input", this.attachment);
            }
        }
    }
};
</script>
<style scoped lang="scss">
.input-sm {
    min-height: 80px;
}
</style>
