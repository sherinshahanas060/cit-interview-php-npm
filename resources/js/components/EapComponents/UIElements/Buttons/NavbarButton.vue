<template>
    <button
        class="nav-link btn"
        type="button"
        @click="handleClick"
        :class="[
            { active: active },
            { disabled: disabled },
            { [`btn-${size}`]: size },
            { [`rounded-${rounded}`]: rounded },
            buttonClasses
        ]"
        :data-toggle="dataToggles"
        :aria-controls="target"
        :aria-selected="toggled"
        :href="`#${target}`"
        role="tab"
        aria-label="Toggle navigation"
    >
        <slot></slot>
        <slot name="icon" v-if="icon">
            <i v-if="iconClasses" :class="iconClasses"></i>
            <i v-else class="fas fa-spinner fa-spin"></i>
        </slot>
    </button>
</template>
<script>
export default {
    props: {
        icon: Boolean,
        rounded: {
            type: String,
            description: "Button rounded shapes"
        },
        disabled: {
            type: Boolean,
            description: "Button disabled",
            default: false
        },
        target: {
            type: [String, Number],
            description: "Button target element"
        },
        buttonClasses: {
            type: [String, Object, Array],
            description: "Button css classes"
        },
        active: {
            type: Boolean,
            default: false,
            description: "Active tab"
        },
        size: {
            type: String,
            default: "",
            description: "Button size (xs|sm|lg)"
        },
        toggled: {
            type: Boolean,
            default: false,
            description: "Whether button is toggled"
        },
        dataToggles: {
            type: String,
            default: "pill",
            description: "pills, tabs, collaps etc..."
        },
        iconClasses: {
            type: [String, Object, Array],
            description: "Button pre icon css classes"
        }
    },
    methods: {
        handleClick(evt) {
            this.$emit("click", evt);
        }
    }
};
</script>
<style lang="scss" scoped>
.btn-xs {
    padding: 1px 10px;
    border: 1px solid #6a6a6a;
}
.btn-sm {
    padding: 5px 10px;
    border: 1px solid #6a6a6a;
}
.btn-md {
    border: 1px solid #6a6a6a;
}
</style>
