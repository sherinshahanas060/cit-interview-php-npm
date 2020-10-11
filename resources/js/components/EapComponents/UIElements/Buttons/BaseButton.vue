<template>
    <component
        :is="tag"
        :to="to"
        :type="tag === 'button' ? nativeType : ''"
        :disabled="disabled || loading"
        @click="handleClick"
        class="btn btn-theme"
        :class="[
            { [`rounded-${rounded}`]: rounded },
            { 'btn-block': block },
            { 'btn-wd': wide },
            { 'btn-icon btn-fab': icon },
            { [`btn-${type}`]: type && !outline },
            { [`btn-${size}`]: size },
            { [`${color}`]: color },
            { [`${background}`]: background },
            { [`btn-outline-${type}`]: outline && type },
            { 'btn-link': link },
            { disabled: disabled && tag !== 'button' }
        ]"
    >
        <slot name="loading">
            <i v-if="loading" class="fas fa-spinner fa-spin"></i>
        </slot>
        <slot name="icon" v-if="icon">
            <i
                v-if="type == 'edit'"
                class="fa fa-edit blue"
                :class="iconClasses"
            ></i>
            <i
                v-else-if="type == 'delete'"
                class="fa fa-trash red"
                :class="iconClasses"
            ></i>
            <i
                v-else-if="type == 'add'"
                class="fa fa-plus"
                :class="iconClasses"
            ></i>
            <i
                v-else-if="type == 'import'"
                class="fa fa-file"
                :class="iconClasses"
            ></i>
            <i
                v-else-if="type == 'close'"
                class="fas fa-times"
                :class="iconClasses"
            ></i>
            <i v-else :class="iconClasses"></i>
        </slot>
        <slot>
            {{ text }}
        </slot>
    </component>
</template>
<script>
export default {
    name: "base-button",
    props: {
        tag: {
            type: String,
            default: "button",
            description: "Button html tag"
        },
        rounded: {
            type: String,
            description: "Button rounded shapes"
        },
        round: Boolean,
        icon: Boolean,
        block: Boolean,
        loading: Boolean,
        wide: Boolean,
        disabled: Boolean,
        type: {
            type: String,
            default: "default",
            description: "Button type (primary|secondary|danger etc)"
        },
        nativeType: {
            type: String,
            default: "button",
            description: "Button native type (e.g button, input etc)"
        },
        size: {
            type: String,
            default: "",
            description: "Button size (sm|lg)"
        },
        color: {
            type: String,
            default: "",
            description: "Button font color"
        },
        background: {
            type: String,
            default: "",
            description: "Button background"
        },
        text: {
            type: [String, Number],
            description: "Button inner text"
        },
        iconClasses: {
            type: [String, Object, Array],
            description: "Button pre icon css classes"
        },
        to: {
            type: Object,
            description: "router link"
        },
        outline: {
            type: Boolean,
            description: "Whether button is outlined (only border has color)"
        },
        link: {
            type: Boolean,
            description: "Whether button is a link (no borders or background)"
        }
    },
    methods: {
        handleClick(evt) {
            this.$emit("click", evt);
        }
    }
};
</script>
<style scoped lang="scss">
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
.btn-default{
    background: #2d48c5;
    background-color: #2d48c5 !important;
    color: #fff !important;
}
.btn-edit{
    background: #2d48c5;
    background-color: #2d48c5 !important;
    color: #fff !important;
}
.btn-lg {
    height: auto;
    padding: 0.8rem 2.75rem;
}
i {
    padding: 0 3px;
}
.btn-import {
    background: #2d48c5;
    background-color: #2d48c5 !important;
    color: #fff !important;
}
</style>
