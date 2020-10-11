<template>
    <div class="" :class="[{ 'has-error': errors }, formClasses]">
        <slot name="label">
            <label v-if="label" :class="labelClasses">
                {{ label }}
            </label>
        </slot>
        <div class="input-group">
            <multiselect
                v-model="selected"
                label="name"
                :track-by="trackBy"
                placeholder="Type to search"
                open-direction="bottom"
                :options="options"
                :multiple="true"
                :searchable="true"
                :loading="isLoading"
                :internal-search="false"
                :clear-on-select="false"
                :close-on-select="false"
                :options-limit="optionLimit"
                :limit="imit"
                :limit-text="limitText"
                :max="max"
                :max-height="600"
                :show-no-results="false"
                :hide-selected="true"
                @search-change="asyncFind"
            >
                <!--<template slot="tag" slot-scope="{ option, remove }"
                    ><span class="custom__tag"
                        ><span>{{ option.name }}</span
                        ><span class="custom__remove" @click="remove(option)"
                            >❌</span
                        ></span
                    ></template
                >-->
                <template slot="clear" slot-scope="props">
                    <div
                        class="multiselect__clear"
                        v-if="selected.length"
                        @mousedown.prevent.stop="clearAll(props.search)"
                    ></div> </template
                ><span slot="noResult"
                    >Oops! No elements found. Consider changing the search
                    query.</span
                >
            </multiselect>
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
        optionLimit: {
            type: Number,
            description: "max number of options"
        },
        label: {
            type: String,
            description: "Select label (text before input)"
        },
        // options: {
        //     type: Array,
        //     description: "Select options",
        //     default: () => []
        // },
        errors: {
            type: [String, Object, Array],
            description: "Input error (below input)"
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
        trackBy: {
            type: String,
            default: "id",
            description: "which needs to track"
        },
        findUrl: {
            type: String,
            description: "ajax request url"
        },
        formClasses: {
            type: [String, Object, Array],
            description: "Input form css classes"
        },
        imit: {
            type: Number,
            description: "limits the visible results"
        },
        max: {
            type: Number,
            description: "limits the Selection"
        }
    },
    data() {
        return {
            selected: [],
            isLoading: false,
            options: []
        };
    },
    methods: {
        limitText(count) {
            return `and ${count} other options`;
        },
        asyncFind(query) {
            if (query) {
                this.isLoading = true;
                axios
                    .get(this.findUrl + "/" + query)
                    .then(response => {
                        this.isLoading = false;
                        if (response.data.status == 100) {
                            this.options = response.data.data;
                        }
                    })
                    .catch(errors => {
                        this.isLoading = false;
                    });
            }
            // ajaxFindCountry(query).then(response => {
            //     this.options = response;
            //     this.isLoading = false;
            // });
        },
        clearAll() {
            this.selected = [];
        }
    },
    watch: {
        selected(newVal, oldVal) {
            this.$emit("input", this.selected);
        }
    }
};
</script>
