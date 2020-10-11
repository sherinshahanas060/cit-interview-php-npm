<template>
    <component
        :is="tag"
        :to="to"
        :type="tag === 'button' ? nativeType : ''"
        :disabled="disabled || loading"
        @click="handleClick"
        class="btn eap-btn"
        :class="[
            { [`btn-${type}`]: type && !outline },
            { [`btn-${size}`]: size },
            { [`${color}`]: color },
            { [`${background}`]: background },
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
            default: "sm",
            description: "Button size (xs|sm|md|lg)"
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
.eap-btn {
    // color: #fff;
    border-radius: 50px;
    text-align: center;
    font-size: 1.5em;
    // -webkit-box-shadow: 0px 3px 9px rgba(0, 0, 0, 0.2);
    // box-shadow: 0px 3px 9px rgba(0, 0, 0, 0.2);
    // -webkit-transition: transform 0.3s ease-in-out;
    // transition: transform 0.3s ease-in-out;
    border: 1px solid #efefef;
    line-height: 36px;
    i {
        font-size: 16px;
    }
    &:hover {
        background: #2d48c5;
        i {
            color: #fff !important;
        }
    }
}
.btn-xs {
    width: 25px;
    height: 25px;
    line-height: 14px;
    padding: 0;
    i {
        font-size: 12px;
    }
}
.btn-sm {
    width: 40px;
    height: 40px;
}
</style>
