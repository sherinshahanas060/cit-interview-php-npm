<template>
    <div class="" :class="[{ 'has-error': errors }, formClasses]">
        <slot name="label">
            <label v-if="label" :class="labelClasses">
                {{ label }}
            </label>
        </slot>
        <div class="input-group">
            <multiselect
                v-model="mvalue"
                v-on="listeners"
                :tag-placeholder="tagPlaceHolder"
                :placeholder="placeholder"
                label="name"
                :track-by="trackBy"
                class="dropdaown-select2"
                :class="[
                    { 'is-invalid': errors },
                    { [`rounded-${rounded}`]: rounded },
                    inputClasses
                ]"
                :options="options"
                :multiple="multiple"
                :taggable="taggable"
                :limit="limit"
                :limit-text="limitText"
                :max="max"
                @select="select"
                @tag="tag"
                @Input="inputChange"
                @remove="removeTag"
                @search-change="searchChange"
                @open="open"
                @close="close"
            ></multiselect>
        </div>
        <slot name="error" v-if="errors">
            <div v-for="(error, index) in errors" :key="index">
                <div class="invalid-feedback d-block" v-html="error"></div>
            </div>
        </slot>
    </div>
</template>
<script>
export default {
    props: {
        multiple: {
            type: Boolean,
            default: true,
            description: "Is multiple"
        },
        limit: {
            type: Number,
            description: "limits the visible results"
        },
        max: {
            type: Number,
            description: "limits the Selection"
        },
        taggable: {
            type: Boolean,
            default: true,
            description: "Is taggable"
        },
        label: {
            type: String,
            description: "Select label (text before input)"
        },
        options: {
            type: Array,
            description: "Select options"
        },
        errors: {
            type: [String, Object, Array],
            description: "Input error (below input)"
        },
        tagPlaceHolder: {
            type: String,
            description: "Select tag-placeholder",
            default: ""
        },
        trackBy: {
            type: String,
            default: "id",
            description: "which needs to track"
        },
        placeholder: {
            type: String,
            description: "Select placeholder"
        },
        rounded: {
            type: String,
            description: "Input rounded shapes"
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
        formClasses: {
            type: [String, Object, Array],
            description: "Input form css classes"
        },
        ivalue: {
            type: [String, Array, Object],
            description: "Initial Value",
            default: null
        },
        createUrl: {
            type: String,
            description: "Create new tag url",
            default: null
        },
        removeUrl: {
            type: String,
            description: "url for remove from database",
            default: null
        }
    },
    data() {
        return {
            mvalue: []
        };
    },
    methods: {
        limitText() {},
        searchChange(searchQuery, id) {},
        inputChange(value, id) {},
        select(selectedOption, id) {},
        tag(newTag) {
            this.$emit("tag", newTag);
            if (this.createUrl) {
                axios
                    .post(this.createUrl, { name: newTag })
                    .then(response => {
                        if (response.data.status == 100) {
                            let track = this.trackBy;
                            let option = {
                                [track]: response.data.data.id,
                                name: newTag
                            };
                            if (!this.multiple) {
                                this.mvalue = option;
                            } else {
                                this.mvalue.push(option);
                            }
                        } else {
                            toast.fire({
                                title: "Faild to add",
                                type: "warning"
                            });
                        }
                    })
                    .catch(errors => {
                        toast.fire({
                            title: "Faild to add",
                            type: "warning"
                        });
                    });
            }
        },
        removeTag(removedOption, id) {
            if (this.removeUrl && removedOption.id) {
                axios
                    .post(this.removeUrl, removedOption)
                    .then(response => {
                        if (response.data.status == 100) {
                            this.$emit("removeTagDone", removedOption);
                        } else {
                            toast.fire({
                                type: "warning",
                                title: "Warning"
                            });
                        }
                    })
                    .catch(errors => {
                        toast.fire({
                            type: "warning",
                            title: "Warning"
                        });
                    });
            }
            this.$emit("removeTag", removedOption);
        },
        open(id) {},
        close(value, id) {}
    },
    computed: {
        listeners() {
             this.mvalue = this.ivalue;
        }
    },
    watch: {
        mvalue(newVal, oldVal) {
            this.$emit("input", newVal);
        },
        // ivalue() {
        //     console.log(this.ivalue)
        //     this.mvalue = this.ivalue;
        // }
    }
};
</script>
<style scoped lang="scss">
.input-large {
    padding: 2rem 0.75rem;
    font-size: 16px !important;
}
</style>
